<?php

/**
 * Class WordPress_Webhooks_Settings
 *
 * This class contains all of our important settings
 * Here you can configure the whole plugin behavior.
 *
 * @since 1.0.0
 * @package WW
 * @author Pullbytes <info@pullbytes.com>
 */
class WordPress_Webhooks_Settings{

	/**
	 * Our globally used capability
	 *
	 * @var string
	 * @since 1.0.0
	 */
	private $admin_cap;

	/**
	 * The main page name
	 *
	 * @var string
	 * @since 1.0.0
	 */
	private $page_name;

	/**
	 * Our global array for translateable strings
	 *
	 * @var array
	 * @since 1.0.0
	 */
	private $trans_strings;

	/**
	 * The current license key
	 *
	 * This array is just mentioned for the definition.
	 * It will be overwritten inside of the setup_license function
	 *
	 * @var array
	 * @since 1.0.0
	 */
	private $license = array(
		'key'       => '',
		'expires'   => '',
		'status'    => ''
	);

	/**
	 * The license option key
	 *
	 * @var string
	 * @since 1.0.0
	 */
	private $license_option_key;

	/**
	 * The license nonce data
	 *
	 * @var array
	 * @since 1.0.0
	 */
	private $license_nonce;

	/**
	 * The whitelist nonce data
	 *
	 * @var array
	 * @since 1.0.0
	 */
	private $whitelist_nonce;

	/**
	 * The action nonce data
	 *
	 * @var array
	 * @since 1.0.0
	 */
	private $action_nonce;

	/**
	 * WordPress_Webhooks_Settings constructor.
	 *
	 * We define all of our necessary settings in here.
	 * If you need to do plugin related changes, everything will
	 * be available in this file.
	 */
	function __construct(){
		$this->admin_cap            = 'manage_options';
		$this->page_name            = 'wordpress_webhooks';
		$this->page_title           = WW_NAME;
		$this->license_option_key   = 'ww_webhook_pro_license';
		$this->webhook_settings_key = 'ww_webhook_webhooks';
		$this->whitelist_settings_key = 'ww_webhook_whitelist';
		$this->whitelist_requested_key = 'ww_webhook_whitelist_requests';
		$this->whitelabel_settings_key = 'ww_webhook_whitelabel';
		$this->news_transient_key   = 'ww_cached_news';
		$this->extensions_transient_key   = 'ww_cached_extensions';
		$this->webhook_ident_param  = 'ww_action';
		$this->active_webhook_ident_param  = 'ww_active_webhooks';
		$this->default_settings     = $this->load_default_settings();
		$this->whitelabel_settings     = $this->load_whitelabel_settings();
		$this->required_trigger_settings     = $this->load_required_trigger_settings();
		$this->default_trigger_settings     = $this->load_default_trigger_settings();
		$this->required_action_settings     = $this->load_required_action_settings();
		$this->data_mapping_template_settings     = $this->load_data_mapping_template_settings();
		$this->data_mapping_key_settings     = $this->load_data_mapping_key_settings();
		$this->authentication_methods     = $this->load_authentication_methods();
		$this->log_table_data   = $this->setup_log_table_data();
		$this->data_mapping_table_data   = $this->setup_data_mapping_table_data();
		$this->authentication_table_data   = $this->setup_authentication_table_data();
		$this->license_nonce        = array(
			'action' => 'ironikus_ww_license',
			'arg'    => 'ironikus_ww_license_nonce'
		);
		$this->whitelist_nonce        = array(
			'action' => 'ironikus_ww_whitelist',
			'arg'    => 'ironikus_ww_whitelist_nonce'
		);
		$this->action_nonce        = array(
			'action' => 'ironikus_ww_actions',
			'arg'    => 'ironikus_ww_actions_nonce'
		);
		$this->log_nonce        = array(
			'action' => 'ironikus_ww_logs',
			'arg'    => 'ironikus_ww_logs_nonce'
		);
		$this->license              = $this->setup_license();
		$this->trans_strings        = $this->load_default_strings();
		$this->active_webhooks      = $this->setup_active_webhooks();
	}

	/**
	 * Load the license into the current object cache
	 *
	 * @return array - the license data
	 */
	private function setup_license(){
		$license_data = get_option( $this->license_option_key );
		if(empty($license_data)){
			$license_data = array(
				'key'       => '',
				'expires'   => '',
				'status'    => ''
			);
		}

		return $license_data;
	}

	/**
	 * Setup the data mapping table data 
	 *
	 * @return array - the data mappingn table data
	 */
	public function setup_data_mapping_table_data(){

		$data = array();
		$table_name = 'ww_data_mapping';
		$data['table_name'] = $table_name;

		$data['sql_create_table'] = "
		  CREATE TABLE {prefix}$table_name (
		  id BIGINT(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  name VARCHAR(100),
		  template LONGTEXT,
		  log_time DATETIME
		) {charset_collate};";
		$data['sql_drop_table'] = "DROP TABLE {prefix}$table_name;";

		return $data;

	}

	/**
	 * Setup the authentication table data 
	 *
	 * @return array - the authentication table data
	 */
	public function setup_authentication_table_data(){

		$data = array();
		$table_name = 'ww_authentication';
		$data['table_name'] = $table_name;

		$data['sql_create_table'] = "
		  CREATE TABLE {prefix}$table_name (
		  id BIGINT(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  name VARCHAR(100),
		  auth_type VARCHAR(100),
		  template LONGTEXT,
		  log_time DATETIME
		) {charset_collate};";
		$data['sql_drop_table'] = "DROP TABLE {prefix}$table_name;";

		return $data;

	}

	/**
	 * Setup the log table data 
	 *
	 * @return array - the log table data
	 */
	public function setup_log_table_data(){

		$data = array();
		$table_name = 'ww_logs';
		$data['table_name'] = $table_name;

		$data['sql_create_table'] = "
		  CREATE TABLE {prefix}$table_name (
		  id BIGINT(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  message LONGTEXT,
		  content LONGTEXT,
		  log_time DATETIME
		) {charset_collate};";
		$data['sql_drop_table'] = "DROP TABLE {prefix}$table_name;";

		return $data;

	}

	/**
	 * Load the default settings for the main settings page
	 * of our plugin.
	 *
	 * @return array - an array of all available settings
	 */
	private function load_default_settings(){
		$fields = array(

			/**
			 * Activate authentication
			 */
			'ww_activate_authentication' => array(
				'id'          => 'ww_activate_authentication',
				'type'        => 'checkbox',
				'label'       => wordpress_webhooks()->helpers->translate('Activate Authentication', 'ww-fields-activate-authentication'),
				'placeholder' => '',
				'required'    => false,
				'description' => wordpress_webhooks()->helpers->translate('This allows you to authenticate certain webhook triggers in case you want to send data to API that requires authentication. It will add a new tab within the menu', 'ww-fields-activate-authentication-tip')
			),
			/**
			 * ACTIVATE TRANSLATIONS
			 */
			'ww_activate_translations' => array(
				'id'          => 'ww_activate_translations',
				'type'        => 'checkbox',
				'label'       => wordpress_webhooks()->helpers->translate('Activate Translations', 'ww-fields-activate-translations'),
				'placeholder' => '',
				'required'    => false,
				'description' => wordpress_webhooks()->helpers->translate('Check this button if you want to enable our translation engine on your website.', 'ww-fields-translations-tip')
			),

			/**
			 * Deactivate Post Delay
			 */
			'ww_deactivate_post_delay' => array(
				'id'          => 'ww_deactivate_post_delay',
				'type'        => 'checkbox',
				'label'       => wordpress_webhooks()->helpers->translate('Deactivate Post Trigger Delay', 'ww-fields-reset'),
				'placeholder' => '',
				'required'    => false,
				'description' => wordpress_webhooks()->helpers->translate('Since version 2.1.4, we delay every trigger until the WordPress "shutdown" hook fires. This allows us to also keep track of all plugin modifications that happen after the initial trigger fires. If you don\'t want that, simply check this box.', 'ww-fields-reset-tip')
			),

			/**
			 * Deactivate Post Delay
			 */
			'ww_activate_debug_mode' => array(
				'id'          => 'ww_activate_debug_mode',
				'type'        => 'checkbox',
				'label'       => wordpress_webhooks()->helpers->translate('Activate Debug Mode', 'ww-fields-reset'),
				'placeholder' => '',
				'required'    => false,
				'description' => wordpress_webhooks()->helpers->translate('This feature adds additional debug information to the plugin. It logs, e.g. further details within the WordPress debug.log file about issues that occur from a configurational perspective.', 'ww-fields-reset-tip')
			),

			/**
			 * Reset WordPress Webhooks
			 */
			'ww_reset_data' => array(
				'id'          => 'ww_reset_data',
				'type'        => 'checkbox',
				'label'       => sprintf( wordpress_webhooks()->helpers->translate('Reset %s', 'ww-fields-reset'), WW_NAME ),
				'placeholder' => '',
				'required'    => false,
				'description' => sprintf( wordpress_webhooks()->helpers->translate('Reset %s and set it back to its default settings (Excludes license & Extensions). BE CAREFUL: Once you activate the button and click save, all of your saved data for the plugin is gone.', 'ww-fields-reset-tip'), WW_NAME )
			),
		);

		$new_fields		=	apply_filters('ww_settings_fields', $fields);

		foreach( $new_fields as $key => $field ){
			$value = get_option( $key );

			$new_fields[ $key ]['value'] = $value;

			if( $new_fields[ $key ]['type'] == 'checkbox' ){
				if( empty( $new_fields[ $key ]['value'] ) || $new_fields[ $key ]['value'] == 'no' ){
					$new_fields[ $key ]['value'] = 'no';
				} else {
					$new_fields[ $key ]['value'] = 'yes';
				}
			}
		}

		return $new_fields;
	}

	/**
	 * Load the whitelabel settings
	 * of our plugin.
	 *
	 * @since - 3.0.6
	 * @return array - an array of all available whitelabel settings
	 */
	private function load_whitelabel_settings(){
		$fields = array(

			/**
			 * Activate whitelabeling
			 */
			'ww_whitelabel_activate' => array(
				'id'          => 'ww_whitelabel_activate',
				'type'        => 'checkbox',
				'label'       => wordpress_webhooks()->helpers->translate('Activate Whitelabel', 'ww-fields-reset'),
				'placeholder' => '',
				'required'    => false,
				'description' => wordpress_webhooks()->helpers->translate('Check this box if you want to activate the whitelabel feature.', 'ww-fields-reset-tip')
			),

			/**
			 * Whitelabel Name
			 */
			'ww_whitelabel_name' => array(
				'id'          => 'ww_whitelabel_name',
				'type'        => 'text',
				'label'       => wordpress_webhooks()->helpers->translate('Whitelabel Name', 'ww-fields-activate-authentication'),
				'placeholder' => WW_NAME,
				'required'    => false,
				'description' => wordpress_webhooks()->helpers->translate('This is the name of the whitelabeled version of this plugin. Pro tip: Add a " Pro" at the end of the name to get the highlighted Pro text within the menu item.', 'ww-fields-activate-authentication-tip'),
			),

			/**
			 * Hide Licensing tab
			 */
			'ww_whitelabel_hide_licensing' => array(
				'id'          => 'ww_whitelabel_hide_licensing',
				'type'        => 'checkbox',
				'label'       => wordpress_webhooks()->helpers->translate('Hide licensing tab', 'ww-fields-reset'),
				'placeholder' => '',
				'required'    => false,
				'description' => wordpress_webhooks()->helpers->translate('Check this box if you want to hide the licensing tab from the menu. This way, your customers won\'t be able to see the license anymore.', 'ww-fields-reset-tip')
			),

			/**
			 * Hide Settings tab
			 */
			'ww_whitelabel_hide_settings' => array(
				'id'          => 'ww_whitelabel_hide_settings',
				'type'        => 'checkbox',
				'label'       => wordpress_webhooks()->helpers->translate('Hide Settings tab', 'ww-fields-reset'),
				'placeholder' => '',
				'required'    => false,
				'description' => wordpress_webhooks()->helpers->translate('Check this box if you want to hide the Settings tab from the menu. This way, your customers won\'t be able to see the Settings anymore.', 'ww-fields-reset-tip')
			),

			/**
			 * Hide Extensions tab
			 */
			'ww_whitelabel_hide_extensions' => array(
				'id'          => 'ww_whitelabel_hide_extensions',
				'type'        => 'checkbox',
				'label'       => wordpress_webhooks()->helpers->translate('Hide Extensions tab', 'ww-fields-reset'),
				'placeholder' => '',
				'required'    => false,
				'description' => wordpress_webhooks()->helpers->translate('Check this box if you want to hide the Extensions tab from the menu. This way, your customers won\'t be able to see the Extensions anymore.', 'ww-fields-reset-tip')
			),

			/**
			 * Custom home tab content
			 */
			'ww_whitelabel_custom_home' => array(
				'id'          => 'ww_whitelabel_custom_home',
				'type'        => 'textarea',
				'label'       => wordpress_webhooks()->helpers->translate('Customize Home tab', 'ww-fields-reset'),
				'placeholder' => '',
				'required'    => false,
				'description' => wordpress_webhooks()->helpers->translate('Add your custom code into this field to customize the home tab of our plugin. You can also use our predefined template tags such as %home_url%, %admin_url%, %product_version%, %product_name% or %user_name% - all of them will be automatically replaced on the home tab.', 'ww-fields-reset-tip')
			),

			/**
			 * Custom send data text
			 */
			'ww_whitelabel_custom_text_send_data' => array(
				'id'          => 'ww_whitelabel_custom_text_send_data',
				'type'        => 'textarea',
				'label'       => wordpress_webhooks()->helpers->translate('Customize Send Data Sub Text', 'ww-fields-reset'),
				'placeholder' => '',
				'required'    => false,
				'description' => wordpress_webhooks()->helpers->translate('Replace the default text of the Send Data tab with your very own text.', 'ww-fields-reset-tip')
			),

			/**
			 * Custom receive data text
			 */
			'ww_whitelabel_custom_text_receive_data' => array(
				'id'          => 'ww_whitelabel_custom_text_receive_data',
				'type'        => 'textarea',
				'label'       => wordpress_webhooks()->helpers->translate('Customize Receive Data Sub Text', 'ww-fields-reset'),
				'placeholder' => '',
				'required'    => false,
				'description' => wordpress_webhooks()->helpers->translate('Replace the default text of the Receive Data tab with your very own text.', 'ww-fields-reset-tip')
			),

			/**
			 * Custom whitelist data text
			 */
			'ww_whitelabel_custom_text_whitelist' => array(
				'id'          => 'ww_whitelabel_custom_text_whitelist',
				'type'        => 'textarea',
				'label'       => wordpress_webhooks()->helpers->translate('Customize Whitelist Sub Text', 'ww-fields-reset'),
				'placeholder' => '',
				'required'    => false,
				'description' => wordpress_webhooks()->helpers->translate('Replace the default text of the Whitelist tab with your very own text.', 'ww-fields-reset-tip')
			),

			/**
			 * Custom logs data text
			 */
			'ww_whitelabel_custom_text_logs' => array(
				'id'          => 'ww_whitelabel_custom_text_logs',
				'type'        => 'textarea',
				'label'       => wordpress_webhooks()->helpers->translate('Customize Logs Sub Text', 'ww-fields-reset'),
				'placeholder' => '',
				'required'    => false,
				'description' => wordpress_webhooks()->helpers->translate('Replace the default text of the Logs tab with your very own text.', 'ww-fields-reset-tip')
			),

			/**
			 * Custom data mapping tab text
			 */
			'ww_whitelabel_custom_text_data_mapping' => array(
				'id'          => 'ww_whitelabel_custom_text_data_mapping',
				'type'        => 'textarea',
				'label'       => wordpress_webhooks()->helpers->translate('Customize Data Mapping Sub Text', 'ww-fields-reset'),
				'placeholder' => '',
				'required'    => false,
				'description' => wordpress_webhooks()->helpers->translate('Replace the default text of the Data Mapping tab with your very own text.', 'ww-fields-reset-tip')
			),

			/**
			 * Custom data mapping tab preview text
			 */
			'ww_whitelabel_custom_text_data_mapping_preview' => array(
				'id'          => 'ww_whitelabel_custom_text_data_mapping_preview',
				'type'        => 'textarea',
				'label'       => wordpress_webhooks()->helpers->translate('Customize Data Mapping Preview Sub Text', 'ww-fields-reset'),
				'placeholder' => '',
				'required'    => false,
				'description' => wordpress_webhooks()->helpers->translate('Replace the default preview text of the Data Mapping tab with your very own text.', 'ww-fields-reset-tip')
			),

			/**
			 * Custom authentication tab text
			 */
			'ww_whitelabel_custom_text_authentication' => array(
				'id'          => 'ww_whitelabel_custom_text_authentication',
				'type'        => 'textarea',
				'label'       => wordpress_webhooks()->helpers->translate('Customize Authentication Sub Text', 'ww-fields-reset'),
				'placeholder' => '',
				'required'    => false,
				'description' => wordpress_webhooks()->helpers->translate('Replace the default text of the Authentication tab with your very own text.', 'ww-fields-reset-tip')
			),

			/**
			 * Custom extensions tab text
			 */
			'ww_whitelabel_custom_text_extensions' => array(
				'id'          => 'ww_whitelabel_custom_text_extensions',
				'type'        => 'textarea',
				'label'       => wordpress_webhooks()->helpers->translate('Customize Extensions Sub Text', 'ww-fields-reset'),
				'placeholder' => '',
				'required'    => false,
				'description' => wordpress_webhooks()->helpers->translate('Replace the default text of the Extensions tab with your very own text.', 'ww-fields-reset-tip')
			),

			/**
			 * Custom settings tab text
			 */
			'ww_whitelabel_custom_text_settings' => array(
				'id'          => 'ww_whitelabel_custom_text_settings',
				'type'        => 'textarea',
				'label'       => wordpress_webhooks()->helpers->translate('Customize Settings Sub Text', 'ww-fields-reset'),
				'placeholder' => '',
				'required'    => false,
				'description' => wordpress_webhooks()->helpers->translate('Replace the default text of the Settings tab with your very own text.', 'ww-fields-reset-tip')
			),

			/**
			 * Custom license tab text
			 */
			'ww_whitelabel_custom_text_license' => array(
				'id'          => 'ww_whitelabel_custom_text_license',
				'type'        => 'textarea',
				'label'       => wordpress_webhooks()->helpers->translate('Customize License Sub Text', 'ww-fields-reset'),
				'placeholder' => '',
				'required'    => false,
				'description' => wordpress_webhooks()->helpers->translate('Replace the default text of the License tab with your very own text.', 'ww-fields-reset-tip')
			),

		);

		$whitelabel_settings_data = get_option( $this->whitelabel_settings_key );

		foreach( $fields as $key => $field ){
			$value = isset( $whitelabel_settings_data[ $key ] ) ? $whitelabel_settings_data[ $key ] : '';

			$fields[ $key ]['value'] = $value;

			if( $fields[ $key ]['type'] == 'checkbox' ){
				if( empty( $fields[ $key ]['value'] ) || $fields[ $key ]['value'] == 'no' ){
					$fields[ $key ]['value'] = 'no';
				} else {
					$fields[ $key ]['value'] = 'yes';
				}
			}
		}

		return apply_filters( 'ww/settings/whitelabel_fields', $fields );
	}

	/**
	 * Load the strictly necessary trigger settings
	 * to any available trigger.
	 *
	 * @return array - the trigger settings
	 */
	private function load_required_trigger_settings(){
		$fields = array(

			'ww_trigger_response_type' => array(
				'id'          => 'ww_trigger_response_type',
				'type'        => 'select',
				'label'       => wordpress_webhooks()->helpers->translate('Change the data request type', 'ww-fields-trigger-required-settings'),
				'choices'     => array(
					'json' => 'JSON',
					'xml' => 'XML',
					'form' => 'X-WWW-FORM-URLENCODE',
				),
				'placeholder' => '',
				'default_value' => '',
				'description' => wordpress_webhooks()->helpers->translate('Set a custom request type for the data that gets send to the specified URL. Default is JSON.', 'ww-fields-trigger-required-settings')
			),
			'ww_trigger_request_method' => array(
				'id'          => 'ww_trigger_request_method',
				'type'        => 'select',
				'label'       => wordpress_webhooks()->helpers->translate('Change the data request method', 'ww-fields-trigger-required-settings'),
				'choices'     => array(
					'POST' => 'POST',
					'GET' => 'GET',
					'HEAD' => 'HEAD',
					'PUT' => 'PUT',
					'DELETE' => 'DELETE',
					'TRACE' => 'TRACE',
					'OPTIONS' => 'OPTIONS',
					'PATCH' => 'PATCH',
				),
				'placeholder' => '',
				'default_value' => '',
				'description' => wordpress_webhooks()->helpers->translate('Set a custom request method for the data that gets send to the specified URL. Default is POST.', 'ww-fields-trigger-required-settings')
			),
			'ww_trigger_data_mapping' => array(
				'id'          => 'ww_trigger_data_mapping',
				'type'        => 'select',
				'label'       => wordpress_webhooks()->helpers->translate('Add data mapping template', 'ww-fields-trigger-required-settings'),
				'choices'     => array(
					//Settings are loaded dynamically within the send-data.php page
					'0' => wordpress_webhooks()->helpers->translate('Choose...', 'ww-fields-trigger-required-settings')
				),
				'placeholder' => '',
				'default_value' => '',
				'description' => wordpress_webhooks()->helpers->translate('Set a custom data mapping template to map your outgoing data to your very own structure.', 'ww-fields-trigger-required-settings')
			),
			'ww_trigger_authentication' => array(
				'id'          => 'ww_trigger_authentication',
				'type'        => 'select',
				'label'       => wordpress_webhooks()->helpers->translate('Add authentication template', 'ww-fields-trigger-required-settings'),
				'choices'     => array(
					//Settings are loaded dynamically within the send-data.php page
					'0' => wordpress_webhooks()->helpers->translate('Choose...', 'ww-fields-trigger-required-settings')
				),
				'placeholder' => '',
				'default_value' => '',
				'description' => wordpress_webhooks()->helpers->translate('Set a custom authentication template in case the other endpoint requires authentication.', 'ww-fields-trigger-required-settings')
			),
			'ww_trigger_allow_unsafe_urls' => array(
				'id'          => 'ww_trigger_allow_unsafe_urls',
				'type'        => 'checkbox',
				'label'       => wordpress_webhooks()->helpers->translate('Allow unsafe URLs', 'ww-fields-trigger-required-settings'),
				'placeholder' => '',
				'default_value' => '',
				'description' => wordpress_webhooks()->helpers->translate('Activating this setting allows you to use unsafe looking URLs like zfvshjhfbssdf.szfdhdf.com.', 'ww-fields-trigger-settings')
			),
			'ww_trigger_allow_unverified_ssl' => array(
				'id'          => 'ww_trigger_allow_unverified_ssl',
				'type'        => 'checkbox',
				'label'       => wordpress_webhooks()->helpers->translate('Allow unverified SSL', 'ww-fields-trigger-required-settings'),
				'placeholder' => '',
				'default_value' => '',
				'description' => wordpress_webhooks()->helpers->translate('Activating this setting allows you to use unverified SSL connections for this URL (We won\'t verify the SSL for this webhook URL).', 'ww-fields-trigger-settings')
			),

		);

		return apply_filters('ww/settings/required_trigger_settings', $fields);
	}

	/**
	 * Load the default trigger settings. 
	 * 
	 * These settings can be loaded optionally with every single webhook trigger.
	 *
	 * @return array - the default trigger settings
	 */
	private function load_default_trigger_settings(){
		$fields = array(

			'ww_user_must_be_logged_in' => array(
				'id'          => 'ww_user_must_be_logged_in',
				'type'        => 'checkbox',
				'label'       => wordpress_webhooks()->helpers->translate('User must be logged in', 'ww-fields-trigger-settings'),
				'placeholder' => '',
				'default_value' => '',
				'description' => wordpress_webhooks()->helpers->translate('Check this button if you want to fire this webhook only when the user is logged in ( is_user_logged_in() function is used ).', 'ww-fields-trigger-settings')
			),
			'ww_user_must_be_logged_out' => array(
				'id'          => 'ww_user_must_be_logged_out',
				'type'        => 'checkbox',
				'label'       => wordpress_webhooks()->helpers->translate('User must be logged out', 'ww-fields-trigger-settings'),
				'placeholder' => '',
				'default_value' => '',
				'description' => wordpress_webhooks()->helpers->translate('Check this button if you want to fire this webhook only when the user is logged out ( ! is_user_logged_in() function is used ).', 'ww-fields-trigger-settings')
			),
			'ww_trigger_backend_only' => array(
				'id'          => 'ww_trigger_backend_only',
				'type'        => 'checkbox',
				'label'       => wordpress_webhooks()->helpers->translate('Trigger from backend only', 'ww-fields-trigger-settings'),
				'placeholder' => '',
				'default_value' => '',
				'description' => wordpress_webhooks()->helpers->translate('Check this button if you want to fire this trigger only from the backend. Every post submitted through the frontend is ignored ( is_admin() function is used ).', 'ww-fields-trigger-settings')
			),
			'ww_trigger_frontend_only' => array(
				'id'          => 'ww_trigger_frontend_only',
				'type'        => 'checkbox',
				'label'       => wordpress_webhooks()->helpers->translate('Trigger from frontend only', 'ww-fields-trigger-settings'),
				'placeholder' => '',
				'default_value' => '',
				'description' => wordpress_webhooks()->helpers->translate('Check this button if you want to fire this trigger only from the frontent. Every post submitted through the backend is ignored ( ! is_admin() function is used ).', 'ww-fields-trigger-settings')
			)

		);

		return apply_filters('ww/settings/default_trigger_settings', $fields);
	}

	/**
	 * Load the strictly necessary action settings
	 * to any available action.
	 *
	 * @return array - the action settings
	 */
	private function load_required_action_settings(){
		$fields = array(

			'ww_action_data_mapping' => array(
				'id'          => 'ww_action_data_mapping',
				'type'        => 'select',
				'label'       => wordpress_webhooks()->helpers->translate('Add data mapping template', 'ww-fields-action-required-settings'),
				'choices'     => array(
					//Settings are loaded dynamically within the receive-data.php page
					'0' => wordpress_webhooks()->helpers->translate('Choose...', 'ww-fields-action-required-settings')
				),
				'placeholder' => '',
				'default_value' => '',
				'description' => sprintf( wordpress_webhooks()->helpers->translate('Set a custom data mapping template to map your incoming data to the structure of %s.', 'ww-fields-action-required-settings'), WW_NAME )
			),

			'ww_action_access_token' => array(
				'id'          => 'ww_action_access_token',
				'type'        => 'text',
				'label'       => wordpress_webhooks()->helpers->translate('Add access token', 'ww-fields-action-required-settings'),
				'placeholder' => '',
				'default_value' => '',
				'description' => wordpress_webhooks()->helpers->translate('Set an access token for enhanced security. If set, you need to add another argument within your request called "access_token".', 'ww-fields-action-required-settings')
			),

			'ww_action_action_whitelist' => array(
				'id'          => 'ww_action_action_whitelist',
				'type'        => 'select',
				'multiple'    => true,
				//Settings are loaded dynamically within the receive-data.php page
				'choices'      => array(),
				'label'       => wordpress_webhooks()->helpers->translate('Whitelist only specific actions', 'ww-fields-trigger-on-post-type'),
				'placeholder' => '',
				'required'    => false,
				'description' => wordpress_webhooks()->helpers->translate('Select only the actions you would like to allow for this webhook action URL. <strong>IMPORTANT: If none is selected, all are permitted.</strong>', 'ww-fields-trigger-on-post-type-tip')
			),

		);

		return apply_filters('ww/settings/required_action_settings', $fields);
	}

	/**
	 * Load the settings for our data mapping template
	 *
	 * @return array - the data mapping template settings
	 */
	private function load_data_mapping_template_settings(){
		$fields = array(

			'ww_data_mapping_whitelist_payload' => array(
				'id'          => 'ww_data_mapping_whitelist_payload',
				'type'        => 'select',
				'label'       => wordpress_webhooks()->helpers->translate('Whitelist/Blacklist Payload', 'ww-fields-action-required-settings'),
				'choices'     => array(
					'none' => wordpress_webhooks()->helpers->translate('Choose..', 'ww-fields-data-mapping-required-settings'),
					'whitelist' => wordpress_webhooks()->helpers->translate('Whitelist', 'ww-fields-data-mapping-required-settings'),
					'blacklist' => wordpress_webhooks()->helpers->translate('Blacklist', 'ww-fields-data-mapping-required-settings'),
				),
				'placeholder' => '',
				'default_value' => '',
				'description' => wordpress_webhooks()->helpers->translate('Check this settings item to only send over the keys defined within this template (Whitelist) or every key except of the ones in this template. This way, you can prevents unnecessary data to be sent over via the endpoint. To only map a key without modifications, simply define the same key as the new key and assign the same key again. E.g.: user_email -> user_email', 'ww-fields-data-mapping-settings')
			),

		);

		return apply_filters('ww/settings/data_mapping_template_settings', $fields);
	}

	/**
	 * Load the settings for our data mapping template keys
	 *
	 * @return array - the action settings
	 */
	private function load_data_mapping_key_settings(){
		$fields = array(

			'ww_data_mapping_value_type' => array(
				'id'          => 'ww_data_mapping_value_type',
				'type'        => 'select',
				'label'       => wordpress_webhooks()->helpers->translate('Value Type', 'ww-fields-data-mapping-required-settings'),
				'choices'     => array(
					'key_mapping' => wordpress_webhooks()->helpers->translate('Mapping Key', 'ww-fields-data-mapping-required-settings'),
					'data_value' => wordpress_webhooks()->helpers->translate('Data Value', 'ww-fields-data-mapping-required-settings'),
				),
				'placeholder' => '',
				'default_value' => '',
				'description' => wordpress_webhooks()->helpers->translate('Choose "Mapping Key" if you want to use the above value to map it to the incoming data. Use "Data Value" in case you want to create a new, static value.', 'ww-fields-data-mapping-settings')
			),

			'ww_data_mapping_convert_data' => array(
				'id'          => 'ww_data_mapping_convert_data',
				'type'        => 'select',
				'label'       => wordpress_webhooks()->helpers->translate('Convert Data To', 'ww-fields-action-required-settings'),
				'choices'     => array(
					'none' => wordpress_webhooks()->helpers->translate('Choose...', 'ww-fields-data-mapping-required-settings'),
					'string' => wordpress_webhooks()->helpers->translate('String', 'ww-fields-data-mapping-required-settings'),
					'integer' => wordpress_webhooks()->helpers->translate('Integer', 'ww-fields-data-mapping-required-settings'),
					'float' => wordpress_webhooks()->helpers->translate('Float', 'ww-fields-data-mapping-required-settings'),
					'null' => wordpress_webhooks()->helpers->translate('Null', 'ww-fields-data-mapping-required-settings'),
					'bool' => wordpress_webhooks()->helpers->translate('Bool', 'ww-fields-data-mapping-required-settings'),
				),
				'placeholder' => '',
				'default_value' => '',
				'description' => wordpress_webhooks()->helpers->translate('In case you need to convert the current value to a specific format, you can do that with this setting sitem.', 'ww-fields-data-mapping-required-settings')
			),

			'ww_data_mapping_decode_data' => array(
				'id'          => 'ww_data_mapping_decode_data',
				'type'        => 'select',
				'label'       => wordpress_webhooks()->helpers->translate('Format value', 'ww-fields-action-required-settings'),
				'choices'     => array(
					'none' => wordpress_webhooks()->helpers->translate('Choose...', 'ww-fields-data-mapping-required-settings'),
					'json_encode' 	=> wordpress_webhooks()->helpers->translate('JSON Encode', 'ww-fields-data-mapping-required-settings'),
					'json_decode' 	=> wordpress_webhooks()->helpers->translate('JSON Decode', 'ww-fields-data-mapping-required-settings'),
					'serialize' 	=> wordpress_webhooks()->helpers->translate('Serialize', 'ww-fields-data-mapping-required-settings'),
					'unserialize' 	=> wordpress_webhooks()->helpers->translate('Unserialize', 'ww-fields-data-mapping-required-settings'),
				),
				'placeholder' 	=> '',
				'default_value' => '',
				'description' 	=> wordpress_webhooks()->helpers->translate('Reformat the given mapping key or value. For incoming data, use JSON Encode and Serialize to format all the data within the given key value as a encoded/serialized string - this causes the value to be treated as a string. Use the JSON decode and unserialize values to make data available that is currently saved as a serialized/encoded string - this is useful if the API sends over a JSON string as a value and you want to access only a single value within this JSON string - once decoded, you can access the whole data within this mapping line.', 'ww-fields-data-mapping-settings')
			),

			'ww_data_mapping_fallback_value' => array(
				'id'          => 'ww_data_mapping_fallback_value',
				'type'        => 'text',
				'label'       => wordpress_webhooks()->helpers->translate('Fallback Value', 'ww-fields-action-required-settings'),
				'placeholder' => '',
				'default_value' => '',
				'description' => wordpress_webhooks()->helpers->translate('In case you use the value type "Mapping Key", this value will be used as a fallback mapping key in case the initial value is not available within the payload. If you use the value type "Data Value", this value will be used if your given value is empty.', 'ww-fields-data-mapping-settings')
			),

		);

		return apply_filters('ww/settings/data_mapping_key_settings', $fields);
	}

	/**
	 * Load all available authentication methods
	 *
	 * @return array - the action settings
	 */
	private function load_authentication_methods(){
		$methods = array(
			//APi Key Authentication
			'api_key' => array(
				'name' => wordpress_webhooks()->helpers->translate('API Key', 'ww-fields-authentication-settings'),
				'description' => wordpress_webhooks()->helpers->translate('Add an API key to your request header/body', 'ww-fields-authentication-settings'),
				'fields' => array(
	
					'ww_auth_api_key_key' => array(
						'id'          => 'ww_auth_api_key_key',
						'type'        => 'text',
						'label'       => wordpress_webhooks()->helpers->translate('Key', 'ww-fields-authentication-settings'),
						'placeholder' => '',
						'default_value' => '',
						'description' => wordpress_webhooks()->helpers->translate('Set the key you have to use to recognize the API key from the other endpoint.', 'ww-fields-authentication-settings')
					),
		
					'ww_auth_api_key_value' => array(
						'id'          => 'ww_auth_api_key_value',
						'type'        => 'text',
						'label'       => wordpress_webhooks()->helpers->translate('Value', 'ww-fields-authentication-settings'),
						'placeholder' => '',
						'default_value' => '',
						'description' => wordpress_webhooks()->helpers->translate('This is the field you can include your API key. ', 'ww-fields-authentication-settings')
					),
	
					'ww_auth_api_key_add_to' => array(
						'id'          => 'ww_auth_api_key_add_to',
						'type'        => 'select',
						'label'       => wordpress_webhooks()->helpers->translate('Add to', 'ww-fields-authentication-settings'),
						'choices'     => array(
							'header' => wordpress_webhooks()->helpers->translate('Header', 'ww-fields-authentication-settings'),
							'body' => wordpress_webhooks()->helpers->translate('Body', 'ww-fields-authentication-settings'),
							'both' => wordpress_webhooks()->helpers->translate('Header & Body', 'ww-fields-authentication-settings'),
						),
						'placeholder' => '',
						'default_value' => '',
						'description' => wordpress_webhooks()->helpers->translate('Choose where you want to place the API Key within the request.', 'ww-fields-authentication-settings')
					),
		
				),
			),

			//Bearer Token Authentication
			'bearer_token' => array(
				'name' => wordpress_webhooks()->helpers->translate('Bearer Token', 'ww-fields-authentication-settings'),
				'description' => wordpress_webhooks()->helpers->translate('Authenticate yourself on an external API using a Bearer token.', 'ww-fields-authentication-settings'),
				'fields' => array(
					'ww_auth_bearer_token_token' => array(
						'id'          => 'ww_auth_bearer_token_token',
						'type'        => 'text',
						'label'       => wordpress_webhooks()->helpers->translate('Token', 'ww-fields-authentication-settings'),
						'placeholder' => '',
						'default_value' => '',
						'description' => wordpress_webhooks()->helpers->translate('Add the bearer token you received from the other endpoint here. Please add only the token, without the "Bearer " in front.', 'ww-fields-authentication-settings')
					),
				),
			),

			//Basic Authentication
			'basic_auth' => array(
				'name' => wordpress_webhooks()->helpers->translate('Basic Auth', 'ww-fields-authentication-settings'),
				'description' => wordpress_webhooks()->helpers->translate('Authenticate yourself on an external API using Basic Authentication.', 'ww-fields-authentication-settings'),
				'fields' => array(
					'ww_auth_basic_auth_username' => array(
						'id'          => 'ww_auth_basic_auth_username',
						'type'        => 'text',
						'label'       => wordpress_webhooks()->helpers->translate('Username', 'ww-fields-authentication-settings'),
						'placeholder' => '',
						'default_value' => '',
						'description' => wordpress_webhooks()->helpers->translate('Add the username you want to use for the authentication.', 'ww-fields-authentication-settings')
					),
					'ww_auth_basic_auth_password' => array(
						'id'          => 'ww_auth_basic_auth_password',
						'type'        => 'text',
						'label'       => wordpress_webhooks()->helpers->translate('Password', 'ww-fields-authentication-settings'),
						'placeholder' => '',
						'default_value' => '',
						'description' => wordpress_webhooks()->helpers->translate('Add the password you want to use for the authentication.', 'ww-fields-authentication-settings')
					),
				),
			),

			//Digest Authentication
			'digest_auth' => array(
				'name' => wordpress_webhooks()->helpers->translate('Digest Auth', 'ww-fields-authentication-settings'),
				'description' => wordpress_webhooks()->helpers->translate('Authenticate yourself on an external API using Digest Authentication.', 'ww-fields-authentication-settings'),
				'fields' => array(
					'ww_auth_digest_auth_username' => array(
						'id'          => 'ww_auth_digest_auth_username',
						'type'        => 'text',
						'label'       => wordpress_webhooks()->helpers->translate('Username', 'ww-fields-authentication-settings'),
						'placeholder' => '',
						'default_value' => '',
						'description' => wordpress_webhooks()->helpers->translate('Add the username you want to use for the authentication.', 'ww-fields-authentication-settings')
					),
					'ww_auth_digest_auth_password' => array(
						'id'          => 'ww_auth_digest_auth_password',
						'type'        => 'text',
						'label'       => wordpress_webhooks()->helpers->translate('Password', 'ww-fields-authentication-settings'),
						'placeholder' => '',
						'default_value' => '',
						'description' => wordpress_webhooks()->helpers->translate('Add the password you want to use for the authentication.', 'ww-fields-authentication-settings')
					),
					'ww_auth_digest_auth_realm' => array(
						'id'          => 'ww_auth_digest_auth_realm',
						'type'        => 'text',
						'label'       => wordpress_webhooks()->helpers->translate('Realm', 'ww-fields-authentication-settings'),
						'placeholder' => '',
						'default_value' => '',
						'description' => wordpress_webhooks()->helpers->translate('A string specified by the server in the WWW-Authenticate response header. It should contain at least the name of the host performing the authentication.', 'ww-fields-authentication-settings')
					),
					'ww_auth_digest_auth_nonce' => array(
						'id'          => 'ww_auth_digest_auth_nonce',
						'type'        => 'text',
						'label'       => wordpress_webhooks()->helpers->translate('Nonce', 'ww-fields-authentication-settings'),
						'placeholder' => '',
						'default_value' => '',
						'description' => wordpress_webhooks()->helpers->translate('A unique string specified by the server in the WWW-Authenticate response header.', 'ww-fields-authentication-settings')
					),
					'ww_auth_digest_auth_qop' => array(
						'id'          => 'ww_auth_digest_auth_qop',
						'type'        => 'text',
						'label'       => wordpress_webhooks()->helpers->translate('Quality of protection (qop)', 'ww-fields-authentication-settings'),
						'placeholder' => '',
						'default_value' => '',
						'description' => wordpress_webhooks()->helpers->translate('This value is given by the server in the WWW-Authenticate response header.', 'ww-fields-authentication-settings')
					),
					'ww_auth_digest_auth_nonce_count' => array(
						'id'          => 'ww_auth_digest_auth_nonce_count',
						'type'        => 'text',
						'label'       => wordpress_webhooks()->helpers->translate('Nonce Count', 'ww-fields-authentication-settings'),
						'placeholder' => '',
						'default_value' => '',
						'description' => wordpress_webhooks()->helpers->translate('The hexadecimal count of the number of requests (Including the current request) that the client has sent (within this request) with the nonce value. This value must be specified if a quality of service (qop) value is sentand must not be specified of the server did not sent a qop directive within the WWW-Authenticate response header.', 'ww-fields-authentication-settings')
					),
					'ww_auth_digest_auth_client_nonce' => array(
						'id'          => 'ww_auth_digest_auth_client_nonce',
						'type'        => 'text',
						'label'       => wordpress_webhooks()->helpers->translate('Client Nonce', 'ww-fields-authentication-settings'),
						'placeholder' => '',
						'default_value' => '',
						'description' => wordpress_webhooks()->helpers->translate('An opaque quoted string value provided by the client and used by both the client and the server to avoid chosen plaintext attacks, to provide mutual authentication and to provide message integrity protection. This must bbe specified if a quality of service (quo) directive is set, and must not be specified if the server did not send a qop directive in the WWW-Authenticate response header.', 'ww-fields-authentication-settings')
					),
					'ww_auth_digest_auth_opaque' => array(
						'id'          => 'ww_auth_digest_auth_opaque',
						'type'        => 'text',
						'label'       => wordpress_webhooks()->helpers->translate('Opaque', 'ww-fields-authentication-settings'),
						'placeholder' => '',
						'default_value' => '',
						'description' => wordpress_webhooks()->helpers->translate('This is a string of data, specified by the server in the WWW-Authenticate response header and should be used here unchanged with URIs in the same protection space.', 'ww-fields-authentication-settings')
					),
				),
			),

		);

		return apply_filters('ww/settings/authentication_methods', $methods);
	}

	/**
	 * Initialize all available, active webhooks
	 *
	 * @return array - active webhooks
	 */
	public function setup_active_webhooks(){

		$webhooks = get_option( $this->active_webhook_ident_param );

		if( empty( $webhooks ) && ! is_array( $webhooks ) ){
			$webhooks = array(
				'triggers' => array(),
				'actions' => array(),
			);
		}

		return $webhooks;
	}

	/*
	 * ######################
	 * ###
	 * #### TRANSLATEABLE STRINGS
	 * ###
	 * ######################
	 */

	 /**
	  * Default settings that are used multiple times throughout the page
	  *
	  * @return array - the default settings
	  */
	private function load_default_strings(){
		$trans_arr = array(
			'sufficient-permissions'    => 'You do not have sufficient permissions to access this page.',
		);

		return apply_filters( 'ww/admin/default_strings', $trans_arr );
	}

	/**
	 * ######################
	 * ###
	 * #### CALLABLE FUNCTIONS
	 * ###
	 * ######################
	 */

	/**
	 * Our admin cap handler function
	 *
	 * This function handles the admin capability throughout
	 * the whole plugin.
	 *
	 * $target - With the target function you can make a more precised filtering
	 * by changing it for specific actions.
	 *
	 * @param string $target - A identifier where the call comes from
	 * @return mixed
	 */
	public function get_admin_cap($target = 'main'){
		/**
		 * Customize the globally used capability for this plugin
		 *
		 * This filter is called every time the capability is needed.
		 */
		return apply_filters( 'ww/admin/settings/capability', $this->admin_cap, $target );
	}

	/**
	 * Return the page name for our admin page
	 *
	 * @return string - the page name
	 */
	public function get_page_name(){
		/*
		 * Filter the page name based on your needs
		 */
		return apply_filters( 'ww_admin_settings_page_name', $this->page_name );
	}

	/**
	 * Return the page title for our admin page
	 *
	 * @return string - the page title
	 */
	public function get_page_title(){
		/*
		 * Filter the page title based on your needs.
		 */
		return apply_filters( 'ww_admin_settings_page_title', $this->page_title );
	}

	/**
	 * Return the log table data from our custom logging table
	 *
	 * @return string - the log table data
	 */
	public function get_log_table_data(){
		/*
		 * Filter the log table data based on your needs.
		 */
		return apply_filters( 'ww/admin/settings/log_table_data', $this->log_table_data );
	}

	/**
	 * Return the data mapping table data
	 *
	 * @return string - the log table data
	 */
	public function get_data_mapping_table_data(){
		/*
		 * Filter the data mapping table data based on your needs.
		 */
		return apply_filters( 'ww/admin/settings/data_mapping_table_data', $this->data_mapping_table_data );
	}

	/**
	 * Return the authentication table data
	 *
	 * @return string - the log table data
	 */
	public function get_authentication_table_data(){
		/*
		 * Filter the authentication table data based on your needs.
		 */
		return apply_filters( 'ww/admin/settings/authentication_table_data', $this->authentication_table_data );
	}

	/**
	 * Return the page title for our admin page
	 *
	 * @param $value - A single license value field
	 *
	 * @return mixed - the page title
	 */
	public function get_license($value = ''){

		if( ! empty( $value ) ){
			return $this->license[ $value ];
		} else {
			return $this->license;
		}

	}

	/**
	 * Return the license option key
	 *
	 * @return string - the option key
	 */
	public function get_license_option_key(){

		return $this->license_option_key;

	}

	/**
	 * Return the webhook option key
	 *
	 * @return string - the option key
	 */
	public function get_webhook_option_key(){

		return $this->webhook_settings_key;

	}

	/**
	 * Return the whitelist option key
	 *
	 * @return string - the option key
	 */
	public function get_whitelist_option_key(){

		return $this->whitelist_settings_key;

	}

	/**
	 * Return the whitelist requests option key
	 *
	 * @return string - the option key
	 */
	public function get_whitelist_requests_option_key(){

		return $this->whitelist_requested_key;

	}

	/**
	 * Return the news transient key
	 *
	 * @return string - the news transient key
	 */
	public function get_news_transient_key(){

		return $this->news_transient_key;

	}

	/**
	 * Return the extensions transient key
	 *
	 * @return string - the extensions transient key
	 */
	public function get_extensions_transient_key(){

		return $this->extensions_transient_key;

	}

	/**
	 * Return the page title for our admin page
	 *
	 * @return string - the page title
	 */
	public function get_webhook_ident_param(){
		/*
		 * Filter the page title based on your needs.
		 */
		return apply_filters( 'ww/admin/settings/webhook_ident_param', $this->webhook_ident_param );
	}

	/**
	 * Return the license nonce data
	 *
	 * @return array - the license nonce data
	 */
	public function get_license_nonce(){

		return $this->license_nonce;

	}

	/**
	 * Return the whitelist nonce data
	 *
	 * @return array - the whitelist nonce data
	 */
	public function get_whitelist_nonce(){

		return $this->whitelist_nonce;

	}

	/**
	 * Return the action nonce data
	 *
	 * @return array - the action nonce data
	 */
	public function get_action_nonce(){

		return $this->action_nonce;

	}

	/**
	 * Return the log nonce data
	 *
	 * @return array - the log nonce data
	 */
	public function get_log_nonce(){

		return $this->log_nonce;

	}

	/**
	 * Return the settings data
	 *
	 * @return array - the settings data
	 */
	public function get_settings(){

		return $this->default_settings;

	}

	/**
	 * Return the whitelabel settings data
	 *
	 * @return array - the whitelabel settings data
	 */
	public function get_whitelabel_settings( $only_values = false ){

		$field_values = $this->whitelabel_settings;

		if( $only_values ){
			$only_field_values = array();

			foreach( $field_values as $key => $data ){
				if( isset( $data['value'] ) ){
					$only_field_values[ $key ] = $data['value'];
				}
			}

			$field_values = $only_field_values;
		}

		return $field_values;

	}

	/**
	 * Return the required trigger settings data
	 *
	 * @since 1.6.5
	 * @return array - the default trigger settings data
	 */
	public function get_required_trigger_settings(){

		return $this->required_trigger_settings;

	}

	/**
	 * Return the default trigger settings data
	 *
	 * @since 1.6.4
	 * @return array - the default trigger settings data
	 */
	public function get_default_trigger_settings(){

		return $this->default_trigger_settings;

	}

	/**
	 * Return the required action settings data
	 *
	 * @since 2.0.0
	 * @return array - the default action settings data
	 */
	public function get_required_action_settings(){

		return $this->required_action_settings;

	}

	/**
	 * Return the data mapping template settings data
	 *
	 * @since 3.0.6
	 * @return array - the default data mapping template settings data
	 */
	public function get_data_mapping_template_settings(){

		return $this->data_mapping_template_settings;

	}

	/**
	 * Return the data mapping key settings data
	 *
	 * @since 3.0.6
	 * @return array - the default data mapping key settings data
	 */
	public function get_data_mapping_key_settings(){

		return $this->data_mapping_key_settings;

	}

	/**
	 * Return all available authentication methods
	 *
	 * @since 3.0.0
	 * @return array - all available authentication methods
	 */
	public function get_authentication_methods(){

		return $this->authentication_methods;

	}

	/**
	 * Return the active webhook ident
	 *
	 * @return string - the active webhook ident
	 */
	public function get_active_webhooks_ident(){

		return $this->active_webhook_ident_param;

	}

	/**
	 * Return the currently active webhooks
	 * 
	 * @param string $type - wether you want to receive active webhooks or triggers
	 *
	 * @return array - the active webhooks
	 */
	public function get_active_webhooks( $type = 'all' ){
		$return = $this->active_webhooks;

		switch( $type ){
			case 'actions':
				$return = $this->active_webhooks['actions'];
				break;
			case 'triggers':
				$return = $this->active_webhooks['triggers'];
				break;
		}

		return $return;

	}

	/**
	 * Return the default strings that are available
	 * for this plugin.
	 *
	 * @param $cname - the identifier for your specified string
	 * @return string - the default string
	 */
	public function get_default_string( $cname ){
		$return = '';

		if(empty( $cname )){
			return $return;
		}

		if( isset( $this->trans_strings[ $cname ] ) ){
			$return = $this->trans_strings[ $cname ];
		}

		return $return;
	}

	public function get_all_post_statuses(){

		$post_statuses = array();

		//Merge default statuses
		$post_statuses = array_merge( $post_statuses, get_post_statuses() );

		//Merge woocommerce statuses
		if ( class_exists( 'WooCommerce' ) && function_exists( 'wc_get_order_statuses' ) ) {
			$post_statuses = array_merge( $post_statuses, wc_get_order_statuses() );
		}


		return apply_filters( 'ww/admin/settings/get_all_post_statuses', $post_statuses );
	}

	public function save_general_settings( $new_settings ){
		$success = false;

		if( empty( $new_settings ) ) {
			return $success;
		}

		$settings = wordpress_webhooks()->settings->get_settings();
		
		// START General Settings
		foreach( $settings as $settings_name => $setting ){
	
			$value = '';
	
			if( $setting['type'] == 'checkbox' ){
				if( ! isset( $new_settings[ $settings_name ] ) ){
					$value = 'no';
				} else {
					$value = 'yes';
				}
			} elseif( $setting['type'] == 'text' ){
				if( isset( $new_settings[ $settings_name ] ) ){
					$value = sanitize_title( $new_settings[ $settings_name ] );
				}
			}
	
			update_option( $settings_name, $value );
			$settings[ $settings_name ][ 'value' ] = $value;
		}
		// END General Settings
	
		$success = true;

		do_action( 'ww_settings_saved', $new_settings );

		return $success;
	}

	public function save_trigger_settings( $new_settings ){
		$success = false;

		if( empty( $new_settings ) ) {
			return $success;
		}

		$triggers = wordpress_webhooks()->webhook->get_triggers( false );
		$active_webhooks = wordpress_webhooks()->settings->get_active_webhooks();
	
		// START Trigger Settings
		foreach( $triggers as $trigger ){
			if( isset( $new_settings[ 'ww_' . $trigger['trigger'] ] ) ){
				$active_webhooks['triggers'][ $trigger['trigger'] ] = array();
			} else {
				unset( $active_webhooks['triggers'][ $trigger['trigger'] ] );
			}
		}
		// END Trigger Settings
	
		
		update_option( wordpress_webhooks()->settings->get_active_webhooks_ident(),  $active_webhooks );

		$success = true;

		do_action( 'ww_settings_saved', $new_settings );

		return $success;
	}

	public function save_action_settings( $new_settings ){
		$success = false;

		if( empty( $new_settings ) ) {
			return $success;
		}

		$actions = wordpress_webhooks()->webhook->get_actions( false );
		$active_webhooks = wordpress_webhooks()->settings->get_active_webhooks();
	
		// START Action Settings
		foreach( $actions as $action ){
			if( isset( $new_settings[ 'wwa_' . $action['action'] ] ) ){
				$active_webhooks['actions'][ $action['action'] ] = array();
			} else {
				unset( $active_webhooks['actions'][ $action['action'] ] );
			}
		}
		// END Action Settings
		update_option( wordpress_webhooks()->settings->get_active_webhooks_ident(),  $active_webhooks );

		$success = true;

		do_action( 'ww_settings_saved', $new_settings );

		return $success;
	}
	

	public function save_whitelabel_settings( $new_settings ){
		$success = false;

		if( empty( $new_settings ) ) {
			return $success;
		}

		$settings = wordpress_webhooks()->settings->get_whitelabel_settings();
		$whitelabel_settings_data = get_option( $this->whitelabel_settings_key );
	
		// START General Settings
		foreach( $settings as $settings_name => $setting ){
	
			$value = '';
	
			if( $setting['type'] == 'checkbox' ){
				if( ! isset( $new_settings[ $settings_name ] ) ){
					$value = 'no';
				} else {
					$value = 'yes';
				}
			} elseif( $setting['type'] == 'text' ){
				if( isset( $new_settings[ $settings_name ] ) ){
					$value = sanitize_text_field( $new_settings[ $settings_name ] );
				}
			} elseif( $setting['type'] == 'textarea' ){
				if( isset( $new_settings[ $settings_name ] ) ){
					$value = $new_settings[ $settings_name ];
				}
			}
	
			$whitelabel_settings_data[ $settings_name ] = $value;
		}
		
		update_option( $this->whitelabel_settings_key, $whitelabel_settings_data );

		//relad settings
		$this->whitelabel_settings = $this->load_whitelabel_settings();

		$success = true;

		do_action( 'ww_settings_saved', $new_settings );

		return $success;
	 }

}