@servers(['localhost' => '127.0.0.1', 'fridzema' => 'root@104.236.23.198'])
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

  @macro('deploy_clean_server')
    clean_current_dir
    git
    fix_permissions
    copy_env
    composer
    migrate_seed
    optimize
    restart_services
    congratulations
  @endmacro

  @task('clean_current_dir', ['on' => 'fridzema'])
  	{{ taskLog("Directory cleanup...", "👋") }}
    cd {{ $path }};
    rm -rf *;
  @endtask

  @task('git', ['on' => 'fridzema'])
  	{{ taskLog("Cloning the repository ".$repositoryUser."/".$repositoryName."...", "⛓") }}
    cd {{ $path }};
    git clone --depth 1 https://github.com/{{$repositoryUser}}/{{$repositoryName}}.git --quiet;
  @endtask

  @task('fix_permissions', ['on' => 'fridzema'])
  	{{ taskLog("Fixing file permissions...", "🔓") }}
    cd {{ $path }}/{{$repositoryName}};
    sudo chmod -R o+w storage/;
		sudo chmod -R 775 storage/;
  @endtask

  @task('copy_env', ['on' => 'fridzema'])
  	{{ taskLog("Copy the env production file...", "⚙️") }}
    cd {{ $path }}/{{$repositoryName}};
    cp .env.production .env;
  @endtask

	@task('composer', ['on' => 'fridzema'])
		{{ taskLog("Running composer...", "📦") }}
		cd {{ $path }}/{{$repositoryName}};
		composer install --prefer-dist --no-scripts --no-plugins --no-dev -o -q;
	@endtask

  @task('optimize', ['on' => 'fridzema'])
		{{ taskLog("Speed things up a bit up...", "🏎") }}
    cd {{ $path }}/{{$repositoryName}};
    php artisan clear-compiled -q;
		php artisan optimize -q;
    php artisan cache:clear -q;
    php artisan view:clear -q;
    php artisan route:cache -q;
    php artisan config:cache -q;
  @endtask

  @task('migrate_seed', ['on' => 'fridzema'])
  	{{ taskLog("Build and fill the database...", "🛠") }}
    cd {{ $path }}/{{$repositoryName}};
		php artisan migrate:refresh --seed --force -q;
  @endtask

  @task('restart_services', ['on' => 'fridzema'])
  	{{ taskLog("Keep it fresh...", "🛁") }}
  	service mysql --full-restart;
    service nginx --full-restart;
    service php7.0-fpm --full-restart;
   	service redis-server --full-restart;
  @endtask

  @task('congratulations', ['on' => 'fridzema'])
  	{{ taskLog("🙏🍾🍻🎂 DEPLOYED SUCCESFULLY 🎂🍻🍾🙏") }}
  	exit;
  @endtask