@servers(['localhost' => '127.0.0.1', 'fridzema' => 'root@188.226.137.26'])
  @setup
      $path = "/var/www/html";
      require __DIR__.'/vendor/autoload.php';
			(new \Dotenv\Dotenv(__DIR__, '.env'))->load();
			$path = "/var/www/html";
			$repositoryName = "photo";
			$repositoryUser = "fridzema";

			function taskLog($message, $icon = null) {
				$delimiter = "  ";
				$icon = (isset($icon)) ? $icon . $delimiter : null;

				return "echo '\033[1;32m" . $icon . $message. "\033[0m';\n";
			}
  @endsetup

  @task('setup', ['on' => 'fridzema'])
  	{{ taskLog("Directory cleanup...", "👋") }}
    cd {{ $path }};
    rm -rf *;

  	{{ taskLog("Cloning the repository ".$repositoryUser."/".$repositoryName."...", "⛓") }}
    cd {{ $path }};
    git clone https://github.com/{{$repositoryUser}}/{{$repositoryName}}.git --quiet;

  	{{ taskLog("Fixing file permissions...", "🔓") }}
    cd {{ $path }};
    sudo chgrp -R www-data {{$repositoryName}};
    sudo chmod -R g+w {{$repositoryName}}/storage;
    sudo chmod -R g+w {{$repositoryName}}/public;

  	{{ taskLog("Copy the env production file...", "⚙️") }}
    cd {{ $path }}/{{$repositoryName}};
    cp .env.production .env;

		{{ taskLog("Running composer...", "📦") }}
		cd {{ $path }}/{{$repositoryName}};
		composer install --prefer-dist --no-scripts --no-plugins --no-dev -o -q;


  	{{ taskLog("Build and fill the database...", "🛠") }}
    cd {{ $path }}/{{$repositoryName}};
		php artisan migrate:refresh --seed --force -q;

		{{ taskLog("Speed things up a bit up...", "🏎") }}
    cd {{ $path }}/{{$repositoryName}};
    php artisan clear-compiled -q;
		php artisan optimize -q;
    php artisan cache:clear -q;
    php artisan view:clear -q;
    php artisan route:cache -q;
    php artisan config:cache -q;

  	{{ taskLog("Keep it fresh...", "🛁") }}
  	service mysql --full-restart;
    service nginx --full-restart;
    service php7.0-fpm --full-restart;
   	service redis-server --full-restart;

  	{{ taskLog("🙏🍾🍻🎂 DEPLOYED SUCCESFULLY 🎂🍻🍾🙏") }}
  @endtask

  @task('update', ['on' => 'fridzema'])
  	{{ taskLog("Pulling the repository ".$repositoryUser."/".$repositoryName."...", "⛓") }}
    cd {{ $path }}/{{$repositoryName}};
    git pull;

  	{{ taskLog("Copy the env production file...", "⚙️") }}
    cp .env.production .env;

		{{ taskLog("Running composer...", "📦") }}
		composer install --prefer-dist --no-scripts --no-plugins --no-dev -o -q;

		{{ taskLog("Speed things up a bit up...", "🏎") }}
    php artisan clear-compiled -q;
		php artisan optimize -q;
    php artisan cache:clear -q;
    php artisan view:clear -q;
    php artisan route:cache -q;
    php artisan config:cache -q;
    php artisan responsecache:flush -q;
    php artisan opcache:optimize -q;

  	{{ taskLog("Keep it fresh...", "🛁") }}
  	php artisan medialibrary:regenerate
  	service mysql --full-restart;
    service nginx --full-restart;
    service php7.0-fpm --full-restart;
   	service redis-server --full-restart;

  	{{ taskLog("🙏🍾🍻🎂 DEPLOYED SUCCESFULLY 🎂🍻🍾🙏") }}
  @endtask

