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

require_once "constants.php";

// Exit if accessed directly.
if ( !defined( 'ABSPATH' ) ) exit;


//Preload Whitelabel data
$whitelabel_data = get_option( 'ironikus_webhook_whitelabel' );
if( 
	! empty( $whitelabel_data ) 
	&& isset( $whitelabel_data['ww_whitelabel_name'] ) 
	&& isset( $whitelabel_data['ww_whitelabel_activate'] ) 
	&& $whitelabel_data['ww_whitelabel_activate'] === 'yes' 
	&& ! empty( $whitelabel_data['ww_whitelabel_name'] ) 
){
	// Plugin name.
	define( 'WW_NAME',		  $whitelabel_data['ww_whitelabel_name'] );
} else {
	// Plugin name.
	define( 'WW_NAME',		  'WordPress Webhooks' );
}





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