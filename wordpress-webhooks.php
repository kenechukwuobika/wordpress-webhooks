<?php
/**
 * Plugin Name: WordPress Webhooks
 * Plugin URI: https://pullbytes.com/downloads/wordpress-webhooks/
 * Description: Automate your WordPress system with Webhooks
 * Version: 1.0.0
 * Author: Pullbytes
 * Author URI: https://pullbytes.com/
 * License: GPL2
 *
 * You should have received a copy of the GNU General Public License
 * along with TMG User Filter. If not, see <http://www.gnu.org/licenses/>.
 */

//Determines if plugin is in development or production environment
define('WW_DEV_MODE',       'development');

// Plugin version.
define( 'WW_VERSION',        '1.0.0' );

// Determines if the plugin is loaded
define( 'WW_SETUP',          true );

// Plugin Root File.
define( 'WW_PLUGIN_FILE',    __FILE__ );

// Plugin base.
define( 'WW_PLUGIN_BASE',    plugin_basename( WW_PLUGIN_FILE ) );

// Plugin Folder Path.
define( 'WW_PLUGIN_DIR',     plugin_dir_path( WW_PLUGIN_FILE ) );

// Plugin Folder URL.
define( 'WW_PLUGIN_URL',     plugin_dir_url( WW_PLUGIN_FILE ) );

// Plugin Root File.
//Defined within /core/includes/backend/classes/WordPress_Webhooks_Helpers.php
//Please check the translation function for the original definition
define( 'WW_TEXTDOMAIN',     'wordpress-webhooks' );

// Plugin Store URL
define( 'PULL_BYTES',        'https://wordpress-webhooks-api.herokuapp.com/api/v1/verify_license' );

// Plugin Store ID
define( 'WW_PLUGIN_ID',    183 );

// News ID
define( 'WW_NEWS_FEED_ID', 1 );

// Exit if accessed directly.
if ( !defined( 'ABSPATH' ) ) exit;


// Plugin name.
define( 'WW_NAME',		  'WordPress Webhooks' );



/*
 * Load the main instance for our core functions
 */
if( ! defined( 'WPWH_SETUP' ) ){

	/**
	 * Load the main instance for our core functions
	 */
	require_once WW_PLUGIN_DIR . 'includes/backend/classes/WordPress_Webhooks.php';

	/**
	 * The main function to load the only instance
	 * of our master class.
	 *
	 * @return object|WordPress_Webhooks
	 */
	function wordpress_webhooks() {
		return WordPress_Webhooks::instance();
	}

	wordpress_webhooks();

} else {

	add_action( 'admin_notices', 'ww_free_version_custom_notice', 100 );
	function ww_free_version_custom_notice(){

		ob_start();
		?>
		<div class="notice notice-warning">
			<p><?php echo 'To use <strong>' . WW_NAME . '</strong> properly, please deactivate <strong>WP Webhooks</strong>.'; ?></p>
		</div>
		<?php
		echo ob_get_clean();

	}
}