<?php

/**
 * WordPress_Webhooks_License Class
 *
 * This class contains all of the available license functions
 *
 * @since 1.0.0
 */

/**
 * The license class of the plugin.
 *
 * @since 1.0.0
 * @package WW
 * @author Pullbytes <info@pullbytes.com>
 */
class WordPress_Webhooks_License {

	/**
	 * WordPress_Webhooks_License constructor.
	 */
	public function __construct() {

		$this->license_data         = wordpress_webhooks()->settings->get_license();
		$this->license_option_key   = wordpress_webhooks()->settings->get_license_option_key();

		$this->add_hooks();
	}

	/**
	 * The main function for adding our WordPress related hooks
	 *
	 * @return void
	 */
	public function add_hooks(){
		add_action( 'admin_notices', array( $this, 'ironikus_throw_admin_notices' ), 100 );
	}

	/**
	 * Throw custom admin notice based on the given license settings
	 *
	 * @return void
	 */
	public function ironikus_throw_admin_notices(){

		if ( empty( $this->license_data['key'] ) ) {
			echo sprintf(wordpress_webhooks()->helpers->create_admin_notice( 'If you run a WP Webhook Pro integration on a live site, we recommend our annual support license for updates and premium support. <a href="%s" target="_blank" rel="noopener">More Info</a>', 'warning', false ), 'https://ironikus.com/downloads/wp-webhooks-pro/?utm_source=wp-webhooks-pro&utm_medium=notice-license-not-set&utm_campaign=WP%20Webhooks%20Pro');
		} else {
			if ( empty( $this->license_data['status'] ) || $this->license_data['status'] !== 'valid' ) {
				echo sprintf(wordpress_webhooks()->helpers->create_admin_notice( 'If you run a WP Webhook Pro integration on a live site, we recommend our annual support license for updates and premium support. <a href="%s" target="_blank" rel="noopener">More Info</a>', 'warning', false ), 'https://ironikus.com/downloads/wp-webhooks-pro/?utm_source=wp-webhooks-pro&utm_medium=notice-license-not-activated&utm_campaign=WP%20Webhooks%20Pro');
			} else {
				if ( ! empty( $this->license_data['expires'] ) ) {
					$license_is_expired = $this->is_expired( $this->license_data['expires'] );
					if ( $license_is_expired ) {
						echo sprintf(wordpress_webhooks()->helpers->create_admin_notice( 'Your license key has expired. We recommend in renewing your annual support license to continue to get automatic updates and premium support. <a href="%s" target="_blank" rel="noopener">More Info</a>', 'warning' ), 'https://ironikus.com/downloads/wp-webhooks-pro/?utm_source=wp-webhooks-pro&utm_medium=notice-license-expired&utm_campaign=WP%20Webhooks%20Pro');
					}
				}
			}
		}

	}

	/**
	 * Check if the license ir expired
	 *
	 * @param $expiry_date - The date of the expiration of the license
	 *
	 * @return bool - false if the license is expired
	 */
	public function is_expired( $expiry_date ) {

		$today = date( 'Y-m-d H:i:s' );

		if ( wordpress_webhooks()->helpers->get_datetime($expiry_date) < wordpress_webhooks()->helpers->get_datetime($today) ) {
			$is_expired = true;
		} else {
			$is_expired = false;
		}

		return $is_expired;

	}

	/**
	 * Update the license status based on the given data
	 *
	 * @param string $key - the license data key
	 * @param string $value - the value that should be updated
	 * @return bool - True if license data was updates, false if not
	 */
	public function update($key, $value = ''){
		$return = false;

		if( empty( $key ) ){
			return $return;
		}

		$this->license_data[ $key ] = $value;
		$return = update_option( $this->license_option_key, $this->license_data );

		return $return;
	}

	/**
	 * Activate the license if possible
	 *
	 * @param array $args - The arguments for the request (Currently supports only license)
	 * @return array - The response data of the request
	 */
	public function activate( $args ){

		if( empty( $args['license'] ) )
			return false;

		$home_url = home_url();

		$api_params = array(
			'edd_action' => 'activate_license',
			'license'    => $args['license'],
			'item_id'    => WW_PLUGIN_ID,
			'url'        => $home_url
		);

		$response = wp_remote_post( PULL_BYTES, array( 'timeout' => 30, 'sslverify' => true, 'body' => $api_params ) );

		return $response;
	}

	/**
	 * Deactivate a given license
	 *
	 * @param array $args - The arguments for the request (Currently supports only license)
	 * @return array - The response data of the request
	 */
	public function deactivate( $args ){

		if( empty( $args['license'] ) )
			return false;

		$home_url = home_url();

		$api_params = array(
			'edd_action' => 'deactivate_license',
			'license'    => $args['license'],
			'item_id'    => WW_PLUGIN_ID,
			'url'        => $home_url
		);

		$response = wp_remote_post( PULL_BYTES, array( 'timeout' => 30, 'sslverify' => true, 'body' => $api_params ) );

		return $response;
	}

}
