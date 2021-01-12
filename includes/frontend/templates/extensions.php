<?php

$all_plugins = get_plugins();
$active_plugins = get_option('active_plugins');
$license_status = wordpress_webhooks()->settings->get_license('status');
$extensions_list = wordpress_webhooks()->api->get_extension_list();
$plugin_update_list = get_site_transient( 'update_plugins' );
if( isset( $plugin_update_list->response ) ){
    $plugin_update_list = $plugin_update_list->response;
}

?>
<h2><?php echo wordpress_webhooks()->helpers->translate( 'Extensions for', 'ww-page-logs' ) . ' ' . $this->page_title; ?> </h2>

<div>
    <?php if( wordpress_webhooks()->whitelabel->is_active() && ! empty( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_text_extensions' ) ) ) : ?>
		<?php echo wordpress_webhooks()->helpers->translate( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_text_extensions' ), 'admin-settings-license' ); ?>
    <?php else : ?>
        <?php echo sprintf( wordpress_webhooks()->helpers->translate( 'This page contains all approved extensions for <strong>%1$s</strong>. You will be able to fully manage each of the extensions right within this plugin. In case you want to list your very own plugin here, feel free to <a title="Go to our contact form" target="_blank" href="%2$s">reach out to us</a>.', 'ww-page-logs' ), $this->page_title, 'https://ironikus.com/contact/' ); ?>
    <?php endif; ?>
</div>
<div class="wpwh-extensions-wrapper">

    <?php if( ! empty( $extensions_list ) ) : ?>
        <?php foreach( $extensions_list as $slug => $data ) : 
        
        $plugin_installed = wordpress_webhooks()->helpers->is_plugin_installed( $data['extension_plugin_slug'] );
        $plugin_active = ( in_array( $data['extension_plugin_slug'], $active_plugins ) ) ? true : false;
        $plugin_premium = ( $data['type'] === 'premium' ) ? true : false;

        $plugin_version = 0;
        if( isset( $all_plugins[ $data['extension_plugin_slug'] ] ) ){
            $plugin_version = $all_plugins[ $data['extension_plugin_slug'] ]['Version'];
        }

        //MAke sure we only show the update button if the plugin is recognized already by the WP related logic
        $available_version = $plugin_version;
        if( isset( $plugin_update_list[ $data['extension_plugin_slug'] ] ) ){
            if( isset( $plugin_update_list[ $data['extension_plugin_slug'] ]->new_version ) ){
                $available_version = $plugin_update_list[ $data['extension_plugin_slug'] ]->new_version;
            }
        }

        ?>
            <div class="card single-extension" style="width: 18rem;">
                <img src="<?php echo esc_url( $data['thumbnail'] ); ?>" class="card-img-top" alt="<?php echo sanitize_text_field( $data['name'] ); ?>">

                <div class="card-body">
                    <small>v<?php echo sanitize_text_field( $data['version'] ); ?></small>
                    <h5 class="card-title">
                        <?php if( $data['type'] === 'premium' ) : ?>
                            <span class="golden">Pro</span> 
                        <?php endif; ?>
                        <?php echo sanitize_text_field( $data['name'] ); ?>
                    </h5>
                    <p class="card-text">
                        <?php echo sanitize_text_field( $data['description'] ); ?>
                    </p>
                    <a href="<?php echo esc_url( $data['extension_info_url'] ); ?>" target="_blank" class="btn btn-info more-info">More info</a>

                    <?php if( $plugin_installed ) : ?>

                        <?php if( version_compare( (string) $available_version, (string) $plugin_version, '>') ) : ?>

                            <?php if( $plugin_premium && ( $license_status === false || $license_status !== 'valid' ) ) : ?>
                                <a class="btn btn-secondary h30 ironikus-extension-manage" href="<?php echo get_admin_url(); ?>options-general.php?page=wp-webhooks-pro&tab=license" title="<?php echo wordpress_webhooks()->helpers->translate( 'Activate your licene first', 'ww-page-extensions' ); ?>">
                                    <?php echo wordpress_webhooks()->helpers->translate( 'License', 'ww-page-extensions' ); ?>
                                </a>
                            <?php else : 
                            
                            $update_status = ( $plugin_active ) ? 'update_active' : 'update_deactive';
                            
                            ?>
                                <p class="btn btn-dark h30 ironikus-extension-manage" title="<?php echo sprintf( wordpress_webhooks()->helpers->translate( 'Upgrade from your current version %1$s to version %2$s', 'ww-page-extensions' ), $plugin_version, $available_version ); ?>" webhook-extension-id="<?php echo intval( $data['item_id'] ); ?>" webhook-extension-version="<?php echo sanitize_text_field( $available_version ); ?>" webhook-extension-status="<?php echo $update_status; ?>" webhook-extension-slug="<?php echo sanitize_text_field( $data['extension_plugin_slug'] ); ?>" webhook-extension-dl="<?php echo sanitize_text_field( $data['extension_download_url'] ); ?>">
                                    <span class="ironikus-save-text active"><?php echo wordpress_webhooks()->helpers->translate( 'Update', 'ww-page-extensions' ); ?></span>
                                    <img class="ironikus-loader" src="<?php echo WW_PLUGIN_URL . 'includes/frontend/assets/img/loader.gif'; ?>" />
                                </p>
                            <?php endif; ?>

                        <?php else : ?>

                            <?php if( $plugin_active ) : ?>
                                <p class="btn btn-warning h30 ironikus-extension-manage" webhook-extension-status="activated" webhook-extension-slug="<?php echo sanitize_text_field( $data['extension_plugin_slug'] ); ?>" webhook-extension-dl="<?php echo sanitize_text_field( $data['extension_download_url'] ); ?>">
                                    <span class="ironikus-save-text active"><?php echo wordpress_webhooks()->helpers->translate( 'Deactivate', 'ww-page-extensions' ); ?></span>
                                    <img class="ironikus-loader" src="<?php echo WW_PLUGIN_URL . 'includes/frontend/assets/img/loader.gif'; ?>" />
                                </p>
                            <?php else : ?>
                                <p class="btn btn-success h30 ironikus-extension-manage" webhook-extension-status="deactivated" webhook-extension-slug="<?php echo sanitize_text_field( $data['extension_plugin_slug'] ); ?>" webhook-extension-dl="<?php echo sanitize_text_field( $data['extension_download_url'] ); ?>">
                                    <span class="ironikus-save-text active"><?php echo wordpress_webhooks()->helpers->translate( 'Activate', 'ww-page-extensions' ); ?></span>
                                    <img class="ironikus-loader" src="<?php echo WW_PLUGIN_URL . 'includes/frontend/assets/img/loader.gif'; ?>" />
                                </p>
                            <?php endif; ?>
                           
                        <?php endif; ?>
                        
                    <?php else : ?>

                        <?php if( $plugin_premium && ( $license_status === false || $license_status !== 'valid' ) ) : ?>
                            <a class="btn btn-secondary h30 ironikus-extension-manage" href="<?php echo get_admin_url(); ?>options-general.php?page=wp-webhooks-pro&tab=license" title="<?php echo wordpress_webhooks()->helpers->translate( 'Activate your licene first', 'ww-page-extensions' ); ?>">
                                <?php echo wordpress_webhooks()->helpers->translate( 'License', 'ww-page-extensions' ); ?>
                            </a>
                        <?php else : ?>
                            <p class="btn btn-primary h30 ironikus-extension-manage" webhook-extension-id="<?php echo intval( $data['item_id'] ); ?>" webhook-extension-version="<?php echo sanitize_text_field( $data['version'] ); ?>" webhook-extension-status="uninstalled" webhook-extension-slug="<?php echo sanitize_text_field( $data['extension_plugin_slug'] ); ?>" webhook-extension-dl="<?php echo sanitize_text_field( $data['extension_download_url'] ); ?>">
                                <span class="ironikus-save-text active"><?php echo wordpress_webhooks()->helpers->translate( 'Install', 'ww-page-extensions' ); ?></span>
                                <img class="ironikus-loader" src="<?php echo WW_PLUGIN_URL . 'includes/frontend/assets/img/loader.gif'; ?>" />
                            </p>
                        <?php endif; ?>
                    <?php endif; ?>

                    <div class="bottom-action-wrapper">
                        <?php if( $plugin_installed ) : ?>
                                <div class="ironikus-extension-delete" webhook-extension-status="delete" webhook-extension-slug="<?php echo sanitize_text_field( $data['extension_plugin_slug'] ); ?>" webhook-extension-dl="<?php echo sanitize_text_field( $data['extension_download_url'] ); ?>">
                                    <small><?php echo wordpress_webhooks()->helpers->translate( 'Delete', 'ww-page-extensions' ); ?></small>
                                </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card-footer">
                    Made by <a href="<?php echo esc_url( $data['vendor']['url'] ); ?>" title="Go to <?php echo sanitize_text_field( $data['vendor']['name'] ); ?>" target="_blank"><?php echo sanitize_text_field( $data['vendor']['name'] ); ?></a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <div class="ww-empty">
            <?php echo wordpress_webhooks()->helpers->translate( 'There are currently no extensions available.', 'ww-page-extensions' ); ?>
        </div>
    <?php endif; ?>

</div>