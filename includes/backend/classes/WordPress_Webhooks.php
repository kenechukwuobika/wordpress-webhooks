<?php
if ( ! class_exists( 'WordPress_Webhooks' ) ) :

	/**
	 * Primary WordPress Webhooks Class.
	 *
	 * @package WW
	 * @author Pullbytes <info@pullbytes.com>
	 */
	final class WordPress_Webhooks {

		/**
		 * The real instance
		 *
		 * @var WordPress_Webhooks
		 * @since 1.0.0
		 */
		private static $instance;

		/**
		 * WW updater Object.
		 *
		 * @var object|WordPress_Webhook_Updater
		 * @since 1.0.0
		 */
		public $updater;

		/**
		 * WW settings Object.
		 *
		 * @var object|WordPress_Webhooks_Settings
		 * @since 1.0.0
		 */
		public $settings;

		/**
		 * WW helpers Object.
		 *
		 * @var object|WordPress_Webhooks_Helpers
		 * @since 1.0.0
		 */
		public $helpers;

		/**
		 * WW helpers Object.
		 *
		 * @var object|WordPress_Webhooks_License
		 * @since 1.0.0
		 */
		public $license;

		/**
		 * WW SQL Object.
		 *
		 * @var object|WordPress_Webhooks_SQL
		 * @since 1.6.3
		 */
		public $sql;

		/**
		 * WW Log Object.
		 *
		 * @var object|WordPress_Webhooks_Logs
		 * @since 1.6.3
		 */
		public $logs;

		/**
		 * WW API Object.
		 *
		 * @var object|WordPress_Webhooks_API
		 * @since 1.0.0
		 */
		public $api;

		/**
		 * WW Webhook Object.
		 *
		 * @var object|WordPress_Webhooks_Instantiate
		 * @since 1.0.0
		 */
		public $webhook;

		/**
		 * WW Whitelist Object.
		 *
		 * @var object|WordPress_Webhooks_Whitelist
		 * @since 1.0.0
		 */
		public $whitelist;

		/**
		 * WW Whitelabel Object.
		 *
		 * @var object|WordPress_Webhooks_Whitelabel
		 * @since 3.0.6
		 */
		public $whitelabel;

		/**
		 * WW Polling Object.
		 *
		 * @var object|WordPress_Webhooks_Polling
		 * @since 2.1.2
		 */
		public $polling;

		/**
		 * WW Data Mapping Object.
		 *
		 * @var object|WordPress_Webhooks_Data_Mapping
		 * @since 2.0.0
		 */
		public $data_mapping;

		/**
		 * WW Post Delay Object.
		 *
		 * @var object|WordPress_Webhooks_Post_Delay
		 * @since 2.1.4
		 */
		public $delay;

		/**
		 * WW Authentication Object.
		 *
		 * @var object|WordPress_Webhooks_Authentication
		 * @since 3.0.0
		 */
		public $auth;

		/**
		 * WW Advanced Custom Fields Object.
		 *
		 * @var object|WordPress_Webhooks_ACF
		 * @since 3.0.8
		 */
		public $acf;

		/**
		 * Throw error on object clone.
		 *
		 * Cloning instances of the class is forbidden.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'ironikus' ), '1.0.0' );
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'ironikus' ), '1.0.0' );
		}

		/**
		 * Main WordPress_Webhooks Instance.
		 *
		 * Insures that only one instance of WordPress_Webhooks exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @since 1.0.0
		 * @static
		 * @staticvar array $instance
		 * @return object|WordPress_Webhooks The one true WordPress_Webhooks
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof WordPress_Webhooks ) ) {
				self::$instance                 = new WordPress_Webhooks;
				self::$instance->base_hooks();
				self::$instance->includes();
				self::$instance->helpers        = new WordPress_Webhooks_Helpers();
				self::$instance->settings       = new WordPress_Webhooks_Settings();
				self::$instance->sql            = new WordPress_Webhooks_SQL();
				self::$instance->logs           = new WordPress_Webhooks_Logs();
				self::$instance->data_mapping   = new WordPress_Webhooks_Data_Mapping();
				self::$instance->delay			= new WordPress_Webhooks_Post_Delay();
				self::$instance->auth			= new WordPress_Webhooks_Authentication();
				self::$instance->api            = new WordPress_Webhooks_API();
				self::$instance->license        = new WordPress_Webhooks_License();
				self::$instance->webhook        = new WordPress_Webhooks_Instantiate();
				self::$instance->whitelist      = new WordPress_Webhooks_Whitelist();
				self::$instance->whitelabel     = new WordPress_Webhooks_Whitelabel();
				self::$instance->polling      	= new WordPress_Webhooks_Polling();
				self::$instance->acf      		= new WordPress_Webhooks_ACF();
				self::$instance->load_updater( WW_PLUGIN_FILE, array(
						'version' => WW_VERSION,
						'item_id' => WW_PLUGIN_ID
					)
				);

				new WordPress_Webhooks_Run();

				/**
				 * Fire a custom action to allow extensions to register
				 * after WP Webhooks Pro was successfully registered
				 */
				do_action( 'ww_plugin_loaded' );
			}

			return self::$instance;
		}

		/**
		 * Include required files.
		 *
		 * @access private
		 * @since 1.0.0
		 * @return void
		 */
		private function includes() {
			require_once WW_PLUGIN_DIR . 'includes/backend/classes/WordPress_Webhooks_Helpers.php';
			require_once WW_PLUGIN_DIR . 'includes/backend/classes/WordPress_Webhooks_Settings.php';
			require_once WW_PLUGIN_DIR . 'includes/backend/classes/WordPress_Webhooks_SQL.php';
			require_once WW_PLUGIN_DIR . 'includes/backend/classes/WordPress_Webhooks_Logs.php';
			require_once WW_PLUGIN_DIR . 'includes/backend/classes/WordPress_Webhooks_Data_Mapping.php';
			require_once WW_PLUGIN_DIR . 'includes/backend/classes/WordPress_Webhooks_Post_Delay.php';
			require_once WW_PLUGIN_DIR . 'includes/backend/classes/WordPress_Webhooks_Authentication.php';
			require_once WW_PLUGIN_DIR . 'includes/backend/classes/WordPress_Webhooks_Whitelist.php';
			require_once WW_PLUGIN_DIR . 'includes/backend/classes/WordPress_Webhooks_Whitelabel.php';
			require_once WW_PLUGIN_DIR . 'includes/backend/classes/WordPress_Webhooks_API.php';
			require_once WW_PLUGIN_DIR . 'includes/backend/WordPress_Webhooks_Instantiate.php';
			require_once WW_PLUGIN_DIR . 'includes/backend/classes/WordPress_Webhook_Updater.php';
			require_once WW_PLUGIN_DIR . 'includes/backend/classes/WordPress_Webhooks_Polling.php';
			require_once WW_PLUGIN_DIR . 'includes/backend/classes/WordPress_Webhooks_License.php';
			require_once WW_PLUGIN_DIR . 'includes/backend/classes/WordPress_Webhooks_ACF.php';

			require_once WW_PLUGIN_DIR . 'includes/backend/classes/WordPress_Webhooks_Run.php';
		}

		/**
		 * Add base hooks for the core functionality
		 *
		 * @access private
		 * @since 1.0.0
		 * @return void
		 */
		private function base_hooks() {
			add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );
		}

		/**
		 * Loads the plugin language files.
		 *
		 * @access public
		 * @since 1.0.0
		 * @return void
		 */
		public function load_textdomain() {
			load_plugin_textdomain( WW_TEXTDOMAIN, FALSE, dirname( plugin_basename( WW_PLUGIN_FILE ) ) . '/language/' );
		}

		/**
		 * Plugin Updater class for external extension (shop related)
		 *
		 * The following values should always get defined from the plugin
		 * that loads the updater class:
		 * 1. version
		 * 2. item_id
		 *
		 * @param $plugin_file - The plugin file ( __FILE__ )
		 * @param $settings - An array of the given settings
		 * @access public
		 * @since 1.5.5
		 * @return void
		 */
		public function load_updater( $plugin_file, $settings = array() ) {
			$default_args = array(
				'version'   => '1.0.0',
				'item_id'   => 0,
				'license'   => trim( wordpress_webhooks()->settings->get_license('key') ),
				'author'    => 'Pullbytes',
				'url'       => home_url()
			);

			$settings = array_merge( $default_args, $settings );

			new WordPress_Webhook_Updater( PULL_BYTES, $plugin_file, $settings );
		}

	}

endif; // End if class_exists check.