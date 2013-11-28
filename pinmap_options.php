<?php
add_action( 'admin_init', 'pinmap_options_init' );
add_action( 'admin_menu', 'pinmap_plugin_menu' );

// Init plugin options to white list our options
function pinmap_options_init() {
    register_setting( 'pinmap_options', 'pinmap', 'pinmap_validate' );
}

// Sanitize and validate input. Accepts an array, return a sanitized array.
function pinmap_validate($input) {
    // Our first value is either 0 or 1
    $input['option1'] = ( $input['option1'] == 1 ? 1 : 0 );

    // Say our second option must be safe text with no HTML tags
    $input['sometext'] =  wp_filter_nohtml_kses($input['sometext']);

    return $input;
}

// Add menu page
function pinmap_plugin_menu() {
    add_options_page( 'Pinmap Options', 'Pinmap', 'manage_options', 'pinmap-info-conf', 'pinmap_plugin_options' );
}

function pinmap_plugin_options() {
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
?>
    <div class="wrap">
        <?php screen_icon(); ?>
        <h2 class="pinmap-header">Pinmap</h2>
        <form method="post" action="options.php">
            <?php settings_fields('pinmap_options'); ?>
            <?php $options = get_option('pinmap'); ?>
            <table class="form-table">
                <tr valign="top"><th scope="row"><?php _e('Select Map API'); ?></th>
                    <td>
                        <select name="pinmap_options[api]">
                            <option value="gmap3">Google Maps JavaScript API v3</option>
                        </select>
                    </td>
                </tr>
                <tr valign="top"><th scope="row">Some text</th>
                    <td><input type="text" name="ozh_sample[sometext]" value="<?php echo $options['sometext']; ?>" /></td>
                </tr>
            </table>
            <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
            </p>
        </form>
    </div>
<?php
}