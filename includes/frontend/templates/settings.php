<?php

/*
 * Settings Template
 */

$settings = wordpress_webhooks()->settings->get_settings();
$triggers = wordpress_webhooks()->webhook->get_triggers( '', false );
$actions = wordpress_webhooks()->webhook->get_actions( false );
$active_webhooks = wordpress_webhooks()->settings->get_active_webhooks();
$current_url_full = wordpress_webhooks()->helpers->get_current_url();

if( did_action( 'wpwh/admin/settings/settings_saved' ) ){
	echo wordpress_webhooks()->helpers->create_admin_notice( 'The settings are successfully updated. Please refresh the page.', 'success', true );
}

?>

<div class="ironikus-settings-wrapper">

	<h2><?php echo wordpress_webhooks()->helpers->translate('Global Settings', 'admin-settings'); ?></h2>

	<div class="sub-text">
		<?php if( wordpress_webhooks()->whitelabel->is_active() && ! empty( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_text_settings' ) ) ) : ?>
			<?php echo wordpress_webhooks()->helpers->translate( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_text_settings' ), 'admin-settings-license' ); ?>
		<?php else : ?>
			<?php echo wordpress_webhooks()->helpers->translate( 'Here you can configure the global settings for our plugin, enable certain features to extend the possibilities for your site, and activate your available webhook actions and triggers.', 'admin-settings' ); ?>
		<?php endif; ?>
	</div>

	<form id="ironikus-main-settings-form" method="post" action="">

		<table class="table ww-settings-table form-table">
			<tbody>

			<?php foreach( $settings as $setting_name => $setting ) :

				$is_checked = ( $setting['type'] == 'checkbox' && $setting['value'] == 'yes' ) ? 'checked' : '';
				$value = ( $setting['type'] != 'checkbox' ) ? $setting['value'] : '1';
				$is_checkbox = ( $setting['type'] == 'checkbox' ) ? true : false;

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
						<?php else : ?>
							<input id="<?php echo $setting['id']; ?>" name="<?php echo $setting_name; ?>" type="<?php echo $setting['type']; ?>" class="regular-text" value="<?php echo $value; ?>" <?php echo $is_checked; ?> />
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

		<p class="btn btn-primary h30 ironikus-submit-settings-data">
			<span class="ironikus-save-text active"><?php echo wordpress_webhooks()->helpers->translate( 'Save all', 'admin-settings' ); ?></span>
			<img class="ironikus-loader" src="<?php echo WW_PLUGIN_URL . 'includes/frontend/assets/img/loader.gif'; ?>" />
		</p>

		<h2><?php echo wordpress_webhooks()->helpers->translate('Activate "Send Data" Triggers', 'admin-settings'); ?></h2>

		<div class="sub-text">
			<?php echo wordpress_webhooks()->helpers->translate( 'This is a list of all available data triggers, that are currently registered on your site. To use one, just check the box and click save. After that you will be able to use the trigger within the "Send Data" tab.', 'admin-settings' ); ?>
		</div>
		<table class="table ww-settings-table form-table">
			<tbody>

			<?php foreach( $triggers as $trigger ) :

				$ident = !empty( $trigger['name'] ) ? $trigger['name'] : $trigger['trigger'];
				$is_checked = isset( $active_webhooks['triggers'][ $trigger['trigger'] ] ) ?  'checked' : '';

				?>
				<tr valign="top">
					<td class="action-button-toggle">
						<label class="switch ">
							<input id="wwpt_<?php echo $trigger['trigger']; ?>" class="regular-text default primary" name="wwpt_<?php echo $trigger['trigger']; ?>" type="checkbox" class="regular-text" value="1" <?php echo $is_checked; ?> />
							<span class="slider round"></span>
						</label>
					</td>
					<td scope="row" valign="top">
						<label for="wwpt_<?php echo $trigger['trigger']; ?>">
							<strong><?php echo $ident; ?></strong>
						</label>
					</td>
					<td>
						<p class="description">
							<?php echo $trigger['short_description']; ?>
						</p>
					</td>
				</tr>
			<?php endforeach; ?>

			</tbody>
		</table>
		<p class="btn btn-primary h30 ironikus-submit-settings-data">
			<span class="ironikus-save-text active"><?php echo wordpress_webhooks()->helpers->translate( 'Save all', 'admin-settings' ); ?></span>
			<img class="ironikus-loader" src="<?php echo WW_PLUGIN_URL . 'includes/frontend/assets/img/loader.gif'; ?>" />
		</p>

		<h2><?php echo wordpress_webhooks()->helpers->translate('Activate "Receive Data" Actions', 'admin-settings'); ?></h2>

		<div class="sub-text">
			<?php echo wordpress_webhooks()->helpers->translate( 'This is a list of all available action webhooks registered on your site. To use one, just check the box and click save. After that, you will be able to use the action at the Receive Data tab.', 'admin-settings' ); ?>
		</div>
		<table class="table ww-settings-table form-table">
			<tbody>

			<?php foreach( $actions as $action ) :

				$is_checked = isset( $active_webhooks['actions'][ $action['action'] ] ) ?  'checked' : '';

				?>
				<tr valign="top">
					<td class="action-button-toggle">
						<label class="switch ">
							<input id="wwpa_<?php echo $action['action']; ?>" class="regular-text default primary" name="wwpa_<?php echo $action['action']; ?>" type="checkbox" class="regular-text" value="1" <?php echo $is_checked; ?> />
							<span class="slider round"></span>
						</label>
					</td>
					<td scope="row" valign="top">
						<label for="wwpa_<?php echo $action['action']; ?>">
							<strong><?php echo $action['action']; ?></strong>
						</label>
					</td>
					<td>
						<p class="description">
							<?php echo $action['short_description']; ?>
						</p>
					</td>
				</tr>
			<?php endforeach; ?>

			</tbody>
		</table>

		<input type="hidden" name="ironikus_update_settings" value="yes">
		<p class="btn btn-primary h30 ironikus-submit-settings-data">
			<span class="ironikus-save-text active"><?php echo wordpress_webhooks()->helpers->translate( 'Save all', 'admin-settings' ); ?></span>
			<img class="ironikus-loader" src="<?php echo WW_PLUGIN_URL . 'includes/frontend/assets/img/loader.gif'; ?>" />
		</p>

	</form>

</div>