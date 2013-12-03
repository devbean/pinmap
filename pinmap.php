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
define( 'PINMAP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PINMAP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

include_once PINMAP_PLUGIN_DIR . '/pinmap_options.php';

function pinmap_scripts() {
    wp_enqueue_style( 'pinmap', PINMAP_PLUGIN_URL . '/style/pinmap.css' );
    wp_enqueue_script(
        'pinmap',
        PINMAP_PLUGIN_URL . '/scripts/pinmap.js',
        array( 'jquery' )
    );
    $options = get_option( 'pinmap_options' );
    $map_api = isset( $options['map_api'] ) ? $options['map_api'] : '';
    $map_key = isset( $options['map_key'] ) ? $options['map_key'] : '';
    if ( ! empty( $map_api ) && ! empty( $map_key ) ) {
        switch ( $map_api ) {
            case 'gmap3':
                wp_enqueue_script(
                    'google_map_v3',
                    "https://maps.googleapis.com/maps/api/js?key=$map_key&sensor=false");
                wp_enqueue_script(
                    'gmap3',
                    PINMAP_PLUGIN_URL . '/scripts/gmap3.min.js',
                    array( 'jquery' )
                );
                break;
        }
    }
}

add_action( 'admin_enqueue_scripts', 'pinmap_scripts' );
add_action( 'add_meta_boxes', 'pinmap_pinpostdiv' );

function pinmap_pinpostdiv()
{
    $screens = array( 'post', 'page' );
    foreach ( $screens as $screen ) {
        add_meta_box(
            'pinpostdiv',
            __( 'Pin the Post in Map' ),
            'pinmap_pinpostdiv_content',
            $screen
        );
    }
}

function pinmap_pinpostdiv_content()
{
?>
    <label for="pinmap_post_placename">Where is this post take place?</label>
    <input type="text" name="pinmap_post_placename" id="pinmap_post_placename" style="width:300px" />
    <input type="button" id="pinmap_btn_searchplace" class="button" value="Search Place" />
    <div id="pinmap_mapdiv"></div>
<?php
}