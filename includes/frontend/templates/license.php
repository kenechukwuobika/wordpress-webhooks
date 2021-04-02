<?php
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
if ( isset( $_REQUEST['ksubmit'] ) ) {
	var_dump($_REQUEST['submit']);

	if ( isset( $_REQUEST['license_number' ] ) ) {
		$license_key = $_REQUEST['license_number'];
		wordpress_webhooks()->license->update( 'key', trim( $license_key ) );
		echo wordpress_webhooks()->helpers->create_admin_notice( 'Saved successfully.', 'success', true );
	}else{
		wordpress_webhooks()->license->update( 'key' );
		$license_key = '';
	}
}

// Activate license.
if( isset( $_POST['submit'] ) ) {
	// if( ! check_admin_referer( $license_nonce_data['action'], $license_nonce_data['arg'] ) ) {
	// 	return;
	// }

	$response = wordpress_webhooks()->license->activate( array( 'license_number' => $_REQUEST['license_number']	) );

	if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
		$message =  ( is_wp_error( $response ) && ! empty( $response->get_error_message() ) ) ? $response->get_error_message() : wordpress_webhooks()->helpers->translate( 'An error occurred, please try again.', 'admin-settings-license' );
		echo wordpress_webhooks()->helpers->create_admin_notice( $message, 'error', true );
	} else {
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		if( ! empty( $license_data ) && $license_data->status == 'active' ){
			wordpress_webhooks()->license->update( 'status', $license_data->status );
			wordpress_webhooks()->license->update( 'expires_at', $license_data->expiry_date );
			wordpress_webhooks()->license->update( 'billing_cycle', $license_data->billing_cycle );
			$license_status = $license_data->status;
			$license_expires_at = $license_data->expires_at;
			$license_billing_cycle = $license_data->billing_cycle;
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

<div class="d-flex flex-column align-items-center">
    <div class="ww_home--heading">
        <h2 class="ww-heading-primary">
            <?php echo sprintf( wordpress_webhooks()->helpers->translate( 'Activate License', 'ww-page-actions' ) ); ?>
        </h2>
    </div>

    <p class="ww_home--text mb-4">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores</p>

    <div class="ww_license d-flex mb-4 justify-content-center">
        <ul class="ww_license--list">
			<li class="ww_license--items">
				<svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="17.001" height="17.003" viewBox="0 0 17.001 17.003"><path d="M16.766,5.8,15.451,4.488a.794.794,0,0,0-1.126,0L6.373,12.44l-3.7-3.7a.794.794,0,0,0-1.126,0L.231,10.056a.8.8,0,0,0,0,1.129l5.578,5.582a.794.794,0,0,0,1.126,0l9.828-9.835A.8.8,0,0,0,16.766,5.8ZM6,9.323a.527.527,0,0,0,.75,0L13.655,2.41a.533.533,0,0,0,0-.75l-1.5-1.5a.527.527,0,0,0-.75,0l-5.03,5.03L4.534,3.343a.527.527,0,0,0-.75,0l-1.5,1.5a.533.533,0,0,0,0,.75Z" transform="translate(0.004 0.002)" fill="#5643fa"/></svg>
				Lorem ipsum dolor sit amet, consetetur
			</li>
			<li class="ww_license--items">
				<svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="17.001" height="17.003" viewBox="0 0 17.001 17.003"><path d="M16.766,5.8,15.451,4.488a.794.794,0,0,0-1.126,0L6.373,12.44l-3.7-3.7a.794.794,0,0,0-1.126,0L.231,10.056a.8.8,0,0,0,0,1.129l5.578,5.582a.794.794,0,0,0,1.126,0l9.828-9.835A.8.8,0,0,0,16.766,5.8ZM6,9.323a.527.527,0,0,0,.75,0L13.655,2.41a.533.533,0,0,0,0-.75l-1.5-1.5a.527.527,0,0,0-.75,0l-5.03,5.03L4.534,3.343a.527.527,0,0,0-.75,0l-1.5,1.5a.533.533,0,0,0,0,.75Z" transform="translate(0.004 0.002)" fill="#5643fa"/></svg>
				Lorem ipsum dolor sit amet, consetetur
			</li>
			<li class="ww_license--items">
				<svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="17.001" height="17.003" viewBox="0 0 17.001 17.003"><path d="M16.766,5.8,15.451,4.488a.794.794,0,0,0-1.126,0L6.373,12.44l-3.7-3.7a.794.794,0,0,0-1.126,0L.231,10.056a.8.8,0,0,0,0,1.129l5.578,5.582a.794.794,0,0,0,1.126,0l9.828-9.835A.8.8,0,0,0,16.766,5.8ZM6,9.323a.527.527,0,0,0,.75,0L13.655,2.41a.533.533,0,0,0,0-.75l-1.5-1.5a.527.527,0,0,0-.75,0l-5.03,5.03L4.534,3.343a.527.527,0,0,0-.75,0l-1.5,1.5a.533.533,0,0,0,0,.75Z" transform="translate(0.004 0.002)" fill="#5643fa"/></svg>
				Lorem ipsum dolor sit amet, consetetur
			</li>
			
		</ul>
    </div>

    <div class="ww_plugin--rate d-flex flex-column align-items-center">
		<form method="post" action="">
		<div class="ant-row ant-form-item">
				<div class="ant-col ant-form-item-label">
					<label for="webhook-url" class="ant-form-item-required" title="License Key">License Key</label>
				</div>
				<div class="ant-col ant-form-item-control">
					<div class="ant-form-item-control-input">
						<div class="ant-form-item-control-input-content">
							<span class="ant-input-affix-wrapper">
								<input type="text" id="license_number" name="license_number" class="ant-input" placeholder="<?php echo "'".wordpress_webhooks()->helpers->translate( 'Enter license key', 'ww-page-triggers' )."'"; ?>">
							</span>
						</div>
					</div>
				</div>
			</div>
		
		<div class="d-flex flex-column align-items-center">

			<div class="ant-row ant-form-item" >
				<div class="ant-col ant-form-item-control">
					<div class="ant-form-item-control-input">
						<div class="ant-form-item-control-input-content">
							<button type="submit" name="submit" style="width: 15rem; height: 3.25rem" id="ww_submit" class="ant-btn ant-btn-primary ant-btn-block" ant-click-animating-without-extra-node="false">
								<span class="ant-btn-loading-icon">
									<span role="img" aria-label="loading" class="anticon anticon-loading anticon-spin">
										<svg viewBox="0 0 1024 1024" focusable="false" data-icon="loading" width="1em" height="1em" fill="currentColor" aria-hidden="true">
											<path d="M988 548c-19.9 0-36-16.1-36-36 0-59.4-11.6-117-34.6-171.3a440.45 440.45 0 00-94.3-139.9 437.71 437.71 0 00-139.9-94.3C629 83.6 571.4 72 512 72c-19.9 0-36-16.1-36-36s16.1-36 36-36c69.1 0 136.2 13.5 199.3 40.3C772.3 66 827 103 874 150c47 47 83.9 101.8 109.7 162.7 26.7 63.1 40.2 130.2 40.2 199.3.1 19.9-16 36-35.9 36z"></path>
										</svg>
									</span>
								</span>
								<span>Activate</span>
							</button>
						</div>
					</div>
				</div>
			</div>

			<div class="ant-row ant-form-item" >
				<div class="ant-col ant-form-item-control">
					<div class="ant-form-item-control-input">
						<div class="ant-form-item-control-input-content">
							<button type="submit" style="width: 15rem; height: 3.25rem; background-color: #707070; border:solid #707070" id="ww_submit" class="ant-btn ant-btn-primary ant-btn-block" ant-click-animating-without-extra-node="false">
								<span class="ant-btn-loading-icon">
									<span role="img" aria-label="loading" class="anticon anticon-loading anticon-spin">
										<svg viewBox="0 0 1024 1024" focusable="false" data-icon="loading" width="1em" height="1em" fill="currentColor" aria-hidden="true">
											<path d="M988 548c-19.9 0-36-16.1-36-36 0-59.4-11.6-117-34.6-171.3a440.45 440.45 0 00-94.3-139.9 437.71 437.71 0 00-139.9-94.3C629 83.6 571.4 72 512 72c-19.9 0-36-16.1-36-36s16.1-36 36-36c69.1 0 136.2 13.5 199.3 40.3C772.3 66 827 103 874 150c47 47 83.9 101.8 109.7 162.7 26.7 63.1 40.2 130.2 40.2 199.3.1 19.9-16 36-35.9 36z"></path>
										</svg>
									</span>
								</span>
								<span>Buy now</span>
							</button>
						</div>
					</div>
				</div>
			</div>
			
		
		</div>

		</form>
		<a href="#">Go to account</a>
	</div>
	
	<!-- <div class="ww_connect">
		<p style="color: #007cba;">CONNECT WITH US ON SOCIAL MEDIA</p>
		<div class="ww_connect--icons d-flex justify-content-center">
		<svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="7.74" height="14.451" viewBox="0 0 7.74 14.451"><path d="M8.842,8.128l.4-2.615H6.734v-1.7A1.308,1.308,0,0,1,8.208,2.4H9.349V.177A13.912,13.912,0,0,0,7.324,0,3.193,3.193,0,0,0,3.907,3.52V5.513h-2.3V8.128h2.3v6.322H6.734V8.128Z" transform="translate(-1.609)" fill="#395ff5"/></svg>
		<svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="14.862" height="14.859" viewBox="0 0 14.862 14.859"><path d="M7.427,5.857a3.81,3.81,0,1,0,3.81,3.81A3.8,3.8,0,0,0,7.427,5.857Zm0,6.286A2.477,2.477,0,1,1,9.9,9.667a2.481,2.481,0,0,1-2.477,2.477ZM12.281,5.7a.889.889,0,1,1-.889-.889A.887.887,0,0,1,12.281,5.7Zm2.523.9A4.4,4.4,0,0,0,13.6,3.49a4.426,4.426,0,0,0-3.113-1.2c-1.227-.07-4.9-.07-6.131,0a4.42,4.42,0,0,0-3.113,1.2A4.412,4.412,0,0,0,.047,6.6c-.07,1.227-.07,4.9,0,6.131a4.4,4.4,0,0,0,1.2,3.113,4.432,4.432,0,0,0,3.113,1.2c1.227.07,4.9.07,6.131,0a4.4,4.4,0,0,0,3.113-1.2,4.426,4.426,0,0,0,1.2-3.113c.07-1.227.07-4.9,0-6.127ZM13.22,14.047a2.507,2.507,0,0,1-1.412,1.412,16.376,16.376,0,0,1-4.38.3,16.5,16.5,0,0,1-4.38-.3,2.508,2.508,0,0,1-1.412-1.412,16.376,16.376,0,0,1-.3-4.38,16.5,16.5,0,0,1,.3-4.38A2.508,2.508,0,0,1,3.048,3.875a16.376,16.376,0,0,1,4.38-.3,16.5,16.5,0,0,1,4.38.3A2.508,2.508,0,0,1,13.22,5.287a16.376,16.376,0,0,1,.3,4.38A16.366,16.366,0,0,1,13.22,14.047Z" transform="translate(0.005 -2.238)" fill="#395ff5"/></svg>
		<svg xmlns="http://www.w3.org/2000/svg" width="16.081" height="13.061" viewBox="0 0 16.081 13.061"><path d="M14.428,6.636c.01.143.01.286.01.429a9.313,9.313,0,0,1-9.377,9.377A9.314,9.314,0,0,1,0,14.962,6.818,6.818,0,0,0,.8,15a6.6,6.6,0,0,0,4.092-1.408,3.3,3.3,0,0,1-3.082-2.286,4.156,4.156,0,0,0,.622.051,3.486,3.486,0,0,0,.867-.112A3.3,3.3,0,0,1,.653,8.013V7.973a3.319,3.319,0,0,0,1.49.418,3.3,3.3,0,0,1-1.02-4.408,9.368,9.368,0,0,0,6.8,3.449,3.721,3.721,0,0,1-.082-.755,3.3,3.3,0,0,1,5.7-2.255,6.489,6.489,0,0,0,2.092-.8,3.287,3.287,0,0,1-1.449,1.816,6.607,6.607,0,0,0,1.9-.51,7.085,7.085,0,0,1-1.653,1.7Z" transform="translate(0 -3.381)" fill="#395ff5"/></svg>
		</div>
	</div> -->
</div>


