<?php
/**
 * Main Template
 */

$license_key        = wordpress_webhooks()->settings->get_license('key');
$license_status     = wordpress_webhooks()->settings->get_license('status');
$license_expires    = wordpress_webhooks()->settings->get_license('expires');
$license_expired    = '';
$license_option_key = wordpress_webhooks()->settings->get_license_option_key();
$license_nonce_data = wordpress_webhooks()->settings->get_license_nonce();
$home_url = home_url();

if ( ! empty( $license_expires ) ) {
	$license_is_expired = wordpress_webhooks()->license->is_expired( $license_expires );
	if ( $license_is_expired ) {
		$license_expired = wordpress_webhooks()->helpers->translate('Your license key has expired.', 'admin-settings-license');
	}
}

// Check on submit and update the license.
if ( isset( $_REQUEST['submit'] ) ) {

	if ( isset( $_REQUEST['ironikus_ww_license_key' ] ) && !empty( $_REQUEST['ironikus_ww_license_key'] ) ) {
		$license_key = $_REQUEST['ironikus_ww_license_key'];
		wordpress_webhooks()->license->update( 'key', trim( $license_key ) );
		echo wordpress_webhooks()->helpers->create_admin_notice( 'Saved successfully.', 'success', true );
	}else{
		wordpress_webhooks()->license->update( 'key' );
		$license_key = '';
	}
}

// Activate license.
if( isset( $_POST['ironikus_activate_license'] ) ) {
	if( ! check_admin_referer( $license_nonce_data['action'], $license_nonce_data['arg'] ) ) {
		return;
	}

	$response = wordpress_webhooks()->license->activate( array( 'license' => $license_key	) );

	if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
		$message =  ( is_wp_error( $response ) && ! empty( $response->get_error_message() ) ) ? $response->get_error_message() : wordpress_webhooks()->helpers->translate( 'An error occurred, please try again.', 'admin-settings-license' );
		echo wordpress_webhooks()->helpers->create_admin_notice( $message, 'error', true );
	} else {
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		if( ! empty( $license_data ) && $license_data->license == 'valid' ){
			wordpress_webhooks()->license->update( 'status', $license_data->license );
			wordpress_webhooks()->license->update( 'expires', $license_data->expires );
			$license_status = $license_data->license;
			$license_expires = $license_data->expires;
			$license_expired = false;
			echo wordpress_webhooks()->helpers->create_admin_notice( 'License successfully activated.', 'success', true );
		} elseif( ! empty( $license_data ) && ! empty( $license_data->site_count ) && ! empty( $license_data->license_limit ) ) {
			if( $license_data->site_count >= $license_data->license_limit ){
				echo sprintf(wordpress_webhooks()->helpers->create_admin_notice( 'We are sorry, but you reached the maximum of active installations for your subscription. Please go to your <a href="%s" target="_blank" rel="noopener">account page</a> and manage your active sites or upgrade your current plan.', 'error', true ), 'https://ironikus.com/account/?utm_source=wp-webhooks-pro&utm_medium=notice-reached-activation-limit&utm_campaign=WP%20Webhooks%20Pro');
            }
		} elseif( ! empty( $license_data ) && ! empty( $license_data->error ) && $license_data->error == 'expired' ){
			echo wordpress_webhooks()->helpers->create_admin_notice( 'Sorry, but your license is expired. Please renew it first.', 'error', true );
        } else {
			echo wordpress_webhooks()->helpers->create_admin_notice( 'Unfortunately we could not activate your license.', 'error', true );
		}

	}

}

// Deactivate license.
if ( isset( $_POST['ironikus_deactivate_license'] ) ) {
	if( ! check_admin_referer( $license_nonce_data['action'], $license_nonce_data['arg'] ) ) {
		return;
	}

	$response = wordpress_webhooks()->license->deactivate( array( 'license' => $license_key	) );

	if ( ! is_wp_error( $response ) ) {
		wordpress_webhooks()->license->update( 'status' );
		wordpress_webhooks()->license->update( 'expires' );
		wordpress_webhooks()->license->update( 'whitelabel' );
		$license_status = false;
		echo wordpress_webhooks()->helpers->create_admin_notice( 'Deactivated license successfully.', 'success', true );
	}

}

?>


<h2><?php echo wordpress_webhooks()->helpers->translate('Plugin License Options', 'admin-settings-license'); ?></h2>

<div class="mb3">
	<?php if( wordpress_webhooks()->whitelabel->is_active() && ! empty( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_text_license' ) ) ) : ?>
		<?php echo wordpress_webhooks()->helpers->translate( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_text_license' ), 'admin-settings-license' ); ?>
	<?php else : ?>
		<?php echo sprintf(wordpress_webhooks()->helpers->translate( 'If you have any trouble with activating your license, please check your available license slots and your subscription on your <a href="%s" target="_blank" >account page</a>.', 'admin-settings-license' ), 'https://ironikus.com/account/?utm_source=wp-webhooks-pro&utm_medium=notice-question-trouble-activation&utm_campaign=WP%20Webhooks%20Pro'); ?>
		<br>
		<br>
		<?php echo wordpress_webhooks()->helpers->translate('To activate your license, here are the steps you need to do:', 'admin-settings-license'); ?>
		<ol>
			<li><?php echo wordpress_webhooks()->helpers->translate('Add the license key into the input field and press "Save license"', 'admin-settings-license'); ?></li>
			<li><?php echo wordpress_webhooks()->helpers->translate('Once saved, you will see a button for activating the license, please click it.', 'admin-settings-license'); ?></li>
			<li><?php echo wordpress_webhooks()->helpers->translate('That\'s it, you are ready to go.', 'admin-settings-license'); ?></li>
		</ol>
	<?php endif; ?>
</div>

<form method="post" action="">

	<table class="form-table">
		<tbody>
		<tr valign="top">
			<th scope="row" valign="top">
				<?php echo wordpress_webhooks()->helpers->translate('License Key', 'admin-settings-license'); ?>
			</th>
			<td>
				<div class="input-group">
					<input id="ironikus_ww_license_key" name="ironikus_ww_license_key" value="<?php esc_attr_e( $license_key ); ?>" type="text" class="regular-text form-control" placeholder="License key" aria-label="License Key" aria-describedby="ironikus_ww_license_key_label">
					<label class="input-group-append" for="ironikus_ww_license_key">
						<span class="input-group-text" id="ironikus_ww_license_key_label"><?php echo wordpress_webhooks()->helpers->translate( 'Enter your license key.', 'admin-settings-license' ); ?></span>
					</label>
				</div>
			</td>
		</tr>

		<tr>
			<th scope="row" valign="top">
				<?php echo wordpress_webhooks()->helpers->translate( 'License Status', 'admin-settings-license' ); ?>
			</th>
			<td>
				<?php if ( false !== $license_status && $license_status == 'valid' ) : ?>
					<?php if ( ! $license_expired ) : ?>
						<span style="color:green">
                            <strong><?php echo wordpress_webhooks()->helpers->translate( 'Active.', 'admin-settings-license' ); ?></strong>
                        </span>
					<?php else : ?>
						<span style="color:red">
                            <strong><?php echo wordpress_webhooks()->helpers->translate( 'Expired.', 'admin-settings-license' ); ?></strong>
                        </span>
					<?php endif; ?>

					<?php if ( ! $license_expired ) : ?>
						<?php echo sprintf( wordpress_webhooks()->helpers->translate( 'Expires on %s', 'admin-settings-license'), $license_expires ); ?>
					<?php endif; ?>

				<?php else : ?>
					<span style="color:red">
						<strong><?php echo wordpress_webhooks()->helpers->translate( 'Please activate your license down below.', 'admin-settings-license' ); ?></strong>
					</span>
				<?php endif; ?>
			</td>
		</tr>
		<?php if( ! empty( $license_key ) || false != $license_key ) : ?>
			<tr valign="top">
				<th scope="row" valign="top">
					<?php echo wordpress_webhooks()->helpers->translate( 'Activate License', 'admin-settings-license' ); ?>
				</th>
				<td>
					<?php wp_nonce_field( 'ironikus_ww_license', 'ironikus_ww_license_nonce' ); ?>
					<?php if ( $license_status !== false && $license_status == 'valid' ) : ?>
						<input type="submit" class="button-secondary" style="color:red;" name="ironikus_deactivate_license" value="<?php echo wordpress_webhooks()->helpers->translate( 'Deactivate License', 'admin-settings-license' ); ?>"/><br/><br/>
					<?php else : ?>
						<input type="submit" class="button-secondary" name="ironikus_activate_license" value="<?php echo wordpress_webhooks()->helpers->translate( 'Activate License', 'admin-settings-license' ); ?>" <?php if ( $license_expired ) { echo 'disabled'; } ?>>
					<?php endif; ?>
				</td>
			</tr>
		<?php endif; ?>
		</tbody>
	</table>
	<input type="submit" name="submit" id="submit" class="btn btn-primary btn-md" value="<?php echo wordpress_webhooks()->helpers->translate( 'Save License', 'admin-settings-license' ); ?>">

</form>