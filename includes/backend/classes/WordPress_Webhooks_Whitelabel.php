<?php

/**
 * WordPress_Webhooks_Whitelabel Class
 *
 * This class contains the whole whitelabel functionality
 *
 * @since 3.0.6
 */

/**
 * The whitelist class of the plugin.
 *
 * @since 3.0.6
 * @package WW
 * @author Ironikus <info@ironikus.com>
 */
class WordPress_Webhooks_Whitelabel {

	/**
	 * WordPress_Webhooks_Whitelabel constructor.
	 */
	public function __construct() {
        $this->whitelabel_settings = wordpress_webhooks()->settings->get_whitelabel_settings( true );
	}

	/**
	 * Check if the whitelist is active
	 *
	 * @return bool - true if active, false if not
	 */
	public function is_active(){
        $return = false;
        
        if( empty( $this->whitelabel_settings ) ){
            return $return;
        }

        if( ! isset( $this->whitelabel_settings[ 'ww_whitelabel_activate' ] ) ){
            return $return;
        }

        if( $this->whitelabel_settings[ 'ww_whitelabel_activate' ] === 'yes' ){
            $return = true;
        }

        return apply_filters( 'ww/whitelabel/is_active', $return, $this->whitelabel_settings );
	}

	/**
	 * Check if the whitelist is active
	 *
	 * @return bool - true if active, false if not
	 */
	public function get_setting( $setting = '' ){
        $return = false;
        
        if( empty( $this->whitelabel_settings ) ){
            return $return;
        }

        if( ! isset( $this->whitelabel_settings[ $setting ] ) ){
            return $return;
        }

        $return = $this->whitelabel_settings[ $setting ];

        return apply_filters( 'ww/whitelabel/get_setting', $return, $setting, $this->whitelabel_settings );
    }
    
    /**
	 * Verify whitelabel feature based on a given license
	 *
	 * @param array $args - The arguments for the request (Currently supports only license)
	 * @return array - The response data of the request
	 */
	public function verify_whitelabel( $args ){

		if( empty( $args['license'] ) )
			return false;

		$home_url = home_url();

		$api_params = array(
			'wpwh_check_whitelabel'    	=> $args['license'],
			'wpwh_check_whitelabel_url'	=> $home_url
		);

		$response = wp_remote_post( PULL_BYTES, array( 'timeout' => 30, 'sslverify' => true, 'body' => $api_params ) );

		return $response;
	}
}
