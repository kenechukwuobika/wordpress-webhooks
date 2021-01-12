<?php

$templates = wordpress_webhooks()->auth->get_auth_templates();
$auth_methods = wordpress_webhooks()->settings->get_authentication_methods();

?>
<?php add_ThickBox(); ?>
<div class="ww-authentication-wrapper">
    <h2><?php echo wordpress_webhooks()->helpers->translate( 'Authentication', 'ww-page-authentication' ); ?></h2>

    <div>
        <?php if( wordpress_webhooks()->whitelabel->is_active() && ! empty( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_text_authentication' ) ) ) : ?>
            <?php echo wordpress_webhooks()->helpers->translate( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_text_authentication' ), 'admin-settings-license' ); ?>
        <?php else : ?>
            <?php echo sprintf(wordpress_webhooks()->helpers->translate( 'Create your own authentication template down below. This allows you to authenticate your outgoing "Send Data" webhook triggers to a given endpoint. For more information, please check out the authentication documentation by clicking <a href="%s" target="_blank" >here</a>.', 'ww-page-authentication' ), 'https://ironikus.com/docs/knowledge-base/how-to-use-authentication/'); ?>
        <?php endif; ?>
    </div>

    <div id="ww-authentication-actions">
        <form id="ironikus-authentication-form" method="post" action="">
            <div class="input-group">
                <label class="input-group-prepend" for="wpwh-authentication-template">
                    <span class="input-group-text" id="wpwh-authentication-template-label"><?php echo wordpress_webhooks()->helpers->translate( 'Template name', 'ww-page-authentication' ); ?></span>
                </label>
                <input type="text" class="form-control" id="wpwh-authentication-template" name="wpwh-authentication-template" aria-describedby="wpwh-authentication-template-label" placeholder="<?php echo wordpress_webhooks()->helpers->translate( 'my-template-name', 'ww-page-authentication' ); ?>">
            </div>

            <div class="input-group">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="wpwh-authentication-type"><?php echo wordpress_webhooks()->helpers->translate( 'Auth Type', 'ww-page-authentication' ); ?></label>
                </div>
                <select id="wpwh-authentication-type" class="custom-select">
                    <option value="empty" selected><?php echo wordpress_webhooks()->helpers->translate( 'Choose...', 'ww-page-authentication' ); ?>.</option>
                    <?php foreach( $auth_methods as $auth_type => $auth_data ) : ?>
                        <option value="<?php echo $auth_type; ?>"><?php echo $auth_data['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <p class="btn btn-primary h30 ironikus-submit-auth-data">
                <span class="ironikus-save-text active"><?php echo wordpress_webhooks()->helpers->translate( 'Create Template', 'admin-settings' ); ?></span>
                <img class="ironikus-loader" src="<?php echo WW_PLUGIN_URL . 'includes/frontend/assets/img/loader.gif'; ?>" />
            </p>
        </form>

    </div>

    <?php if( ! empty( $templates ) ) : ?>
        <div class="ww-authentication-template-wrapper">
            <select id="ww-authentication-template-select">
                <option value="empty"><?php echo wordpress_webhooks()->helpers->translate( 'Choose...', 'ww-page-authentication' ); ?></option>
                <?php foreach( $templates as $template ) : ?>
                    <option value="<?php echo $template->id; ?>"><?php echo wordpress_webhooks()->helpers->translate( $template->name, 'ww-page-authentication' ); ?></option>
                <?php endforeach; ?>
            </select>
            <img id="ww-authentication-template-loader-img" class="ironikus-loader" src="<?php echo WW_PLUGIN_URL . 'includes/frontend/assets/img/loader-black.gif'; ?>" />
        </div>
        <?php else : ?>
        <div class="ww-empty">
            <?php echo wordpress_webhooks()->helpers->translate( 'You currently don\'t have any authentication templates available. Please create one first.', 'ww-page-authentication' ); ?>
        </div>
    <?php endif; ?>

    <div id="ww-authentication-content-wrapper">
        <div class="ww-empty">
            <?php echo wordpress_webhooks()->helpers->translate( 'Please choose a template first.', 'ww-page-authentication' ); ?>
        </div>
    </div>
</div>