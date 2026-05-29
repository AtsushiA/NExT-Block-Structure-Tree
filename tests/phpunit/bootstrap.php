<?php
/**
 * PHPUnit bootstrap file for Integration tests.
 */

// Composer autoloader.
require_once dirname( __DIR__, 2 ) . '/vendor/autoload.php';

// WordPress test library.
require getenv( 'WP_TESTS_DIR' ) . '/includes/functions.php';

/**
 * Load the plugin under test.
 */
function _manually_load_plugin() {
	require dirname( __DIR__, 2 ) . '/next-block-structure-tree.php';
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

// Bootstrap WordPress test environment.
require getenv( 'WP_TESTS_DIR' ) . '/includes/bootstrap.php';
