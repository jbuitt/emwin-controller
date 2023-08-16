
# EMWIN Controller

This software provides a download client and web dashboard for downloading "products" from EMWIN ([Emergency Managers Weather Information Network](https://www.nws.noaa.gov/emwin/)). EMWIN is a satellite data collection and dissemination system operated by the [National Weather Service](http://weather.gov). Its purpose is to provide state and federal government, commercial users, media and private citizens with timely delivery of meteorological, hydrological, climatological and geophysical information. Besides satellite transmission, EMWIN is also able to disseminate its products through the use of [ByteBlaster](https://www.weather.gov/emwin/byteblaster) servers. The National Weather Service stopped hosting their own ByteBlaster servers several years ago, however several individuals have resurrected a new network of public ByteBlaster servers.

This client was developed and tested on [Ubuntu 22.04](http://ubuntu.com) (64-bit) and Raspberry Pi OS (64-bit) using the following open-source software stack:

* [Docker](https://www.docker.com/) - Container tool
* [docker-compose](https://docs.docker.com/compose/) - Multi-container orchestration tool
* [PHP](https://www.php.net/) - Scripting language
* [Composer](http://getcomposer.org/) - Dependency manager for PHP
* [Laravel](https://laravel.com/) - PHP framework
* [Sail](https://laravel.com/docs/10.x/sail) - Laravel command-line interface for Laravel's Docker environment 
* [Livewire](https://laravel-livewire.com/) - Laravel dynamic front-end framework
* [NodeJS](https://nodejs.org/en) - JavaScript runtime environment
* [TailwindCSS](https://tailwindcss.com/) - CSS framework
* [MySQL](https://www.mysql.com/) - Relational database
* [Redis](https://redis.io/) - Key/value store
* [Soketi](https://docs.soketi.app/) - Websocket server
* [NOAAPort Npemwin](http://www.noaaport.net/projects/emwin.html) - EMWIN ByteBlaster client. 

## How do I run it?

*Please see the disclaimer below if you wish to run this software on a Raspberry Pi.*

Asuming you already have Docker and Docker Compose [installed](https://github.com/jbuitt/emwin-controller/blob/main/scripts/install_docker.sh), just following the instructions below:

1. First, clone the repo and change directory:

```
git clone https://github.com/jbuitt/emwin-controller.git
cd emwin-controller/
```

2. Copy the desired file you want Docker Compose to use.

```
cp docker-compose-minimal.yml docker-compose.yml

# or

cp docker-compose-full.yml docker-compose.yml   # usually what you want
```

3. Copy the example env file to the file to source in the next step:

```
cp sail.env.example sail.env
```

4. Next, source the env file and build all of the Docker images:

```
source sail.env
docker compose build
```

5. Now, install all the PHP dependencies:

```
docker run --rm --interactive --tty \
  -e WWWUSER=$(id -u) \
  --volume $PWD:/var/www/html \
  emwin-controller:latest \
  composer install -ovn 
```

6. Copy the `.env.example` file to `.env` and make your environment variable changes (documented below).
   
7. Create an Laravel App Key:

```
docker run --rm --interactive --tty \
  -e WWWUSER=$(id -u) \
  --volume $PWD:/var/www/html \
  emwin-controller:latest \
  ./artisan key:generate --force
```

8. Now, install the front-end dependencies:

```
docker run --rm --interactive --tty \
  -e WWWUSER=$(id -u) \
  --volume $PWD:/var/www/html \
  emwin-controller:latest \
  npm i

docker run --rm --interactive --tty \
  -e WWWUSER=$(id -u) \
  --volume $PWD:/var/www/html \
  emwin-controller:latest \
  npm run build
```

9. Next, download the other container images and start everything up by running:

```
./vendor/bin/sail up -d
```

10. Now, you migrate and seed the database:

```
./vendor/bin/sail artisan migrate \
   --seed \
   --force
```

11. Create the symbolic link so the web server has access to files in the storage directory:

```
./vendor/bin/sail artisan storage:link
```

12. Finally, you can access the dashboard from a browser by going to [http://127.0.0.1:8080](http://127.0.0.1:8080).

You'll need an admin user to log into the dashboard, create one first by running:

```
./vendor/bin/sail artisan emwin-controller:create_admin_user
```

## Running on a Raspberry Pi

If you would like to run this software on a Raspberry Pi, I recommend using a Raspberry Pi 4 Model B with either 4 or 8 GB of
memory booting from a quality solid-state drive. Running on a Pi Zero, 1, or 3 -or- booting from a MicroSD card is *not* 
recommended due to the poor performance you're likely to have.

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
