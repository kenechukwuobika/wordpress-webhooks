<?php
$go_pro = 'GO PRO';
if(defined('WW_PRO_SETUP')){
    $go_pro = 'MANAGE EXTENSIONS';
}

?>


<div class="d-flex flex-column align-items-center">
    <div class="ww_home--heading">
        <h2 class="ww-heading-primary">
            <?php echo sprintf( wordpress_webhooks()->helpers->translate( 'Welcome to %s', 'ww-page-actions' ), wordpress_webhooks()->settings->get_page_title() ); ?>
        </h2>
    </div>

    <p class="ww_home--text">
                <?php if( defined('WW_PRO_SETUP') && wordpress_webhooks()->whitelabel->is_active() && ! empty( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_home' ) ) ) : ?>
                    <?php echo wordpress_webhooks()->helpers->translate( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_home' ), 'admin-settings-license' ); ?>
                <?php else : ?>
                    <?php echo wordpress_webhooks()->helpers->translate( 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores</p>'); ?>
				<?php endif; ?>

    <div class="ww_info">
        <div class="d-flex justify-content-between ww_offers">
            <div class="ww_card">
                <div class="ww_card--header ww_card--header__1">
                    <h4 class="ww_card--title ww_card--title__1">GET STARTED</h4>
                    <p class="ww_card--text">Lorem ipsum dolor sit amet, consetetur sadipscing elit.</p>
                </div>
                <div class="ww_card--body">
                    <img class="ww_card--img" src="<?php echo WW_PLUGIN_URL . 'includes/frontend/assets/img/home_banner1.png'; ?>" alt="home_banner1">
                </div>
                <div class="ww_card--footer">
                    <a href="?page=wordpress_webhooks&tab=settings" class="btn btn-primary ww_btn ww_card--btn">Set Up</a>
                </div>
            </div>

            <div class="ww_card">
                <?php
                    if(!defined('WW_PRO_SETUP')){

                ?>
                    <div class="ww_popular">popular</div>
                    <div class="ww_card--header ww_card--header__2">
                        <h4 class="ww_card--title ww_card--title__1">GO PRO</h4>                
                        <p class="ww_card--text">Lorem ipsum dolor sit amet, consetetur sadipscing elit.</p>
                    </div>
                    <div class="ww_card--body">
                        <img class="ww_card--img" src="<?php echo WW_PLUGIN_URL . 'includes/frontend/assets/img/home_banner2.png'; ?>" alt="home_banner2">
                    </div>
                    <div class="ww_card--footer">
                        <a href="?page=wordpress_webhooks&tab=license" class="btn btn-primary ww_btn ww_card--btn">Upgrade Plugin</a>
                    </div>
                
                <?php   
                    }
                    else{
                ?>
                    <div class="ww_card--header ww_card--header__2">
                        <h4 class="ww_card--title ww_card--title__1">MANAGE INTEGRATIONS</h4>                
                        <p class="ww_card--text">Lorem ipsum dolor sit amet, consetetur sadipscing elit.</p>
                    </div>
                    <div class="ww_card--body">
                        <img class="ww_card--img" src="<?php echo WW_PLUGIN_URL . 'includes/frontend/assets/img/home_banner2.png'; ?>" alt="home_banner2">
                    </div>
                    <div class="ww_card--footer">
                        <a href="?page=wordpress_webhooks&tab=integrations" class="btn btn-primary ww_btn ww_card--btn">Manage</a>
                    </div>
                <?php   
                    }

                ?>
                
            </div>

            <div class="ww_card">
                <div class="ww_card--header ww_card--header__3">
                    <h4 class="ww_card--title ww_card--title__1">CONTACT US</h4>                
                    <p class="ww_card--text">Lorem ipsum dolor sit amet, consetetur sadipscing elit.</p>
                </div>
                <div class="ww_card--body">
                    <img class="ww_card--img" src="<?php echo WW_PLUGIN_URL . 'includes/frontend/assets/img/home_banner3.png'; ?>" alt="home_banner3">
                </div>
                <div class="ww_card--footer">
                    <a href="#" class="btn btn-primary ww_btn ww_card--btn">Talk to an Expert</a>
                </div>
            </div>
        </div>

        

        <div class="ww_rating">
            <div class="ww_rating--overall ww_card">
                <p class="ww_rating--title">Overall Rating</p>
                <p class="ww_rating--score">
                    <span class="ww_rating--score__main">4.5</span>
                    <span class="ww_rating--score__sub">/5</span>
                </p>
                <div class="ww_rating--stars">
                    <img src="<?php echo WW_PLUGIN_URL . 'includes/frontend/assets/img/star_fill.png'; ?>" alt="star_fill">
                    <img src="<?php echo WW_PLUGIN_URL . 'includes/frontend/assets/img/star_fill.png'; ?>" alt="star_fill">
                    <img src="<?php echo WW_PLUGIN_URL . 'includes/frontend/assets/img/star_fill.png'; ?>" alt="star_fill">
                    <img src="<?php echo WW_PLUGIN_URL . 'includes/frontend/assets/img/star_fill.png'; ?>" alt="star_fill">
                    <img src="<?php echo WW_PLUGIN_URL . 'includes/frontend/assets/img/star_hollow.png'; ?>" alt="star_hollow">
                </div>
                <p class="ww_rating--sub">200 reviews</p>
            </div>
            <div class="ww_rating--ratenow ww_card">
                <p class="ww_rating--title">Please us spread the word and keep this plugin up to date</p>
                <p class="ww_rating--text">If you use Wordpress Webhooks, Please rate it on Wordpress.org. It only takes second and help us keep the plugin maintained. Thank you!</p>
                <a href="#" class="btn ww_rating--btn">Rate the plugin</a>
                <a href="#" class="ww_rating--sub">I have already rated it</a>

            </div>
        </div>


        
    
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


