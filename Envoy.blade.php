@servers(['test' => 'www-data@192.168.36.220', 'prod' => 'www-data@X.X.X.X'])

@setup
    $on_servers = ['on' => $env];
    $gitlab_url = 'https://git.sm-lan.net';
    $num_controllers = 2;
    $releases_to_keep = 5;
    $releases = array();
    for ($i=0; $i<$num_controllers; $i++) {
        array_push($releases, date('YmdHis'));
        sleep(1);
    }
@endsetup

@story('deploy')
    download_build
    setup_new_env
    shutdown_old_docker
    startup_new_docker
    clean_up
@endstory

@task('download_build', $on_servers)
    @for ($i=1; $i<=$num_controllers; $i++)
        echo 'EMWIN Controller - Creating release directory (if it does not already exist)..'
        [ -d "/var/www/emwin-controller{{ $i }}/releases/{{ $releases[$i-1] }}" ] || mkdir -p /var/www/emwin-controller{{ $i }}/releases/{{ $releases[$i-1] }}/
        echo 'EMWIN Controller - Changing directory to new release directory..'
        cd /var/www/emwin-controller{{ $i }}/releases/{{ $releases[$i-1] }}/
        echo 'EMWIN Controller - Downloading build artifacts..'
        curl --progress-bar --header 'PRIVATE-TOKEN: {{ $token }}' {{ $gitlab_url }}/api/v4/projects/{{ $project }}/jobs/{{ $job }}/artifacts --output /tmp/artifacts.zip
        echo 'EMWIN Controller - Extracting build artifacts into /var/www/emwin-controller{{ $i }}/releases/{{ $releases[$i-1] }}/..'
        /usr/bin/unzip -qq /tmp/artifacts.zip
        if [[ $? != 0 ]]; then
            echo "Error: Artifacts file could not be unzipped."
            exit 1
        fi
        rm -f /tmp/artifacts.zip
    @endfor
@endtask

@task('setup_new_env', $on_servers)
    @for ($i=1; $i<=$num_controllers; $i++)
        echo 'EMWIN Controller - Changing directory to new release directory..'
        cd /var/www/emwin-controller{{ $i }}/releases/{{ $releases[$i-1] }}/

        echo "EMWIN Controller - Creating .env file.."
        cp /var/www/emwin-controller{{ $i }}/persistent/.env .env

        echo "EMWIN Controller - Creating sail.env file.."
        cp /var/www/emwin-controller{{ $i }}/persistent/sail.env sail.env

        echo "EMWIN Controller - Creating docker-compose.yml file.."
        cp /var/www/emwin-controller{{ $i }}/persistent/docker-compose.yml docker-compose.yml

        if [[ -e "/var/www/emwin-controller{{ $i }}/persistent/plugins.json" ]]; then
           echo "EMWIN Controller - Creating plugins.json file.."
           cp /var/www/emwin-controller{{ $i }}/persistent/plugins.json plugins.json
        fi
    @endfor
@endtask

@task('shutdown_old_docker', $on_servers)
    @for ($i=1; $i<=$num_controllers; $i++)
        echo 'EMWIN Controller - Changing directory to current directory..'
        cd /var/www/emwin-controller{{ $i }}/current/

        echo 'EMWIN Controller - Exporting $COMPOSE_PROJECT_NAME..'
        export COMPOSE_PROJECT_NAME=$(cat /var/www/emwin-controller{{ $i }}/COMPOSE_PROJECT_NAME)

        echo 'EMWIN Controller - Shutting down current Docker containers..'
        source sail.env
        docker compose down

        cd /var/www/emwin-controller{{ $i }}/

        echo 'EMWIN Controller - Replace current release symlink..'
        ln -nfs /var/www/emwin-controller{{ $i }}/releases/{{ $releases[$i-1] }} /var/www/emwin-controller{{ $i }}/current
    @endfor
@endtask

@task('startup_new_docker', $on_servers)
    @for ($i=1; $i<=$num_controllers; $i++)
        echo 'EMWIN Controller - Changing directory to current directory..'
        cd /var/www/emwin-controller{{ $i }}/current/

        echo 'EMWIN Controller - Exporting $COMPOSE_PROJECT_NAME..'
        export COMPOSE_PROJECT_NAME={{ $releases[$i-1] }}

        echo 'EMWIN Controller - Starting new Docker containers..'
        source sail.env
        docker compose up -d

        # Check to make sure Laravel API is up and responding to requests
        while true; do
            RESULTS=$(curl -sf http://127.0.0.1:${APP_PORT}/api/status || echo '{"statusCode":503,"message":"Service Unavailable","details":[]}')
            # echo "\$RESULTS = #$RESULTS#"
            if [[ $(echo $RESULTS | jq -r .statusCode) == "200" ]]; then
                break
            fi
            sleep 1
        done

        echo 'EMWIN Controller - Creating storage symlink..'
        docker exec {{ $releases[$i-1] }}-emwin_controller-1 ./artisan storage:link

        echo 'EMWIN Controller - Installing plug-ins..'
        docker exec {{ $releases[$i-1] }}-emwin_controller-1 su - sail -c "cd /var/www/html/ && ./artisan emwin-controller:install_plugins"

        echo 'EMWIN Controller - Running database migrations..'
        docker exec {{ $releases[$i-1] }}-emwin_controller-1 ./artisan migrate --seed --force --isolated

        echo 'EMWIN Controller - Running npm run build (again)..'
        docker exec {{ $releases[$i-1] }}-emwin_controller-1 su - sail -c "cd /var/www/html/ && npm run build"
    @endfor
@endtask

@task('clean_up', $on_servers)
    @for ($i=1; $i<=$num_controllers; $i++)
        echo 'EMWIN Controller - Changing directory to current directory..'
        cd /var/www/emwin-controller{{ $i }}/current/

        echo "EMWIN Controller - Clearing bootstrapped files.."
        docker exec {{ $releases[$i-1] }}-emwin_controller-1 ./artisan optimize:clear

        echo "EMWIN Controller - Restart Queue Worker.."
        docker exec {{ $releases[$i-1] }}-emwin_controller-1 ./artisan queue:restart

        echo 'EMWIN Controller - Updating COMPOSE_PROJECT_NAME..'
        echo {{ $releases[$i-1] }} >/var/www/emwin-controller{{ $i }}/COMPOSE_PROJECT_NAME

        echo 'EMWIN Controller - Removing old releases..'
        NUM_RELEASES=$(ls /var/www/emwin-controller{{ $i }}/releases/ | wc -l)
        if [[ $NUM_RELEASES -gt {{ $releases_to_keep }} ]]; then
            let NUM_RELEASES_TO_DELETE=$NUM_RELEASES-{{ $releases_to_keep }}
            for dir in $(ls /var/www/emwin-controller{{ $i }}/releases/ | head -n $NUM_RELEASES_TO_DELETE); do
                echo "EMWIN Controller - Deleting /var/www/emwin-controller{{ $i }}/releases/$dir .."
                rm -rf /var/www/emwin-controller{{ $i }}/releases/$dir
            done
        else
            echo 'EMWIN Controller - No old releases to remove.'
        fi
    @endfor
@endtask
