@servers(['localhost' => '127.0.0.1', 'fridzema' => 'root@188.226.137.26'])

  @setup
      $path = "/var/www/html";
  @endsetup

  @task('set_down', ['on' => 'fridzema'])
    cd {{ $path }}
    php artisan down --message="Upgrading Website" --retry=20
  @endtask

  @task('git_composer', ['on' => 'fridzema'])
    cd {{ $path }}
    git fetch origin master
    git reset --hard FETCH_HEAD
    composer install
  @endtask

  @task('copy_env', ['on' => 'fridzema'])
    cd {{ $path }}
    rm -rf .env
    cp .env.production .env
  @endtask

  @task('cache', ['on' => 'fridzema'])
    cd {{ $path }}
    php artisan optimize
    php artisan cache:clear
    php artisan view:clear
    php artisan config:cache
    php artisan route:cache
    php artisan responsecache:flush
  @endtask

  @task('set_up', ['on' => 'fridzema'])
    cd {{ $path }}
    php artisan up
  @endtask

  @task('local_update', ['on' => 'localhost'])
    npm run production
    git add .
    git commit -m "Deploy to server"
    git push
  @endtask


  @task('restart_servers', ['on' => 'fridzema'])
    service nginx restart
    service php7.0-fpm restart
  @endtask

  @macro('deploy_all')
    local_update
    set_down
    git_composer
    copy_env
    set_up
    cache
    restart_servers
  @endmacro

  @macro('upload')
    set_down
    git_composer
    copy_env
    set_up
    cache
  @endmacro