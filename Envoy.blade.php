@servers(['localhost' => '127.0.0.1', 'fridzema' => 'root@188.226.137.26'])
  @setup
      $path = "/var/www/html";
      require __DIR__.'/vendor/autoload.php';
			(new \Dotenv\Dotenv(__DIR__, '.env'))->load();
			$silent_output = false;

			$path = "/var/www/html";
			$repositoryName = "photo";
			$repositoryUser = "fridzema";

			function logMessage($message) {
				return "echo '\033[1;32m" .$message. "\033[0m';\n";
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
  @endmacro

  @task('clean_current_dir', ['on' => 'fridzema'])
  	{{ logMessage("👋  Directory cleanup...") }}
    cd {{ $path }};
    rm -rf *;
  @endtask

  @task('git', ['on' => 'fridzema'])
  	{{ logMessage("⛓  Cloning the repository ".$repositoryUser."/".$repositoryName."...") }}
    cd {{ $path }};
    git clone --depth 1 https://github.com/{{$repositoryUser}}/{{$repositoryName}}.git --quiet;
  @endtask

  @task('fix_permissions', ['on' => 'fridzema'])
  	{{ logMessage("🔓  Fixing file permissions...") }}
  	cd {{ $path }};
    chmod 755 -R {{$repositoryName}};

    cd {{ $path }}/{{$repositoryName}};
    chmod -R o+w storage;
  @endtask

  @task('copy_env', ['on' => 'fridzema'])
  	{{ logMessage("⚠️  Copy the env production file...") }}
    cd {{ $path }}/{{$repositoryName}};
    cp .env.production .env;
  @endtask

	@task('composer', ['on' => 'fridzema'])
		{{ logMessage("🚚  Running composer...") }}
		cd {{ $path }}/{{$repositoryName}};
		composer install --prefer-dist --no-scripts --no-dev -o;
	@endtask

  @task('optimize', ['on' => 'fridzema'])
		{{ logMessage("🏎  Speed things up a bit up...") }}
    cd {{ $path }}/{{$repositoryName}};
    php artisan clear-compiled -q;
		php artisan optimize -q;
    php artisan cache:clear -q;
    php artisan view:clear -q;
    php artisan route:cache -q;
    php artisan config:cache -q;
  @endtask

  @task('migrate_seed', ['on' => 'fridzema'])
  	{{ logMessage("⚙️  Build and fill the database...") }}
    cd {{ $path }}/{{$repositoryName}};
		php artisan migrate:refresh --seed --force -q;
  @endtask

  @task('restart_services', ['on' => 'fridzema'])
  	{{ logMessage("🛁  Keep it fresh...") }}
  	service mysql --full-restart;
    service nginx --full-restart;
    service php7.0-fpm --full-restart;
   	service redis-server --full-restart;
  @endtask