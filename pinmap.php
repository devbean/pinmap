<?php
/**
 * @package pinmap
 * @version 0.0.1
 */
/*
Plugin Name: pinmap
Plugin URI: http://wordpress.galaxyworld.org/pinmap
Description: Pin your post in a map.
Author: devbean
Version: 0.0.1
Author URI: http://www.devbean.net
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

define( 'PINMAP_VERSION', '0.0.1' );
define( 'PINMAP_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . dirname( plugin_basename( __FILE__ ) ) );
define( 'PINMAP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

include_once PINMAP_PLUGIN_DIR . '/pinmap_options.php';

add_action( 'admin_notices', 'hello_world' );

function hello_world() {
    $chosen = PINMAP_PLUGIN_DIR;
    echo "<p>$chosen</p>";
}
