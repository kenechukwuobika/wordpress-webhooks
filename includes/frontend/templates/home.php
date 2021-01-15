<div class="d-flex flex-column align-items-center">
    <div class="ww_home--heading">
        <h2 class="ww-heading-primary">
            <?php echo sprintf( wordpress_webhooks()->helpers->translate( 'Welcome to %s', 'ww-page-actions' ), WW_NAME ); ?>
        </h2>
    </div>

    <p class="ww_home--text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores</p>

    <div class="ww_info d-flex">
        <div class="card ww_card">
            <div class="card-header">GET STARTED</div>
            <div class="card-body">
                <p class="ww_card--text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero</p>
            </div>
            <a href="?page=wordpress_webhooks&tab=settings" class="btn btn-primary ww_btn">Set Up</a>
        </div>

        <div class="card ww_card">
            <div class="card-header">GO PRO</div>
            <div class="card-body">
                <p class="ww_card--text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero</p>
            </div>
            <a href="#" class="btn btn-primary ww_btn">Upgrade Plugin</a>
        </div>

        <div class="card ww_card">
            <div class="card-header">CONTACT US</div>
            <div class="card-body">
                <p class="ww_card--text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero</p>
            </div>
            <a href="#" class="btn btn-primary ww_btn">Contact Us</a>
        </div>
    </div>

    <div class="ww_plugin--rate">
        <div class="card ww_card">
            <div class="card-header">Please us spread the word and keep this plugin up to date</div>
            <div class="card-body">
                <p class="ww_card--text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero</p>
                <ul class="list-unstyled">
    <li>
        <strong>Rate the plugin </strong>
        <div id="plugin_rating" class="rateit"
            data-rateit-readonly="true" data-rateit-value="3"
            data-rateit-resetable="false" data-rid="1">
        </div>
        <div id="recipe_rating" class="rateit"
            READONLY_PLACEHOLDER data-rateit-value="RECIPE_RATING"
            data-rateit-resetable="false" data-rid="RECIPE_ID">
        </div>
    </li>

</ul>
            </div>
        </div>
    </div>
</div>


