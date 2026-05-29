<?php
/**
 * PHPUnit bootstrap file for Unit tests.
 */

// Define ABSPATH so plugin files can be required without triggering the guard exit.
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', '/tmp/wordpress/' );
}

require_once dirname( __DIR__, 3 ) . '/vendor/autoload.php';
