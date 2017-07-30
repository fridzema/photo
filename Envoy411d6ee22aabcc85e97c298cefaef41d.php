<?php $icon = isset($icon) ? $icon : null; ?>
<?php $message = isset($message) ? $message : null; ?>
<?php $repositoryUser = isset($repositoryUser) ? $repositoryUser : null; ?>
<?php $repositoryName = isset($repositoryName) ? $repositoryName : null; ?>
<?php $silent_output = isset($silent_output) ? $silent_output : null; ?>
<?php $path = isset($path) ? $path : null; ?>
<?php $__container->servers(['localhost' => '127.0.0.1', 'fridzema' => 'root@188.226.137.26']); ?>
  <?php
      $path = "/var/www/html";
      require __DIR__.'/vendor/autoload.php';
			(new \Dotenv\Dotenv(__DIR__, '.env'))->load();
			$silent_output = false;

			$path = "/var/www/html";
			$repositoryName = "photo";
			$repositoryUser = "fridzema";

			function logMessage($message, $icon = null) {
				$icon = ($icon) ? $icon . " " : "🔓";
				return "echo '\033[1;32m" . $icon . .$message. "\033[0m';\n";
			}
  ?>

  <?php $__container->startMacro('deploy_clean_server'); ?>
    clean_current_dir
    git
    fix_permissions
    copy_env
    composer
    migrate_seed
    optimize
    restart_services
  <?php $__container->endMacro(); ?>

  <?php $__container->startTask('clean_current_dir', ['on' => 'fridzema']); ?>
  	<?php echo logMessage("👋  Directory cleanup..."); ?>

    cd <?php echo $path; ?>;
    rm -rf *;
  <?php $__container->endTask(); ?>

  <?php $__container->startTask('git', ['on' => 'fridzema']); ?>
  	<?php echo logMessage("⛓  Cloning the repository ".$repositoryUser."/".$repositoryName."..."); ?>

    cd <?php echo $path; ?>;
    git clone --depth 1 https://github.com/<?php echo $repositoryUser; ?>/<?php echo $repositoryName; ?>.git --quiet;
  <?php $__container->endTask(); ?>

  <?php $__container->startTask('fix_permissions', ['on' => 'fridzema']); ?>
  	<?php echo logMessage("🔓  Fixing file permissions..."); ?>

    chown -R :www-data  <?php echo $path; ?>/<?php echo $repositoryName; ?>;
		chmod -R 755 <?php echo $path; ?>/<?php echo $repositoryName; ?>/storage;
  <?php $__container->endTask(); ?>

  <?php $__container->startTask('copy_env', ['on' => 'fridzema']); ?>
  	<?php echo logMessage("⚠️  Copy the env production file..."); ?>

    cd <?php echo $path; ?>/<?php echo $repositoryName; ?>;
    cp .env.production .env;
  <?php $__container->endTask(); ?>

	<?php $__container->startTask('composer', ['on' => 'fridzema']); ?>
		<?php echo logMessage("🚚  Running composer..."); ?>

		cd <?php echo $path; ?>/<?php echo $repositoryName; ?>;
		composer install --prefer-dist --no-scripts --no-dev -o -q;
	<?php $__container->endTask(); ?>

  <?php $__container->startTask('optimize', ['on' => 'fridzema']); ?>
		<?php echo logMessage("🏎  Speed things up a bit up..."); ?>

    cd <?php echo $path; ?>/<?php echo $repositoryName; ?>;
    php artisan clear-compiled -q;
		php artisan optimize -q;
    php artisan cache:clear -q;
    php artisan view:clear -q;
    php artisan route:cache -q;
    php artisan config:cache -q;
  <?php $__container->endTask(); ?>

  <?php $__container->startTask('migrate_seed', ['on' => 'fridzema']); ?>
  	<?php echo logMessage("⚙️  Build and fill the database..."); ?>

    cd <?php echo $path; ?>/<?php echo $repositoryName; ?>;
		php artisan migrate:refresh --seed --force -q;
  <?php $__container->endTask(); ?>

  <?php $__container->startTask('restart_services', ['on' => 'fridzema']); ?>
  	<?php echo logMessage("🛁  Keep it fresh..."); ?>

  	service mysql --full-restart;
    service nginx --full-restart;
    service php7.0-fpm --full-restart;
   	service redis-server --full-restart;
  <?php $__container->endTask(); ?>