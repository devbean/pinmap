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
    wp_enqueue_script(
        'pinmap',
        PINMAP_PLUGIN_URL . '/scripts/pinmap.js',
        array( 'jquery' )
    );
}

add_action( 'admin_enqueue_scripts', 'pinmap_scripts' );
add_action( 'edit_form_after_editor', 'pinmap_pinpostdiv' );

function pinmap_pinpostdiv() {
?>
    <div id="pinmapdiv" class="postbox">
        <div title="<?php _e('Click to Switch'); ?>" class="handlediv"><br></div><h3 class="hndle"><span><?php _e( 'Pin This Post in Map' ); ?></span></h3>
        <div class="inside">
            <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <ul>
                    <li><label for="fname">Family Name (Sir Name)<span> *</span>: </label>
                        <input id="fname" maxlength="45" size="10" name="fname" value="" /></li>

                    <li><label for="lname">Last Name<span> *</span>: </label>
                        <input id="lname" maxlength="45" size="10" name="lname" value="" /></li>
                </ul>
            </form>
        </div>
    </div>
<?php
}
