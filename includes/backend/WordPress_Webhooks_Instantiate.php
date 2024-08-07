<?php

/**
 * WordPress_Webhooks_Instantiate Class
 *
 * This class contains all of the available api functions
 *
 * @since 1.0.0
 */

/**
 * The webhook class of the plugin.
 *
 * @since 1.0.0
 * @package WW
 * @author Pullbytes <info@pullbytes.com>
 */
class WordPress_Webhooks_Instantiate {

	/**
	 * Add the option key for s
	 *
	 * @var - the webhook option key
	 */
	private $webhook_options_key;

	public function __construct() {
		$this->webhook_options_key = wordpress_webhooks()->settings->get_webhook_option_key();
		$this->webhook_ident_param = wordpress_webhooks()->settings->get_webhook_ident_param();

		$this->webhook_options = $this->setup_webhooks();
		$this->add_hooks();
	}

	/**
	 * Add all necessary hooks for preloading the data
	 */
	private function add_hooks(){

		if( is_admin() ){
			add_action( 'plugins_loaded', array( $this, 'initialize_default_webhook' ), 10 );
		}

		add_action( 'init', array( $this, 'validate_incoming_data' ), 100 );
	}

	/**
	 * ######################
	 * ###
	 * #### OPTION LOGIC
	 * ###
	 * ######################
	 */

	/**
	 * Initialize all available webhooks for
	 * a better performance
	 *
	 * @return array
	 */
	private function setup_webhooks(){
		$webhook_data = get_option( $this->webhook_options_key );

		if( empty( $webhook_data ) || ! is_array( $webhook_data ) ){
			$webhook_data = array();
		}

		foreach( $webhook_data as $wd_key => $wd_val ){

			switch( $wd_key ){
				case 'action':
					foreach( $webhook_data[ $wd_key ] as $wds_key => $wds_val ){
						if( is_array( $webhook_data[ $wd_key ][ $wds_key ] ) ){
							$webhook_data[ $wd_key ][ $wds_key ]['webhook_name'] = $wds_key;
						}
					}
					break;
				case 'trigger':
				foreach( $webhook_data[ $wd_key ] as $wds_key => $wds_val ){
					if( is_array( $webhook_data[ $wd_key ][ $wds_key ] ) ){
						foreach( $webhook_data[ $wd_key ][ $wds_key ] as $wdss_key => $wdss_val ){
							if( is_array( $webhook_data[ $wd_key ][ $wds_key ][ $wdss_key ] ) ){
								$webhook_data[ $wd_key ][ $wds_key ][ $wdss_key ]['webhook_name'] = $wds_key;
							}
						}
					}
				}
					break;
			}

		}

		return $webhook_data;
	}

	/**
	 * Get all of the available webhooks
	 *
	 * This is the main handler function for all
	 * of our triggers and actions.
	 *
	 * @param string $type - the type of the hooks you want to get (triggers, actions, all (default))
	 * @param string $group - Wether you want to display grouped ones or not
	 * @param string $single - In case you want to output a single one
	 *
	 * @return array|mixed - An array of the available webhooks
	 */

	public function get_hooks( $type = 'all', $group = '', $single = '' ){
		if( $type != 'all' ){
			if( isset( $this->webhook_options[ $type ] ) && ! empty( $group ) ){
				if( isset( $this->webhook_options[ $type ][ $group ] ) ){
					if( ! empty( $single ) ){
						$return = $this->webhook_options[ $type ][ $group ][ $single ];
					} else {
						$return = $this->webhook_options[ $type ][ $group ];
					}
				} else {
					$return = array();
				}
			} else {

				if( isset( $this->webhook_options[ $type ] ) ){
					if( ! empty( $single ) ){
						$return = $this->webhook_options[ $type ][ $single ];
					} else {
						$return = $this->webhook_options[ $type ];
					}
				} else {
					//Return empty array if nothing is set
					$return = array();
				}

			}
		} else {
			$return = $this->webhook_options;
		}

		if( empty( $return ) ){
			$return = array();
		}

		return apply_filters( 'ww_get_hooks', $return, $type, $group, $single ) ;
	}
	/**
	 * Set custom webhooks inside of our array()
	 *
	 * @param $key - The key of the single webhook (not the idetifier)
	 * @param $type - the type of the hooks you want to get (triggers, actions, all (default))
	 * @param $data - (array) The custom data of the specified webhook
	 * @param string $group - (Optional) A webhook group
	 *
	 * @return bool - True if the hook was successfully set
	 */
	public function set_hooks( $key, $type, $data){
		$return = false;

		if( empty( $key ) || empty( $type ) || empty( $data ) ){
			return $return;
		}

		if( ! isset( $this->webhook_options[ $type ] ) ){
			$this->webhook_options[ $type ] = array();
		}

		// var_dump($this->webhook_options);
		$this->webhook_options[$type][ $key ] = $data;
		$return = update_option( $this->webhook_options_key, $this->webhook_options );
	

		return $return;
	}

	/**
	 * Remove a hook from the currently set arrays
	 *
	 * @param $webhook - The slug of the webhook
	 * @param $type - the type of the hooks you want to get (triggers, actions, all (default))
	 * @param string $group - (Optional) A webhook group
	 *
	 * @return bool - Wether the webhook was deleted or not
	 */

	public function unset_hooks( $webhook, $type){

		if( empty( $webhook ) || empty( $type ) )
			return false;


		if( isset( $this->webhook_options[ $type ] ) ){
			
			if( isset( $this->webhook_options[ $type ][ $webhook ] ) ){
				unset( $this->webhook_options[ $type ][ $webhook ] );
				return update_option( $this->webhook_options_key, $this->webhook_options );
			}
		
		} else {
			//return true if it doesnt exist
			return true;
		}

		return false;
	}


	/**
	 * Register a new webhook URL
	 *
	 * @param $webhook - The webhook name
	 * @param $type - the type of the hooks you want to get (triggers, actions, all (default))
	 * @param array $args - Custom attributes depending on the webhooks
	 * @param string $permission - in case a custom permission is set
	 *
	 * @return bool - Wether the webhook url was created or not
	 */
	public function create( $webhook, $type, $args = array(), $permission = '' ){

		if( empty( $webhook ) || empty( $type ) ){
			return false;
		}

		$permission_set = wordpress_webhooks()->settings->get_admin_cap('default_webhook');
		if( ! empty( $permission ) ){
			$permission_set = $permission;
		}

		$data = array(
			'permission'    => $permission_set,
			'date_created'  => date( 'Y-m-d H:i:s' )
		);

		$group = '';
		switch( $type ){
			case 'action':
				$data['api_key'] = $this->generate_api_key();
				$data['webhook_url'] = wordpress_webhooks()->webhook->built_url( $webhook, $data['api_key'] );
				break;
			case 'trigger':
				$data['webhook_url'] = $args['webhook_url'];
				$data['webhook_name'] = $args['group'];
				$data['webhook_callback'] = $args['webhook_callback'];


				if( isset( $args['settings'] ) && is_array( $args['settings'] ) ){
					$data['settings'] = $args['settings'];
				}

				
				break;
		}

		$data['status'] = $args['webhook_status'];
		

		return $this->set_hooks( $webhook, $type, $data);

	}

	/**
	 * Update an existig webhook URL
	 *
	 * @param $key - The webhook identifier
	 * @param $type - the type of the hooks you want to get (triggers, actions, all (default))
	 * @param array $args - Custom attributes depending on the webhooks
	 *
	 * @return bool - Wether the webhook was updated or not
	 */
	public function update( $key, $type, $args = array() ){

		if( empty( $key ) || empty( $type ) ){
			return false;
		}

		$current_hooks = $this->get_hooks();
		$data = array();

		if( isset( $current_hooks[ $type ] ) ){
			if( isset( $current_hooks[ $type ][ $key ] ) ){
				$data = $current_hooks[ $type ][ $key ];
			}
		}

		$check = false;
		if( ! empty( $data ) ){
			$data = array_merge( $data, $args );

			//Revalidate the settings data with the $data array
			if( isset( $args['settings'] ) ){

				$data['settings'] = $args['settings'];

				//Remove empty entries since we don't want to save what's not necessary
				foreach( $data['settings'] as $skey => $sdata ){
					if( $sdata === '' ){
						unset( $data['settings'][ $skey ] );
					}
				}

			}

			$check = $this->set_hooks( $key, $type, $data);
		}

		return $check;

	}

	/**
	 * Initialize the default webhook url
	 */
	public function initialize_default_webhook(){

		if( ! empty( $this->webhook_options['action'] ) ){
			return;
		}

		$default_wehook = apply_filters( 'ww_default_webhook_name', 'ww_default_' . rand( 1000, 9999 ) );

		$api_key       	= $this->generate_api_key();	
		$webhook_url	= wordpress_webhooks()->webhook->built_url( $default_wehook, $api_key );

		$data = array(
			'api_key'       => $api_key,	
			'webhook_url'	=> $webhook_url,
			'permission'    => wordpress_webhooks()->settings->get_admin_cap('default_webhook'),
			'date_created'  => date( 'Y-m-d H:i:s' )
		);
		$this->set_hooks( $default_wehook, 'action', $data );

	}

	public function generate_api_key( $length = 64 ){

		if( ! is_int( $length ) ){
			$length = 64; //Fallack on non-integers
		}

		$password = strtolower( wp_generate_password( $length, false ) );

		return apply_filters( 'ww_generate_api_key', $password, $length );
	}

	/**
	 * ######################
	 * ###
	 * #### CORE LOGIC
	 * ###
	 * ######################
	 */

	/*
	 * The core logic for reseting our plugin
	 *
	 * @since 1.6.4
	 */
	public function reset_ww(){

		//Reset settings
		$settings = wordpress_webhooks()->settings->get_settings();
		foreach( $settings as $key => $value ){
			if( $key ){
				delete_option( $key );
			}
		}

		//Reset Whitelist
		delete_option( wordpress_webhooks()->settings->get_whitelist_option_key() );

		//Reset active webhook parameter and all its data
		delete_option( wordpress_webhooks()->settings->get_active_webhooks_ident() );

		//Reset all the webhook settings
		delete_option( wordpress_webhooks()->settings->get_webhook_option_key() );

		//Reset the log key
		delete_option( 'ww_activate_logs' );

		//Reset the log table
		wordpress_webhooks()->logs->delete_table();

		//Reset data mapping
		wordpress_webhooks()->data_mapping->delete_table();

		//Reset authentication
		wordpress_webhooks()->auth->delete_table();

	}

	/**
	 * Create the webhook url for the specified webhook
	 *
	 * @param $webhook - the webhook ident
	 * @param $api_key - the api key on the webhook
	 *
	 * @return string - the webhook url
	 */
	public function built_url( $webhook, $api_key ){

		$args = apply_filters( 'ww/admin/webhooks/url_args', array(
			$this->webhook_ident_param => $webhook,
			'ww_api_key' => $api_key
		) );

		$url = add_query_arg( $args, wordpress_webhooks()->helpers->safe_home_url( '/' ) );
		return $url;
	}

	/**
	 * Function to output all the available arguments for actions
	 *
	 * @since 3.0.7
	 * @param array $args
	 */
	public function echo_action_data( $args = array() ){

		$response_body = wordpress_webhooks()->helpers->get_response_body();
		$action = $this->get_incoming_action( $response_body );
		
		$validated_data = $this->echo_response_data( $args );

		do_action( 'ww/webhooks/echo_action_data', $action, $validated_data );

		return $validated_data;
	}

	/**
	 * Function to output all the available json arguments.
	 *
	 * @param array $args
	 */
	public function echo_response_data( $args = array() ){
		$return = array(
			'arguments' => $args,
			'response_type' => '',
		);

		$response_body = wordpress_webhooks()->helpers->get_response_body();
		$response_type = sanitize_title( wordpress_webhooks()->helpers->validate_request_value( $response_body['content'], 'response_type' ) );

		if( empty( $response_type ) ){
			$response_type = 'json';
		}

		$response_type = apply_filters( 'ww/webhooks/response_response_type', $response_type, $args );
		$args = apply_filters( 'ww/webhooks/response_json_arguments', $args, $response_type );

		switch( $response_type ){
			case 'xml':
				header( 'Content-Type: application/xml' );
				$xml = new SimpleXMLElement('<root/>');
				array_walk_recursive($args, array ($xml, 'addChild'));
				print $xml->asXML();
				break;
			case 'json':
			default:
				header( 'Content-Type: application/json' );
				echo json_encode( $args );
				break;
		}

		$return['arguments'] = $args;
		$return['response_type'] = $response_type;

		return $return;
	}

	/**
	 * ######################
	 * ###
	 * #### RECIPIENTS LOGIC
	 * ###
	 * ######################
	 */

	/**
	 * Display the actions in our backend actions table
	 *
	 * The structure to include your recpient looks like this:
	 * array( 'action' => 'my-action', 'parameter' => array( 'my_parameter' => array( 'short_description => 'my text', 'required' => true ) ), 'short_description' => 'This is my short description.', 'description' => 'My HTML Content' )
	 */
	public function get_actions( $active_webhooks = true ){
		return apply_filters( 'ww_get_webhooks_actions', array(), $active_webhooks );
	}
	/**
	 * Display the actions in our frontend actions table
	 *
	 * The structure to include your recpient looks like this:
	 * array( 'action' => 'my-action', 'parameter' => array( 'my_parameter' => array( 'short_description => 'my text', 'required' => true ) ), 'short_description' => 'This is my short description.', 'description' => 'My HTML Content' )
	 */
	public function get_triggers( $active_webhooks = true, $single = '', $trigger_name='' ){

		$triggers = apply_filters( 'ww_get_webhooks_triggers', array(), $active_webhooks );
		
		if( ! empty( $single ) ){
			foreach($triggers as $trigger){
				if( isset( $trigger[ $single ] ) && $trigger[ $single ] == $trigger_name){
					return $trigger;
				} 
			}
		}
		else {
			return $triggers;
		}


	}

	public function get_incoming_action( $response_body = false ){

		if( $response_body === false ){
			$response_body = wordpress_webhooks()->helpers->get_response_body();
		}

		$action = wordpress_webhooks()->helpers->validate_request_value( $response_body['content'], 'action' );
		if( empty( $action ) ){
			if( ! empty( $_REQUEST['action'] ) ){
				$action = sanitize_title( $_REQUEST['action'] );
			} else {
				$action = '';
			}

			if( empty( $action ) ){
				wordpress_webhooks()->helpers->log_issue( wordpress_webhooks()->helpers->translate( "The incoming webhook call did not contain any action argument.", 'admin-debug-feature' )  );
			}
		}

		return apply_filters( 'ww/webhooks/get_incoming_action', $action, $response_body );
	}

	/**
	 * Validate an incoming webhook action
	 */
	public function validate_incoming_data(){
		$webhooks = $this->get_hooks( 'action' );
		$response_auth_request = ( isset( $_REQUEST['ww_auth_response'] ) && intval( $_REQUEST['ww_auth_response'] ) === 1 ) ? true : false;
		$response_api_key = ! empty( $_REQUEST['ww_api_key'] ) ? sanitize_key( $_REQUEST['ww_api_key'] ) : '';
		$response_ident_value = ! empty( $_REQUEST[$this->webhook_ident_param] ) ? sanitize_key( $_REQUEST[$this->webhook_ident_param] ) : '';

		if( empty( $response_api_key ) || empty( $response_ident_value ) ){
			return;
		}

		//Setup default response
		$return = array(
			'success' => false
		);

		//Validate against inactive action webhooks
		if( isset( $webhooks[ $response_ident_value ] ) && isset( $webhooks[ $response_ident_value ]['status'] ) ){
			if( $webhooks[ $response_ident_value ]['status'] === 'inactive' ){
				status_header( 403 );
				$return['msg'] = sprintf( wordpress_webhooks()->helpers->translate( 'Your current %s webhook is deactivated. Please activate it first.', 'webhooks-deactivated-webhook' ), WW_NAME );
				wordpress_webhooks()->webhook->echo_response_data( $return );
				exit;
			}
		}
		
		$response_body = wordpress_webhooks()->helpers->get_response_body();

		if( wordpress_webhooks()->whitelist->is_active() ){
			if( ! wordpress_webhooks()->whitelist->is_valid_request() ){
				wordpress_webhooks()->whitelist->add_request( wordpress_webhooks()->helpers->get_current_ip(),$response_body );

				status_header( 403 );
				$return['msg'] = wordpress_webhooks()->helpers->translate( 'You don\'t have permission to post data to this site since you are not on the whitelist.', 'webhooks-invalid-ip-invalid' );
				wordpress_webhooks()->webhook->echo_response_data( $return );
				exit;
			}
		}

		// set the output to be JSON. (Default)
		header( 'Content-Type: application/json' );

		$action = $this->get_incoming_action( $response_body );

		if( isset( $webhooks[ $response_ident_value ] ) ){
			if( $webhooks[ $response_ident_value ]['api_key'] != $response_api_key ){
				status_header( 403 );
				$return['msg'] = sprintf( wordpress_webhooks()->helpers->translate( 'The given %s API Key is not valid, please enter a valid API key and try again.', 'webhooks-invalid-license-invalid' ), WW_NAME );
				wordpress_webhooks()->webhook->echo_response_data( $return );
				exit;
			}
		} else {
			status_header( 403 );
			$return['msg'] = sprintf( wordpress_webhooks()->helpers->translate( 'The given %s API Key is missing, please add it first.', 'webhooks-invalid-license-missing' ), WW_NAME );
			wordpress_webhooks()->webhook->echo_response_data( $return );
			exit;
		}

		$message = wordpress_webhooks()->helpers->translate( 'Action request received.', 'ww-admin-webhooks' );
		$log_data = array(
			'webhook_type' => 'action',
			'identifier' => wordpress_webhooks()->helpers->get_current_ip(),
			'webhook_name' => $response_ident_value,
			'request_data' => $response_body,
		);
		wordpress_webhooks()->logs->add_log( $message, $log_data );

		if( is_array($webhooks[ $response_ident_value ]) && isset( $webhooks[ $response_ident_value ]['settings'] ) && ! empty( $webhooks[ $response_ident_value ]['settings'] ) ){

			foreach( $webhooks[ $response_ident_value ]['settings'] as $settings_name => $settings_data ){

				if( $settings_name === 'ww_action_access_token' && ! empty( $settings_data ) ){
					$access_token = wordpress_webhooks()->helpers->validate_request_value( $response_body['content'], 'access_token' );

					if( empty( $access_token ) || $access_token !== $settings_data ){
						status_header( 403 );
						$return['msg'] = wordpress_webhooks()->helpers->translate( 'Your configured access token for this webhook URL is not valid.', 'webhooks-invalid-access-token' );
						wordpress_webhooks()->webhook->echo_response_data( $return );
						exit;
					}
				}

				if( $settings_name === 'ww_action_action_whitelist' && ! empty( $settings_data ) ){
					if( ! in_array( $action, $settings_data ) ){
						status_header( 403 );
						$return['msg'] = wordpress_webhooks()->helpers->translate( 'You don\'t have permission to use this specific webhook action.', 'webhooks-invalid-access-token' );
						wordpress_webhooks()->webhook->echo_response_data( $return );
						exit;
					}
				}

			}

		}

		//Return auth request
		if( $response_auth_request ){
			$return_auth = array(
				'success' => true,
				'msg' => wordpress_webhooks()->helpers->translate( 'The authentication was successful', 'webhooks-auth-response-success' ),
				'domain' => home_url(),
				'name' => ( ! empty( $response_ident_value ) ) ? $response_ident_value : 'none'
			);
			wordpress_webhooks()->webhook->echo_response_data( $return_auth );
			die();
		}

		/*
		 * Register all of our available action actions
		 */
		do_action( 'ww/webhooks/add_webhooks_actions', $action, $response_ident_value, $response_api_key );
	}

	public function generate_trigger_signature( $data, $secret ) {
		$hash_signature = apply_filters( 'ww/admin/webhooks/webhook_trigger_signature', 'sha256', $data );

		return base64_encode( hash_hmac( $hash_signature, $data, $secret, true ) );
	}

	/**
	 * Our external API Call to post a certain trigger
	 *
	 * @param $url
	 * @param $data
	 *
	 * @return array
	 */
	public function post_to_webhook( $webhook, $data, $args = array(), $skip_validation = false ){

		/*
		 * Allow also to send the whole webhook
		 * @since 1.6.4
		 */
		if( is_array( $webhook ) ){
			$url = $webhook['webhook_url'];
		} else {
			$url = $webhook;
		}

		/*
		 * Validate default settings
		 *
		 * @since 1.6.4
		 */
		$response = array(
			'success' => false,
			'is_valid' => true,
		);
		$response_content_type_slug = 'json';
		$response_content_type_method = 'POST';
		$response_content_type = 'application/json';
		$webhook_name = ( is_array($webhook) && isset( $webhook['webhook_name'] ) ) ? $webhook['webhook_name'] : '';
		$authentication_data = array();
		$allow_unsafe_urls = false;
		$allow_unverified_ssl = false;

		//Required settings
		if( is_array($webhook) && isset( $webhook['settings'] ) && ! empty( $webhook['settings'] ) ) {

			foreach ( $webhook['settings'] as $settings_name => $settings_data ) {

				//Data Mapping
				if( $settings_name === 'ww_trigger_data_mapping' && ! empty( $settings_data ) ){

					if( is_numeric( $settings_data ) ){
						$template = wordpress_webhooks()->data_mapping->get_data_mapping( $settings_data );
						if( ! empty( $template ) && ! empty( $template->template ) ){
							$sub_template_data = base64_decode( $template->template );
							if( ! empty( $sub_template_data ) && wordpress_webhooks()->helpers->is_json( $sub_template_data ) ){
								$template_data = json_decode( $sub_template_data, true );
								if( ! empty( $template_data ) ){
									$data = wordpress_webhooks()->data_mapping->map_data_to_template( $data, $template_data, 'trigger' );
								}
							}
						}
					}
				
				}

				//Authentication
				if( $settings_name === 'ww_trigger_authentication' && ! empty( $settings_data ) ){

					if( is_numeric( $settings_data ) ){
						$template = wordpress_webhooks()->auth->get_auth_templates( $settings_data );
						if( ! empty( $template ) && ! empty( $template->template ) && ! empty( $template->auth_type ) ){
							$sub_template_data = base64_decode( $template->template );
							if( ! empty( $sub_template_data ) && wordpress_webhooks()->helpers->is_json( $sub_template_data ) ){
								$template_data = json_decode( $sub_template_data, true );
								if( ! empty( $template_data ) ){
									$authentication_data = array(
										'auth_type' => $template->auth_type,
										'data' => $template_data
									);
								}
							}
						}
					}
				
				}

				if( $settings_name === 'ww_trigger_response_type' && ! empty( $settings_data ) ){

					switch( $settings_data ){
						case 'form':
							$response_content_type_slug = 'form';
							$response_content_type = 'application/x-www-form-urlencoded';
							break;
						case 'xml':
							if( extension_loaded('simplexml') ){
								$response_content_type_slug = 'xml';
								$response_content_type = 'application/xml';
							} else {
								$response['msg'] = wordpress_webhooks()->helpers->translate( 'SimpleXML is not activated on your server. Please activate it first or switch the content type of your webhook.', 'ww-admin-webhooks' );
								$response['is_valid'] = false;
							}
							break;
						case 'json':
						default:
							//Just for reference
							$response_content_type_slug = 'json';
							$response_content_type = 'application/json';
							break;
					}

				}

				if( $settings_name === 'ww_trigger_request_method' && ! empty( $settings_data ) ){

					switch( $settings_data ){
						case 'GET':
							$response_content_type_method = 'GET';
							break;
						case 'HEAD':
							$response_content_type_method = 'HEAD';
							break;
						case 'PUT':
							$response_content_type_method = 'PUT';
							break;
						case 'DELETE':
							$response_content_type_method = 'DELETE';
							break;
						case 'TRACE':
							$response_content_type_method = 'TRACE';
							break;
						case 'OPTIONS':
							$response_content_type_method = 'OPTIONS';
							break;
						case 'PATCH':
							$response_content_type_method = 'PATCH';
							break;
						case 'POST':
						default:
							//Just for reference
							$response_content_type_method = 'POST';
							break;
					}

				}

				//Allow unsafe URLs
				if( $settings_name === 'ww_trigger_allow_unsafe_urls' && (integer) $settings_data === 1 ){
					$allow_unsafe_urls = true;
				}

				//Allow unverified SSL
				if( $settings_name === 'ww_trigger_allow_unverified_ssl' && (integer) $settings_data === 1 ){
					$allow_unverified_ssl = true;
				}

			}
		}

		if( is_array($webhook) && isset( $webhook['settings'] ) && ! empty( $webhook['settings'] ) && ! $skip_validation ){

			foreach( $webhook['settings'] as $settings_name => $settings_data ){

				if( $settings_name === 'ww_user_must_be_logged_in' && (integer) $settings_data === 1 ){
					if( ! is_user_logged_in() ){
						$response['msg'] = wordpress_webhooks()->helpers->translate( 'Trigger not sent because the settings did not match.', 'ww-admin-webhooks' );
						$response['is_valid'] = false;
					}
				}

				if( $settings_name === 'ww_user_must_be_logged_out' && (integer) $settings_data === 1 ){
					if( is_user_logged_in() ){
						$response['msg'] = wordpress_webhooks()->helpers->translate( 'Trigger not sent because the settings did not match.', 'ww-admin-webhooks' );
						$response['is_valid'] = false;
					}
				}

				if( $settings_name === 'ww_trigger_backend_only' && (integer) $settings_data === 1 ){
					if( ! is_admin() ){
						$response['msg'] = wordpress_webhooks()->helpers->translate( 'Trigger not sent because the settings did not match.', 'ww-admin-webhooks' );
						$response['is_valid'] = false;
					}
				}

				if( $settings_name === 'ww_trigger_frontend_only' && (integer) $settings_data === 1 ){
					if( is_admin() ){
						$response['msg'] = wordpress_webhooks()->helpers->translate( 'Trigger not sent because the settings did not match.', 'ww-admin-webhooks' );
						$response['is_valid'] = false;
					}
				}

			}

		}

		//Validate against inactive action webhooks
		if( isset( $webhook['status'] ) && ! $skip_validation ){
			if( $webhook['status'] === 'inactive' ){
				$response['msg'] = wordpress_webhooks()->helpers->translate( 'The following webhook trigger url is deactivated. Please activate it first.', 'webhooks-deactivated-webhook' );
				$response['is_valid'] = false;
			}
		}

		$response = apply_filters( 'ww/admin/webhooks/is_valid_trigger_response', $response, $webhook, $data, $args );

		if( $response['is_valid'] === false ){
			return $response;
		}

		$http_args = array(
			'method'      => $response_content_type_method,
			'timeout'     => MINUTE_IN_SECONDS,
			'redirection' => 0,
			'httpversion' => '1.0',
			'blocking'    => false,
			'user-agent'  => sprintf(  WW_NAME . '/%s Trigger (WordPress/%s)', WW_VERSION, $GLOBALS['wp_version'] ),
			'headers'     => array(
				'Content-Type' => $response_content_type,
			),
			'cookies'     => array(),
		);

		if( $allow_unverified_ssl ){
			$http_args['sslverify'] = false;
		}

		$data = apply_filters( 'ww/admin/webhooks/webhook_data', $data, $response, $webhook, $args, $authentication_data );

		switch( $response_content_type_slug ){
			case 'form':
				$http_args['body'] = $data;
				break;
			case 'xml':
				$sxml_data = apply_filters( 'ww/admin/webhooks/simplexml_data', '<data/>', $http_args );
				$xml_data = $data;
				$xml = wordpress_webhooks()->helpers->convert_to_xml( new SimpleXMLElement( $sxml_data ), $xml_data );
				$http_args['body'] = $xml->asXML();
				break;
			case 'json':
			default:
				$http_args['body'] = trim( wp_json_encode( $data ) );
				break;
		}

		//Add charset if available
		$blog_charset = get_option( 'blog_charset' );
		if ( ! empty( $blog_charset ) ) {
			$http_args['headers']['Content-Type'] .= '; charset=' . $blog_charset;
		}

		$http_args = apply_filters( 'ww/admin/webhooks/webhook_http_args', array_merge( $http_args, $args ), $args, $url, $webhook, $authentication_data );

		$http_args['headers']['X-WP-Webhook-Source'] = home_url( '/' );
		$http_args['headers']['X-WP-Webhook-Name'] = $webhook_name;

		$secret_key = get_option( 'ww_trigger_secret' ); //deprecated since 3.0.1
		/*
		 * Set a custom secret key
		 * @since 3.0.1
		 */
		$secret_key = apply_filters( 'ww/admin/webhooks/secret_key', $secret_key, $webhook, $args, $authentication_data );
		if( ! empty( $secret_key ) ){
			$http_args['headers']['X-WP-Webhook-Signature'] = $this->generate_trigger_signature( $http_args['body'], $secret_key );
		}	

		if( $allow_unsafe_urls ){
			$response = wp_remote_request( $url, $http_args );
		} else {
			$response = wp_safe_remote_request( $url, $http_args );	
		}	

		$message = wordpress_webhooks()->helpers->translate( 'Trigger successfully sent!', 'ww-admin-webhooks' );
		$log_data = array(
			'webhook_type' => 'trigger',
			'webhook_name' => $webhook_name,
			'identifier' => $url,
			'request_data' => $http_args,
			'response_data' => $response,
		);
		wordpress_webhooks()->logs->add_log( $message, $log_data );

		do_action( 'ww/admin/webhooks/webhook_trigger_sent', $response, $url, $http_args, $webhook );

		return $response;
	}

}
