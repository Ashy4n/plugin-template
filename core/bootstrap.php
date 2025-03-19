<?php

if (!\defined('ABSPATH')) {
	die;
}

if ( \PHP_VERSION_ID > 70400 ) {
	require_once __DIR__ . '/autoload.php';


} else {
	add_action( 'admin_notices', function () {
		printf( '<div class="notice notice-error"><p>%s</p></div>',
			esc_html__( 'Your PHP version is too old. Please update to PHP 7.4 or higher.', 'plugin-template' ) );
	} );
}
