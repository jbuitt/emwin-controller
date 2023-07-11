
# EMWIN Controller

This software provides a download client and web dashboard for downloading "products" from EMWIN ([Emergency Managers Weather Information Network](https://www.nws.noaa.gov/emwin/)). EMWIN is a satellite data collection and dissemination system operated by the [National Weather Service](http://weather.gov). Its purpose is to provide state and federal government, commercial users, media and private citizens with timely delivery of meteorological, hydrological, climatological and geophysical information. Besides satellite transmission, EMWIN is also able to disseminate its products through the use of [ByteBlaster](https://www.weather.gov/emwin/byteblaster) servers. The National Weather Service stopped hosting their own ByteBlaster servers several years ago, however several individuals have resurrected a new network of public ByteBlaster servers.

This client was developed and tested on [Ubuntu 22.04](http://ubuntu.com) using the following open-source software stack:

* [Docker](https://www.docker.com/) - Container tool
* [docker-compose](https://docs.docker.com/compose/) - Multi-container orchestration tool
* [PHP](https://www.php.net/) - Scripting Language
* [Composer](http://getcomposer.org/) - Dependency Manager for PHP
* [Laravel](https://laravel.com/) - PHP Framework
* [Sail](https://laravel.com/docs/10.x/sail) - Laravel Sail command-line interface for Laravel's Docker environment 
* [Livewire](https://laravel-livewire.com/) - Laravel Dynamic Front-end Framework
* [NodeJS](https://nodejs.org/en) - JavaScript runtime environment
* [TailwindCSS](https://tailwindcss.com/) - CSS framework
* [MySQL](https://www.mysql.com/) - Relational Database
* [Redis](https://redis.io/) - Cache
* [Soketi](https://docs.soketi.app/) - Websocket server
* [NOAAPort Npemwin](http://www.noaaport.net/projects/emwin.html) - EMWIN ByteBlaster client. 

## How do I run it?

Asuming you already have Docker and Docker Compose [installed](https://github.com/jbuitt/emwin-controller/blob/main/scripts/install_docker.sh), just following the instructions below:

1. First, clone the repo and change directory:

```
git clone https://github.com/jbuitt/emwin-controller
cd emwin-controller/
```

2. Next, source the env file and build all of the Docker images:

```
source sail.env
docker compose build
```

3. Now, install the PHP dependencies:

```
docker run --rm --interactive --tty \
  --volume $PWD:/var/www/html \
  --entrypoint /usr/local/bin/install_php_deps.sh \
  sail-8.2/app:latest
```

4. Copy the `.env.example` file to `.env` and make your environment variable changes (documented below).
   
5. Create an Laravel App Key:

```
docker run --rm --interactive --tty \
  --volume $PWD:/var/www/html \
  --entrypoint /var/www/html/artisan \
  sail-8.2/app:latest \
  key:generate
```

6. Now, install the front-end dependencies:

```
docker run --rm --interactive --tty \
  --volume $PWD:/var/www/html \
  --entrypoint /usr/local/bin/install_fe_deps.sh \
  sail-8.2/app:latest
```

7. Next, download the other containers and start everything up by running:

```
docker compose up -d
```

8. Now, you migrate and seed the database:

```
docker compose exec -it emwin-controller \
   /var/www/html/artisan migrate \
   --seed \
   --force
```

9. Create the symbolic link so the web server has access to files in the storage directory:

```
./vendor/bin/sail artisan storage:link
```

10. Finally, you can access the dashboard from a browser by going to [http://127.0.0.1:8080](http://127.0.0.1:8080).

You'll need an admin user to log into the dashboard, create one first by running:

```
./vendor/bin/sail artisan emwin-controller:create_admin_user
```

## .env Environment Variables

The following environment variables will need to be set:

```
APP_KEY=
```

This is the Application Key required by Laravel. Step #5 above will generate a key and populate this variable in your `.env` file.

Other variables that can be modified from their default values:

* `APP_NAME` - The name of this app. (Shows up in the browser tab and dashboard)
* `APP_ENV` - Laravel App Environment. You'll want to use `production`.
* `APP_DEBUG` - Debug mode. Typically will want this set to `false`.
* `APP_URL` - Base URL for the app. Running in Docker, you would normally set to `http://127.0.0.1:8080`. 

* `DONT_FORCE_HTTPS` - Specifies whether the UI should generate https:// URLS. Unless you're proxying using certificates, this should be `true`. 
* `NPEMWIN_CLIENT_SERVERLIST` - Comma-delimited list of one or more servers with their port separated by a colon. (e.g. `host1:port1,host2:port2,...`). You can get a list of current servers [here](https://www.weathermessage.com/Support/EMWINInternetStatus.aspx).
* `FILE_SAVE_REGEX` - Regular expression used to specify which products you want to save. Default is `.*`. (match all products)
* `KEEP_LOGS_DAYS` - Number of days to keep log files. This is to help so you don't fill up your filesystem.
* `KEEP_PRODUCTS_DAYS` - Number of days to keep product files. This is to help so you don't fill up your filesystem.
* `NPEMWIN_CLIENT_AUTOSTART` - Flag (`0` or `1`) to specify whether you want to run `npemwind` upon startup.
* `ENABLED_PAN_PLUGINS` - Comma-deleted list of plugins to run. You can leave this blank if you don't want to use the plugin system.

## Plugins

EMWIN Console includes a "plugin" system that gives you the option to take some action when a product is downloaded. For example, you could write a plugin that sends you Tornado Warnings matching a specific Weather Forecast Office via SMS text message.

More to come..

## Author

+	[jbuitt at gmail.com](mailto:jbuitt@gmail.com)

## License

See [LICENSE](https://github.com/jbuitt/emwin-console/blob/main/LICENSE) file.
