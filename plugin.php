<?php

/**
 * Plugin Name: WP Cricket Score
 * Plugin URI: https://github.com/gin0115/WP_Cricket_Scoring
 * Description: A sample (WordPress) Plugin built using the PinkCrab Perique framework, to create a pseudo real time cricket score board and historic game data.
 * Version: 0.1.0
 * Author: Glynn Quelch
 * Author URI: https://github.com/gin0115/WP_Cricket_Scoring
 * Text Domain: gin0115-cricket-score
 * Domain Path: /languages
 * Tested up to: 5.8
 * License: MIT
 **/

use eftec\bladeone\BladeOne;
use PinkCrab\Ajax\Ajax_Bootstrap;
use PinkCrab\BladeOne\BladeOne_Bootstrap;
use PinkCrab\Perique\Migration\Migrations;
use PinkCrab\Perique\Application\App_Factory;
use PinkCrab\Plugin_Lifecycle\Plugin_State_Controller;
use PinkCrab\Perique_Admin_Menu\Registration_Middleware\Page_Middleware;

// Trigger admin notice if no autoloader
if ( ! file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	add_action(
		'admin_notices',
		function (): void {
			$class   = 'notice notice-error';
			$message = __( 'It looks like the autoloader has been generated, please run "composer install --no-dev".', 'gin0115-cricket-score' );

			printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
		}
	);

	return;
}

// Other wise load plugin.

require_once __DIR__ . '/vendor/autoload.php';

// Load all config values.
$get_config = function( string $file ): array {
	return file_exists( __DIR__ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . $file )
	? require __DIR__ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . $file
	: array();
};

Ajax_Bootstrap::use();
BladeOne_Bootstrap::use(
	__DIR__ . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'views',
	null,
	BladeOne::MODE_DEBUG
);

$app = ( new App_Factory() )
	->with_wp_dice()
	->app_config( $get_config( 'app_config.php' ) )
	->di_rules( $get_config( 'dependencies.php' ) )
	->registration_classes( $get_config( 'registration.php' ) )
	->construct_registration_middleware( Page_Middleware::class )
	->boot();

// Create instance of plugin state controller
$psc        = Plugin_State_Controller::init( $app, __FILE__ );
$migrations = new Migrations( $psc );
$migrations->done();
$psc->finalise();
