<?php
/**
 * Main Template
 */

$heading = '';
$current_content = '';
$plugin_name = wordpress_webhooks()->helpers->translate( $this->page_title, 'admin-add-page-title' );

/**
 * Filter the menu tab items. You can extend here your very own tabs
 * as well.
 * Our default endpoints are declared in
 * includes/backend/classes/WordPress_Webhooks_Run.php
 */
$menu_endpoints = apply_filters( 'ww/admin/settings/menu_data', array() );

if( isset( $_GET['tab'] ) && $_GET['tab'] != 'home' ){

    $active_val = sanitize_title( $_GET['tab'] );
    /**
     * Filter the global plugin admin capability again to create an
     * independent capability possibility system for the element settings
     */
    if( current_user_can( apply_filters( 'ww/admin/settings/menu/page_capability', wordpress_webhooks()->settings->get_admin_cap( 'ww-page-settings' ), $active_val ) ) ){
        /**
         * The following hook gives you the possibility to
         * output custom content on the specified page with the filter
         *
         * @hook  ww/admin/settings/menu_data
         */

        //Buffer for avoiding errors
        ob_start();
        do_action( 'ww_display_admin_content', $active_val );
        $current_content = ob_get_clean();

        /**
         * Possibility to filter the content after
         * creating its output
         */
        $current_content = apply_filters( 'ww_current_content_filter', $current_content, $active_val );
    }

} else {
	$active_val      = 'home';
    // $remote_content      = wordpress_webhooks()->api->get_news_feed( WW_NEWS_FEED_ID );
    
    // if( wordpress_webhooks()->whitelabel->is_active() && ! empty( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_home' ) ) ){
    //     $remote_content = wordpress_webhooks()->helpers->validate_local_tags( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_home' ) );
    // }


	if( empty( $remote_content ) ){
        ob_start();
        do_action( 'ww_display_admin_content', $active_val );
		$current_content = ob_get_clean();
    } else {
		$current_content = $remote_content;
    }

	$current_content = ! empty( $current_content ) ? $current_content : wordpress_webhooks()->helpers->translate( 'Welcome to WP Webhook Pro! Currently we are not able to show you the newest informations.', 'admin-backend' ) ;
}

if( is_array( $menu_endpoints ) ){
	foreach( $menu_endpoints as $hook_name => $title ){
		/**
		 * Filter the global plugin admin capability again to create an
		 * independent capability possibility system for the element settings
		 */
		if( current_user_can( apply_filters( 'ww/admin/settings/menu/page_capability', wordpress_webhooks()->settings->get_admin_cap( 'ww-page-settings' ), $active_val ) ) ){

			/**
			 * Hook for Filterinng the title of a specified plugin file
			 */ 
			$title = apply_filters( 'ww/admin/settings/element/filter_title', $title, $hook_name );

			if( $active_val == $hook_name ){
				$heading .= '<li class="nav-item ww_nav--active ww_nav-item active"><a class="nav-link ironikus-setting-single-tab active ' . $hook_name . '">' . $title . '</a></li>';
			} else {
				$heading .= '<li class="nav-item ww_nav-item"><a class="nav-link ironikus-setting-single-tab ' . $hook_name . '" href="?page=' . $this->page_name . '&tab=' . $hook_name . '">' . $title . '</a></li>';
			}
		}

	}
} else {
	$heading = '<li class="nav-item ww_nav-item active"><a class="nav-link ironikus-setting-single-tab" href="?page=' . $this->page_name . '">' . wordpress_webhooks()->helpers->translate( $subs_origin['home'], 'admin-backend' ) . '</a></li>';
}

?>



<style>
    #wpfooter{
        display:none;
    }
</style>

<div id="ww__container">
    

    <nav class="navbar ww__navbar navbar-expand-lg navbar-dark">
        <button class="navbar-toggler justify-content-end" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-start" id="navbarNav">
            <ul class="navbar-nav">
                <?php echo $heading; ?>
            </ul>
        </div>
    </nav>

        <div class="ww__content">
            <?php echo $current_content; ?>
        </div>

</div>