<?php

/**
 * WordPress_Webhooks_Whitelist Class
 *
 * This class contains the whole whitelist functionality
 *
 * @since 1.5.7
 */

/**
 * The whitelist class of the plugin.
 *
 * @since 1.5.7
 * @package WW
 * @author Pullbytes <info@pullbytes.com>
 */
class WordPress_Webhooks_Whitelist {

	private $is_active = null;
	private $whitelist = null;
	private $whitelist_requests = null;

	/**
	 * WordPress_Webhooks_Whitelist constructor.
	 */
	public function __construct() {
		$this->is_active();
	}

	/**
	 * Check if the whitelist is active
	 *
	 * @return bool - true if active, false if not
	 */
	public function is_active(){
		if( $this->is_active !== null ){
			return $this->is_active;
		}

		if( get_option( 'ww_activate_whitelist' ) == 'yes' ){
			$this->is_active = true;
			return true;
		} else {
			$this->is_active = false;
			return false;
		}
	}

	/**
	 * Get the whitelist data
	 *
	 * @return array - an array of whitelisted files
	 */
	public function get_list(){
		if( $this->whitelist !== null ){
			return $this->whitelist;
		}

		$whitelist_data = get_option( wordpress_webhooks()->settings->get_whitelist_option_key() );
		if( ! is_array( $whitelist_data ) ){
			$whitelist_data = array();
		}

		$this->whitelist = $whitelist_data;
		return $whitelist_data;
	}

	/**
	 * Add an ip to the whitelist
	 *
	 * @param $ip - the ip address
	 *
	 * @return bool - true if ip was added, false if not
	 */
	public function add_item( $ip ){
		$list = $this->get_list();
		$key = md5( $ip );
		$return = false;

		if( ! isset( $list[ $key ] ) ){
			$list[ $key ] = $ip;

			update_option( wordpress_webhooks()->settings->get_whitelist_option_key(), $list );
			$this->whitelist = $list;
			$return = true;
		}

		return $return;
	}

	/**
	 * Delete an IP from the whitelist
	 *
	 * @param $key - The key of the deleted item (md5 value of ip)
	 *
	 * @return bool - true if deleted, false if not
	 */
	public function delete_item( $key ){
		$list = $this->get_list();
		$return = false;

		if( isset( $list[ $key ] ) ){
			unset( $list[ $key ] );

			update_option( wordpress_webhooks()->settings->get_whitelist_option_key(), $list );
			$this->whitelist = $list;
			$return = true;
		}

		return $return;
	}

	/**
	 * Wether the incoming request is whitelisted or not
	 *
	 * @return bool - true if whitelisted, false if not
	 */
	public function is_valid_request(){
		$list = $this->get_list();
		$current_ip = wordpress_webhooks()->helpers->get_current_ip();

		if( in_array( $current_ip, $list ) ){
			$return = true;
		} else {
			$return = false;
		}

		return $return;
	}

	/**
	 * ######################
	 * ###
	 * #### WHITELIST REQUESTS
	 * ###
	 * ######################
	 */

	/**
	 * Returns an list of the last 20 ip requests to your website,
	 * that are not whitelisted.
	 *
	 * @return array - an array of the requested ip addresses
	 */
	public function get_request_list(){
		if( $this->whitelist_requests !== null ){
			return $this->whitelist_requests;
		}

		$whitelist_request_data = get_option( wordpress_webhooks()->settings->get_whitelist_requests_option_key() );
		if( ! is_array( $whitelist_request_data ) ){
			$whitelist_request_data = array();
		}

		krsort( $whitelist_request_data );

		$this->whitelist_requests = $whitelist_request_data;
		return $whitelist_request_data;
	}

	/**
	 * Adds a request from an ip to the request array/option
	 *
	 * @param $ip - the ip address that makes the request
	 * @param array $request_data - Advanced data abaut the request
	 *
	 * @return bool - true if request was added, false if not
	 */
	public function add_request( $ip, $request_data = array() ){
		$list = $this->get_request_list();
		$key = time();
		$return = false;

		if( ! isset( $list[ $key ] ) ){
			$list[ $key ] = array(
				'ip' => $ip,
				'data' => $request_data
			);

			krsort( $list );

			if( count( $list ) > 20 ){
				$diff = count( $list ) - 20;
				while( $diff > 0 ){
					array_pop( $list );
					$diff--;
				}
			}

			update_option( wordpress_webhooks()->settings->get_whitelist_requests_option_key(), $list );
			$this->whitelist_requests = $list;
			$return = true;
		}

		return $return;
	}
}
