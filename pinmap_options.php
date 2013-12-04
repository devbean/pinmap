<?php

define( PINMAP_PLUGIN_MENU_ID, 'pinmap-info-conf' );

/*
 * Add menu page to Options.
 */
function pinmap_plugin_menu() {
    add_options_page(
        'Pinmap Options',
        'Pinmap',
        'manage_options',
        PINMAP_PLUGIN_MENU_ID,
        'pinmap_options_display'
    );
}
add_action( 'admin_menu', 'pinmap_plugin_menu' );

/*
 * Display option page.
 */
function pinmap_options_display() {
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    ?>
    <div class="wrap">
        <?php screen_icon(); ?>
        <h2 class="pinmap-header">Pinmap Options</h2>
        <form method="post" action="options.php">
            <form method="post" action="options.php">
                <?php settings_fields( 'pinmap_options' ); ?>
                <?php do_settings_sections( 'pinmap_options' ); ?>
                <?php submit_button(); ?>
            </form>
        </form>
    </div>
<?php
}

/*
 * Init plugin options to white list our options.
 */
function pinmap_options_init() {
    // If the plugin options don't exist, create them.
    if( false == get_option( 'pinmap_options' ) ) {
        add_option( 'pinmap_options' );
    }

    add_settings_section(
        'pinmap_map_settings_section',
        'Map API Settings',
        'pinmap_map_settings_callback',
        'pinmap_options'
    );

    add_settings_field(
        'map_api',
        'Map API',
        'pinmap_map_api_callback',
        'pinmap_options',
        'pinmap_map_settings_section',
        array(
            'Map API that you want to use.'
        )
    );

    add_settings_field(
        'map_key',
        'Map Key',
        'pinmap_map_key_callback',
        'pinmap_options',
        'pinmap_map_settings_section',
        array(
            'Key for the map API you selected.'
        )
    );

    register_setting(
        'pinmap_options',
        'pinmap_options'
    );
}
add_action( 'admin_init', 'pinmap_options_init' );

function pinmap_map_settings_callback() {
    echo '<p>Select which map API you want to use. <i>Current only <strong>Google Maps JavaScript API v3</strong> is available.</i></p>';
}

function pinmap_map_api_callback($args) {
    $options = get_option( 'pinmap_options' );
    $map_api = isset( $options['map_api'] ) ? esc_attr( $options['map_api'] ) : '';
?>
    <select id="map_api" name="pinmap_options[map_api]">
        <option value="gmap3" <?php selected( $map_api, 'gmap3' ); ?>>Google Maps JavaScript API v3</option>
    </select>
    <label for="map_api"><?php _e( $args[0] ); ?></label>
<?php
}

function pinmap_map_key_callback($args) {
    $options = get_option( 'pinmap_options' );
    $map_key = isset( $options['map_key'] ) ? esc_attr( $options['map_key'] ) : '';
    ?>
    <input type="text" id="map_key" name="pinmap_options[map_key]" value="<?php echo $map_key; ?>" style="width:340px" />
    <label for="map_key"><?php _e( $args[0] ); ?></label>
<?php
}
