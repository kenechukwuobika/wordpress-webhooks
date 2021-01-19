<?php

/*
 * Whitelabel settings template
 */

$settings = wordpress_webhooks()->settings->get_whitelabel_settings();
$current_url_full = wordpress_webhooks()->helpers->get_current_url();
$license_key        = wordpress_webhooks()->settings->get_license('key');
$license_status = wordpress_webhooks()->settings->get_license('status');
$whitelabel_status = wordpress_webhooks()->settings->get_license('whitelabel');
$whitelabel_date = wordpress_webhooks()->settings->get_license('expires');
$is_expired = wordpress_webhooks()->license->is_expired($whitelabel_date);
$show_whitelabel_settings = false;

if ( ! empty( $license_key ) && $license_status !== false && $license_status === 'valid' && ! $is_expired ){
    if( empty( $whitelabel_status ) || $whitelabel_status !== 'yes' ){
        $response = wordpress_webhooks()->whitelabel->verify_whitelabel( array( 'license' => $license_key ) );
        if ( ! is_wp_error( $response ) ) {
            $license_data = json_decode( wp_remote_retrieve_body( $response ) );
            if( is_object( $license_data ) && isset( $license_data->success ) && $license_data->success === true ){
                wordpress_webhooks()->license->update( 'whitelabel', 'yes' );
                $show_whitelabel_settings = true;
            }
        }
    } else {
        $show_whitelabel_settings = true;
    }
}

if( $show_whitelabel_settings ) :

    if( did_action( 'ww_settings_saved' ) ){
        echo wordpress_webhooks()->helpers->create_admin_notice( 'The settings are successfully updated. Please refresh the page.', 'success', true );
    }

    ?>
    <h2><?php echo wordpress_webhooks()->helpers->translate('Whitelabel settings', 'admin-settings-license'); ?></h2>

    <div class="mb3">
        <?php echo sprintf(wordpress_webhooks()->helpers->translate( 'This is the hidden page for your whitelabel settings. Here, you will be able to configure all settings related to create a whitelabeled version of %1$s. To learn more about it, you can also check out our <a href="%2$s" target="_blank" >documentation</a>.', 'admin-settings-license' ), 'WP Webhooks Pro', 'https://ironikus.com/docs/knowledge-base/whitelabel-wp-webhooks-pro/'); ?>
    </div>

    <div class="ironikus-whitelabel-settings-wrapper">
        <form id="ironikus-whitelabel-settings-form" method="post" action="">

            <table class="table ww-settings-table form-table">
                <tbody>

                <?php foreach( $settings as $setting_name => $setting ) :

                    $is_checked = ( $setting['type'] == 'checkbox' && $setting['value'] == 'yes' ) ? 'checked' : '';
                    $value = ( $setting['type'] != 'checkbox' ) ? $setting['value'] : '1';
                    $is_checkbox = ( $setting['type'] == 'checkbox' ) ? true : false;
                    $is_textarea = ( $setting['type'] == 'textarea' ) ? true : false;

                ?>
                    <tr valign="top">
                        <td class="settings-input" >
                            <label for="<?php echo $setting_name; ?>">
                                <strong><?php echo $setting['label']; ?></strong>
                            </label>
                            <?php if( $is_checkbox ) : ?>
                                <label class="switch ">
                                    <input id="<?php echo $setting['id']; ?>" class="default primary" name="<?php echo $setting_name; ?>" type="<?php echo $setting['type']; ?>" class="regular-text" value="<?php echo $value; ?>" <?php echo $is_checked; ?> />
                                    <span class="slider round"></span>
                                </label>
                            <?php elseif( $is_textarea ) : ?>
                                    <textarea id="<?php echo $setting['id']; ?>" name="<?php echo $setting_name; ?>" placeholder="<?php echo $setting['placeholder']; ?>"><?php echo $value; ?></textarea>
                            <?php else : ?>
                                <input id="<?php echo $setting['id']; ?>" name="<?php echo $setting_name; ?>" type="<?php echo $setting['type']; ?>" placeholder="<?php echo $setting['placeholder']; ?>" class="regular-text" value="<?php echo $value; ?>" <?php echo $is_checked; ?> />
                            <?php endif; ?>
                        </td>
                        <td>
                            <p class="description">
                                <?php echo $setting['description']; ?>
                            </p>
                        </td>
                    </tr>
                <?php endforeach; ?>

                </tbody>
            </table>

            <p class="btn btn-primary h30 ironikus-submit-whitelabel-settings-data">
                <span class="ironikus-save-text active"><?php echo wordpress_webhooks()->helpers->translate( 'Save all', 'admin-settings' ); ?></span>
                <img class="ironikus-loader" src="<?php echo WW_PLUGIN_URL . 'includes/frontend/assets/img/loader.gif'; ?>" />
            </p>

        </form>
    </div>

<?php else : ?>
    <h2><?php echo wordpress_webhooks()->helpers->translate('Activate License', 'admin-settings-license'); ?></h2>

    <div class="mb3">
        <?php echo sprintf(wordpress_webhooks()->helpers->translate( 'To use the whitelabel feature, you must have an active WP Webhooks Pro Unlimited subscription with an active license. Please activate your license first or check out our comparison table to <a href="%2$s" target="_blank" >learn more</a>.', 'admin-settings-license' ), 'WP Webhooks Pro', 'https://ironikus.com/compare-wp-webhooks-pro/?utm_source=wp-webhooks-pro-compare&utm_medium=whitelabel-feature&utm_campaign=WP%20Webhooks%20Pro'); ?>
    </div>
<?php endif; ?>