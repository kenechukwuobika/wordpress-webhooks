<?php

$webhooks = wordpress_webhooks()->webhook->get_hooks( 'action' ) ;
$current_url = wordpress_webhooks()->helpers->get_current_url(false);
$clear_form_url = wordpress_webhooks()->helpers->get_current_url();
$action_nonce_data = wordpress_webhooks()->settings->get_action_nonce();
$actions = wordpress_webhooks()->webhook->get_actions();
$data_mapping_templates = wordpress_webhooks()->data_mapping->get_data_mapping();

?>
<?php add_ThickBox(); ?>
<h2><?php echo sprintf( wordpress_webhooks()->helpers->translate( 'Receive Data To %s', 'ww-page-actions' ), WW_NAME ); ?></h2>

<div>
    <?php if( wordpress_webhooks()->whitelabel->is_active() && ! empty( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_text_receive_data' ) ) ) : ?>
		<?php echo wordpress_webhooks()->helpers->translate( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_text_receive_data' ), 'admin-settings-license' ); ?>
    <?php else : ?>
        <?php echo sprintf(wordpress_webhooks()->helpers->translate( 'Use the webhook URL down below to connect your external service with your site. This URL receives data from external endpoints and does certain actions on your WordPress site. Please note, that deleting the default main webhook creates automatically a new one. If you need more information, check out the installation and documentation by clicking <a href="%s" target="_blank" >here</a>.', 'ww-page-actions' ), 'https://ironikus.com/docs/?utm_source=wp-webhooks-pro&utm_medium=notice-receive-data-docs&utm_campaign=WP%20Webhooks%20Pro'); ?>
    <?php endif; ?>
</div>

<table class="table ironikus-webhook-table ironikus-webhook-action-table">
    <thead class="thead-dark">
        <tr>
            <th style="width:20%">
                <?php echo wordpress_webhooks()->helpers->translate( 'Webhook Name', 'ww-page-actions' ); ?>
            </th>
            <th style="width:45%">
                <?php echo wordpress_webhooks()->helpers->translate( 'Webhook URL', 'ww-page-actions' ); ?>
            </th>
            <th style="width:25%">
                <?php echo wordpress_webhooks()->helpers->translate( 'Webhook API Key', 'ww-page-actions' ); ?>
            </th>
            <th style="width:10%">
		        <?php echo wordpress_webhooks()->helpers->translate( 'Action', 'ww-page-actions' ); ?>
            </th>
        </tr>
    </thead>
    <tbody>
    <?php foreach( $webhooks as $webhook => $webhook_data ) : 
        
        //Map default action_attributes if available
        $settings = array();
        if( ! empty( $webhook_data['settings'] ) ){

            if( isset( $webhook_data['settings']['data'] ) ){
                $settings = (array) $webhook_data['settings']['data'];
            }

            if( isset( $webhook_data['settings']['load_default_settings'] ) && $webhook_data['settings']['load_default_settings'] === true ){
                    $settings = array_merge( wordpress_webhooks()->settings->get_default_action_settings(), $settings );
            }

        }

        //Map dynamic data mapping settings
        $required_settings = wordpress_webhooks()->settings->get_required_action_settings();
        foreach( $required_settings as $settings_ident => $settings_data ){

            if( $settings_ident == 'ww_action_data_mapping' ){
                if( ! empty( $data_mapping_templates ) ){
                    $required_settings[ $settings_ident ]['choices'] = array_replace( $required_settings[ $settings_ident ]['choices'], wordpress_webhooks()->data_mapping->flatten_data_mapping_data( $data_mapping_templates ) );
                } else {
                    unset( $required_settings[ $settings_ident ] ); //if empty
                }
            }

            if( $settings_ident == 'ww_action_action_whitelist' ){
                $flattened_webhook_data = array();
                foreach( $actions as $fwd_identkey => $fwd_action ){
                    $flattened_webhook_data[ $fwd_action['action'] ] = $fwd_action['action'];
                }

                if( ! empty( $flattened_webhook_data ) ){
                    $required_settings[ $settings_ident ]['choices'] = $flattened_webhook_data;
                } else {
                    unset( $required_settings[ $settings_ident ] ); //if empty
                }
            }

        }

        $settings = array_merge( $required_settings, $settings );

        $status = 'active';
        $status_name = 'Deactivate';
        if( isset( $webhook_data['status'] ) && $webhook_data['status'] == 'inactive' ){
            $status = 'inactive';
            $status_name = 'Activate';
        }

        ?>
        <?php if( ! is_array( $webhook_data ) ) { continue; } ?>
        <?php if( ! current_user_can( apply_filters( 'ww/admin/settings/webhook/page_capability', wordpress_webhooks()->settings->get_admin_cap( 'ww-page-settings-action-data-webhook' ), $webhook ) ) ) { continue; } ?>
        <tr id="webhook-action-<?php echo $webhook; ?>">
            <td>
                <?php echo $webhook; ?>
            </td>
            <td>
                <input class="ironikus-webhook-input" type='text' name='ironikus_wp_webhooks_pro_webhook_url' value="<?php echo wordpress_webhooks()->webhook->built_url( $webhook, $webhook_data['api_key'] ); ?>" readonly /><br>
            </td>
            <td>
                <input class="ironikus-webhook-input" type='text' name='ironikus_wp_webhooks_pro_webhook_api_key' value="<?php echo $webhook_data['api_key']; ?>" readonly /><br>
            </td>
            <td>
                <div class="ironikus-element-actions">
                    <span class="ironikus-delete-action" ironikus-webhook-slug="<?php echo $webhook; ?>"><?php echo wordpress_webhooks()->helpers->translate( 'Delete', 'ww-page-actions' ); ?></span>
                    <br>
                    <span class="ironikus-status-action <?php echo $status; ?>" ironikus-webhook-status="<?php echo $status; ?>" ironikus-webhook-slug="<?php echo $webhook; ?>"><?php echo wordpress_webhooks()->helpers->translate( $status_name, 'ww-page-actions' ); ?></span>
                    <br>
                    <a class="thickbox ironikus-action-settings-wrapper" title="<?php echo $webhook; ?>" href="#TB_inline?height=330&width=800&inlineId=ww-action-settings-<?php echo $webhook; ?>">
                        <span class="ironikus-settings"><?php echo wordpress_webhooks()->helpers->translate( 'Settings', 'ww-page-actions' ); ?></span>
                    </a>

                    <div id="ww-action-settings-<?php echo $webhook; ?>" style="display:none;">
                        <div class="ironikus-tb-webhook-actions-wrapper">
                            <div class="ironikus-tb-webhook-url">
                                <strong>Webhook url:</strong>
                                <br>
                                <?php echo wordpress_webhooks()->webhook->built_url( $webhook, $webhook_data['api_key'] ); ?>
                            </div>
                            <div class="ironikus-tb-webhook-settings">
                                <?php if( $settings ) : ?>
                                    <form id="ironikus-webhook-action-form-<?php echo $webhook; ?>">
                                        <table class="ww-action-settings-table form-table">
                                            <tbody>

                                            <?php

                                            $settings_data = array();
                                            if( isset( $webhook_data['settings'] ) && ! empty( $webhook_data['settings'] ) ){
                                                $settings_data = $webhook_data['settings'];
                                            }

                                            foreach( $settings as $setting_name => $setting ) :

                                                $is_checked = ( $setting['type'] == 'checkbox' && $setting['default_value'] == 'yes' ) ? 'checked' : '';
                                                $value = ( $setting['type'] != 'checkbox' && isset( $setting['default_value'] ) ) ? $setting['default_value'] : '1';

                                                if( isset( $settings_data[ $setting_name ] ) ){
                                                    $value = $settings_data[ $setting_name ];
                                                    $is_checked = ( $setting['type'] == 'checkbox' && $value == 1 ) ? 'checked' : '';
                                                }

                                                ?>
                                                <tr valign="top">
                                                    <td>
                                                        <?php if( in_array( $setting['type'], array( 'text', 'checkbox' ) ) ) : ?>
                                                        <input id="iroikus-input-id-<?php echo $setting_name; ?>-<?php echo $webhook; ?>" name="<?php echo $setting_name; ?>" type="<?php echo $setting['type']; ?>" value="<?php echo $value; ?>" <?php echo $is_checked; ?> />
                                                        <?php elseif( $setting['type'] === 'select' && isset( $setting['choices'] ) ) : ?>
                                                            <select name="<?php echo $setting_name; ?><?php echo ( isset( $setting['multiple'] ) && $setting['multiple'] ) ? '[]' : ''; ?>" <?php echo ( isset( $setting['multiple'] ) && $setting['multiple'] ) ? 'multiple' : ''; ?>>
                                                                <?php
                                                                    if( isset( $settings_data[ $setting_name ] ) ){
                                                                        $settings_data[ $setting_name ] = ( is_array( $settings_data[ $setting_name ] ) ) ? array_flip( $settings_data[ $setting_name ] ) : $settings_data[ $setting_name ];
                                                                    }
                                                                ?>
                                                                <?php foreach( $setting['choices'] as $choice_name => $choice_label ) : ?>
                                                                    <?php
                                                                        $selected = '';
                                                                        if( isset( $settings_data[ $setting_name ] ) ){

                                                                            if( is_array( $settings_data[ $setting_name ] ) ){
                                                                                if( isset( $settings_data[ $setting_name ][ $choice_name ] ) ){
                                                                                    $selected = 'selected="selected"';
                                                                                }
                                                                            } else {
                                                                                if( (string) $settings_data[ $setting_name ] === (string) $choice_name ){
                                                                                    $selected = 'selected="selected"';
                                                                                }
                                                                            }

                                                                        }
                                                                    ?>
                                                                    <option value="<?php echo $choice_name; ?>" <?php echo $selected; ?>><?php echo wordpress_webhooks()->helpers->translate( $choice_label, 'ww-page-actions' ); ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td scope="row" valign="top">
                                                        <label for="iroikus-input-id-<?php echo $setting_name; ?>-<?php echo $webhook; ?>">
                                                            <strong><?php echo $setting['label']; ?></strong>
                                                        </label>
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
                                        <div class="ironikus-single-webhook-action-handler">
                                            <p class="btn btn-primary h30 ironikus-actions-submit-settings-form" id="<?php echo $webhook; ?>" webhook-id="<?php echo $webhook; ?>" >
                                                <span class="ironikus-save-text active"><?php echo wordpress_webhooks()->helpers->translate( 'Save Settings', 'ww-page-actions' ); ?></span>
                                                <img class="ironikus-loader" src="<?php echo WW_PLUGIN_URL . 'includes/frontend/assets/img/loader.gif'; ?>" />
                                            </p>
                                        </div>
                                    </form>
                                <?php else : ?>
                                    <div class="ww-empty">
                                        <?php echo wordpress_webhooks()->helpers->translate( 'For your current webhook are no settings available.', 'ww-page-actions' ); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="ironikus-add-wehook-action-handler">
    <div class="input-group mb-3">
        <label class="input-group-prepend" for="ironikus-webhook-action-name">
            <span class="input-group-text" id="input-group-webhook-action-name"><?php echo wordpress_webhooks()->helpers->translate( 'Webhook Name', 'ww-page-actions' ); ?></span>
        </label>
        <input id="ironikus-webhook-action-name" class="form-control ironikus-webhook-input-new h30" type="text" aria-describedby="input-group-webhook-action-name" placeholder="<?php echo wordpress_webhooks()->helpers->translate( 'my-webhook-name', 'ww-page-actions' ); ?>" >
    </div>
    <p class="btn btn-primary ironikus-action-save h30" >
        <span class="ironikus-save-text active"><?php echo wordpress_webhooks()->helpers->translate( 'Add Webhook', 'ww-page-actions' ); ?></span>
        <img class="ironikus-loader" src="<?php echo WW_PLUGIN_URL . 'includes/frontend/assets/img/loader.gif'; ?>" />
    </p>
</div>

<div class="ironikus-webhook-actions">
    <h2><?php echo wordpress_webhooks()->helpers->translate( 'Available Webhook Actions', 'ww-page-actions' ); ?></h2>
    <div class="mb20" style="font-weight:normal;"><?php echo wordpress_webhooks()->helpers->translate( 'Below you will find a list of all available actions when sending data from your specified service to WordPress.', 'ww-page-actions' ); ?></div>

    <?php if( ! empty( $actions ) ) : ?>
        <div class="accordion" id="actionMainData">
            <?php foreach( $actions as $identkey => $action ) : ?>
                <div class="card">
                    <div class="card-header" id="headingactionMainData-<?php echo $identkey; ?>"  data-toggle="collapse" data-target="#collapseactionMainData-<?php echo $identkey; ?>" aria-expanded="false" aria-controls="collapseactionMainData-<?php echo $identkey; ?>">
                        <button class="btn btn-link collapsed" type="button">
                            <?php echo $action['action']; ?>
                        </button>
                    </div>

                    <div id="collapseactionMainData-<?php echo $identkey; ?>" class="collapse" aria-labelledby="headingactionMainData-<?php echo $identkey; ?>" data-parent="#actionMainData">
                        <div class="card-body">
                            <div class="accordion-body__contents">
                                <?php echo $action['short_description']; ?>
                            </div>
                            <div class="accordion wpwh-action-arguments" id="actionArguments-<?php echo $identkey; ?>">
                                <div class="card">
                                    <div class="card-header" id="headingactionArgumentsSub-<?php echo $identkey; ?>"  data-toggle="collapse" data-target="#collapseactionArgumentsSub-<?php echo $identkey; ?>" aria-expanded="false" aria-controls="collapseactionArgumentsSub-<?php echo $identkey; ?>">
                                        <button class="btn btn-link collapsed" type="button">
                                            <?php echo wordpress_webhooks()->helpers->translate( 'Accepted Arguments', 'ww-page-actions'); ?>
                                        </button>
                                    </div>

                                    <div id="collapseactionArgumentsSub-<?php echo $identkey; ?>" class="collapse" aria-labelledby="headingactionArgumentsSub-<?php echo $identkey; ?>" data-parent="#actionArguments-<?php echo $identkey; ?>">
                                        <div class="card-body">
                                            <ul>
                                                <li>
                                                    <div class="ironikus-attribute-wrapper">
                                                        <div class="ironikus-attribute-wrapper-heading required">
                                                            <strong><?php echo 'action'; echo '<span>' . wordpress_webhooks()->helpers->translate( 'Required', 'ww-page-actions') . '</span>' ?></strong>
                                                        </div>
                                                        <div class="ironikus-attribute-wrapper-content">
                                                            <small><?php echo wordpress_webhooks()->helpers->translate( 'Always required. Determines which webhook action you want to target. (Alternatively, set this value as a query parameter within the URL) For this webhook action, please set it to ', 'ww-page-actions'); ?><strong><?php echo $action['action']; ?></strong></small>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php foreach( $action['parameter'] as $param => $param_data ) : ?>
                                                    <li>
                                                        <div class="ironikus-attribute-wrapper">
                                                            <div class="ironikus-attribute-wrapper-heading <?php echo ( ! empty( $param_data['required'] ) ) ? 'required' : '' ?>">
                                                                <strong><?php echo $param; echo ( ! empty( $param_data['required'] ) ) ? '<span>' . wordpress_webhooks()->helpers->translate( 'Required', 'ww-page-actions') . '</span>' : '' ?></strong>
                                                            </div>
                                                            
                                                            <?php if( isset( $param_data['short_description'] ) ) : ?>
                                                                <div class="ironikus-attribute-wrapper-content">
                                                                    <small><?php echo $param_data['short_description']; ?></small>
                                                                </div>  
                                                            <?php endif; ?>
                                                        </div>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if( ! empty( $action['returns'] ) || ! empty( $action['returns_code'] ) ) : ?>
                                <div class="accordion" id="actionReturnValues-<?php echo $identkey; ?>">
                                    <div class="card">
                                        <div class="card-header" id="headingactionReturnValuesSub-<?php echo $identkey; ?>"  data-toggle="collapse" data-target="#collapseactionReturnValuesSub-<?php echo $identkey; ?>" aria-expanded="false" aria-controls="collapseactionReturnValuesSub-<?php echo $identkey; ?>">
                                            <button class="btn btn-link collapsed" type="button">
                                                <?php echo wordpress_webhooks()->helpers->translate( 'Return values', 'ww-page-actions'); ?>
                                            </button>
                                        </div>

                                        <div id="collapseactionReturnValuesSub-<?php echo $identkey; ?>" class="collapse" aria-labelledby="headingactionReturnValuesSub-<?php echo $identkey; ?>" data-parent="#actionReturnValues-<?php echo $identkey; ?>">
                                            <div class="card-body">
                                            <?php if( ! empty( $action['returns'] ) ) : ?>
                                                <ul>
                                                    <?php foreach( $action['returns'] as $param => $param_data ) : ?>
                                                        <li>
                                                            <div class="ironikus-attribute-wrapper">
                                                                <strong><?php echo $param; ?></strong>
                                                                <?php if( isset( $param_data['short_description'] ) ) : ?>
                                                                    <br>
                                                                    <small><?php echo $param_data['short_description']; ?></small>
                                                                <?php endif; ?>
                                                            </div>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>

                                                <?php if( ! empty( $action['returns_code'] ) ) : ?>
                                                    <p>
                                                        <?php echo wordpress_webhooks()->helpers->translate( 'Here is an example of all the available default fields. The fields may vary based on custom extensions, third party plugins or different values.', 'ww-page-actions'); ?>
                                                        <?php echo $action['returns_code']; ?>
                                                    </p>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="accordion" id="actionDescription-<?php echo $identkey; ?>">
                                <div class="card">
                                    <div class="card-header" id="headingactionDescriptionSub-<?php echo $identkey; ?>"  data-toggle="collapse" data-target="#collapseactionDescriptionSub-<?php echo $identkey; ?>" aria-expanded="false" aria-controls="collapseactionDescriptionSub-<?php echo $identkey; ?>">
                                        <button class="btn btn-link collapsed" type="button">
                                            <?php echo wordpress_webhooks()->helpers->translate( 'Description', 'ww-page-actions'); ?>
                                        </button>
                                    </div>

                                    <div id="collapseactionDescriptionSub-<?php echo $identkey; ?>" class="collapse" aria-labelledby="headingactionDescriptionSub-<?php echo $identkey; ?>" data-parent="#actionDescription-<?php echo $identkey; ?>">
                                        <div class="card-body">
                                            <?php echo $action['description']; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion" id="actionTesting-<?php echo $identkey; ?>">
                                <div class="card">
                                    <div class="card-header" id="headingactionTestingSub-<?php echo $identkey; ?>"  data-toggle="collapse" data-target="#collapseactionTestingSub-<?php echo $identkey; ?>" aria-expanded="false" aria-controls="collapseactionTestingSub-<?php echo $identkey; ?>">
                                        <button class="btn btn-link collapsed" type="button">
                                        <?php echo wordpress_webhooks()->helpers->translate( 'Test action', 'ww-page-actions' ); ?>
                                        </button>
                                    </div>

                                    <div id="collapseactionTestingSub-<?php echo $identkey; ?>" class="collapse" aria-labelledby="headingactionTestingSub-<?php echo $identkey; ?>" data-parent="#actionTesting-<?php echo $identkey; ?>">
                                        <div class="card-body">
                                            <?php echo wordpress_webhooks()->helpers->translate( 'Here you can test the specified webhook. Please note, that this test can modify the data of your website (Depending on what action you test). Also, you will see the response as any web service receives it.', 'ww-page-actions'); ?>
                                            <br>
                                            <?php echo wordpress_webhooks()->helpers->translate( 'Please choose the webhook you are going to run the test with. Simply select the one you want to use down below.', 'ww-page-actions'); ?>
                                            <br>
                                            <select class="ww-webhook-actions-webhook-select custom-select-lg" wpwh-identkey="<?php echo $identkey; ?>">
                                                <option value="empty"><?php echo wordpress_webhooks()->helpers->translate( 'Choose...', 'ww-page-data-mapping' ); ?></option>
                                                <?php if( ! empty( $webhooks ) ) : ?>
                                                    <?php foreach( $webhooks as $subwebhook => $subwebhook_data ) : ?>
                                                        <option class="<?php echo $subwebhook; ?>" value="<?php echo wordpress_webhooks()->webhook->built_url( $subwebhook, $subwebhook_data['api_key'] ) . '&ww_direct_test=1'; ?>"><?php echo $subwebhook; ?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                            <form id="wpwh-action-testing-form-<?php echo $identkey; ?>" method="post" class="wpwh-actions-testing-form" action="" target="_blank" style="display:none;">

                                                <table class="ww-settings-table form-table">
                                                    <tbody>

                                                    <tr valign="top">
                                                        <td>
                                                            <input id="wwtest_<?php echo $action['action']; ?>_action" class="form-control" type="text" name="action" value="<?php echo $action['action']; ?>" placeholder="<?php echo wordpress_webhooks()->helpers->translate( 'Required', 'ww-page-actions'); ?>">
                                                        </td>
                                                        <td scope="row" valign="top">
                                                            <label for="wwtest_<?php echo $action['action']; ?>_action">
                                                                <strong>action</strong>
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <p class="description">
                                                                <?php echo wordpress_webhooks()->helpers->translate( 'Always required. This argument determines which webhook you want to target. For this webhook action, please set it to ', 'ww-page-actions'); ?><strong><?php echo $action['action']; ?></strong>
                                                            </p>
                                                        </td>
                                                    </tr>

                                                    <?php foreach( $action['parameter'] as $param => $param_data ) : ?>

                                                        <tr valign="top">
                                                            <td>
                                                                <input id="wwtest_<?php echo $action['action']; ?>_<?php echo $param; ?>" class="form-control" type="text" name="<?php echo $param; ?>" placeholder="<?php echo ( ! empty( $param_data['required'] ) ) ? wordpress_webhooks()->helpers->translate( 'Required', 'ww-page-actions') : '' ?>">
                                                            </td>
                                                            <td scope="row" valign="top">
                                                                <label for="wwtest_<?php echo $action['action']; ?>_<?php echo $param; ?>">
                                                                    <strong><?php echo $param; ?></strong>
                                                                </label>
                                                            </td>
                                                            <td>
                                                                <p class="description">
                                                                    <?php echo $param_data['short_description']; ?>
                                                                </p>
                                                            </td>
                                                        </tr>

                                                    <?php endforeach; ?>

                                                    <tr valign="top">
                                                            <td>
                                                                <input id="wwtest_<?php echo $action['action']; ?>_access_token" class="form-control" type="text" name="access_token">
                                                            </td>
                                                            <td scope="row" valign="top">
                                                                <label for="wwtest_<?php echo $action['action']; ?>_access_token">
                                                                    <strong>access_token</strong>
                                                                </label>
                                                            </td>
                                                            <td>
                                                                <p class="description">
                                                                    <?php echo wordpress_webhooks()->helpers->translate( 'This is a static input field. You only need to set it in case you activated the access_token functionality within the webhook settings.', 'ww-page-actions' ); ?>
                                                                </p>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>

                                                <input type="submit" name="submit" id="submit" class="btn btn-primary" value="<?php echo wordpress_webhooks()->helpers->translate( 'Test action', 'admin-settings' ) ?>">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
	<?php else : ?>
        <div class="ww-empty">
		    <?php echo wordpress_webhooks()->helpers->translate( 'You currently don\'t have any actions activated. Please go to our settings tab and activate some.', 'ww-page-actions' ); ?>
        </div>
	<?php endif; ?>
</div>

<p>
    <small>* <?php echo wordpress_webhooks()->helpers->translate( 'Required fields.', 'ww-page-actions' ); ?></small>
</p>