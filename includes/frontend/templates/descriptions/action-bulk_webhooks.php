<?php

/**
 * Template for executing bulk webhooks
 * 
 * Webhook type: action
 * Webhook name: bulk_webhooks
 * Template version: 1.0.0
 */

$translation_ident = "action-bulk-webhooks-description";
$trigger_settings = wordpress_webhooks()->settings->get_required_trigger_settings();
$data_mapping_templates = wordpress_webhooks()->data_mapping->get_data_mapping();
$authentication_templates = wordpress_webhooks()->auth->get_auth_templates();

?>

<?php echo wordpress_webhooks()->helpers->translate( "This webhook action allows you to fire multiple webhook calls within a single webhook call. It supports all kind of webhooks for internal and external connections and is compatible with all features of ", $translation_ident ) . $this->page_title; ?>
<br>
<?php echo wordpress_webhooks()->helpers->translate( "This description is uniquely made for the <strong>bulk_webhooks</strong> webhook action.", $translation_ident ); ?>
<br>
<?php echo wordpress_webhooks()->helpers->translate( "In case you want to first understand on how to setup webhook actions in general, please check out the following manuals:", $translation_ident ); ?>
<br>
<a title="Go to ironikus.com/docs" target="_blank" href="https://ironikus.com/docs/article-categories/get-started/">https://ironikus.com/docs/article-categories/get-started/</a>
<br><br>
<h4><?php echo wordpress_webhooks()->helpers->translate( "How to use <strong>bulk_webhooks</strong>", $translation_ident ); ?></h4>
<ol>
    <li><?php echo wordpress_webhooks()->helpers->translate( "The first argument you need to set within your webhook action request is the <strong>action</strong> argument. This argument is always required. Please set it to <strong>bulk_webhooks</strong>.", $translation_ident ); ?></li>
    <li><?php echo wordpress_webhooks()->helpers->translate( "All the other arguments are optional and just extend the custom execution of the webhooks.", $translation_ident ); ?></li>
</ol>

<h4><?php echo wordpress_webhooks()->helpers->translate( "Tipp", $translation_ident ); ?></h4>
<ol>
    <li><?php echo wordpress_webhooks()->helpers->translate( "To make the most out of this webhook endpoint, please take a look at the <strong>actions</strong> argument within the <strong>Special Arguments</strong> list.", $translation_ident ); ?></li>
    <li><?php echo wordpress_webhooks()->helpers->translate( "You can send data to internal and external URL's. There is no limitation to the system.", $translation_ident ); ?></li>
    <li><?php echo wordpress_webhooks()->helpers->translate( "This action integrates all available feature of this plugin. You can also connect data mapping templates, as well as authentication templates and much more.", $translation_ident ); ?></li>
</ol>
<br><br>
<h4><?php echo wordpress_webhooks()->helpers->translate( "Special Arguments", $translation_ident ); ?></h4>
<br>
<h5><?php echo wordpress_webhooks()->helpers->translate( "actions", $translation_ident ); ?></h5>
<?php echo wordpress_webhooks()->helpers->translate( "This argument contains a JSON construct that allows you to register multiple webhooks, which will then be executed in the given order. Each of the row acts as a separate webhook call with all of the available settings and configurations.", $translation_ident ); ?>
<pre>{
  "first_webhook_call": {
      "http_arguments": {
          "sslverify": false
      },
      "webhook_url": null,
      "webhook_name": "bulk_actions",
      "webhook_status": "active",
      "webhook_settings": {
          "ww_trigger_allow_unverified_ssl": 1,
          "ww_trigger_allow_unsafe_urls": 1,
      },
      "payload_data": {
          "action": "ww_test",
          "test_var": "test-value123"
      }
  },
  "second_webhook_call": {
      "payload_data": {
          "action": "ww_test",
          "test_var": "test-value123"
      }
  }
}</pre>
<?php echo wordpress_webhooks()->helpers->translate( "The JSON can contain multiple webhook calls that are marked via the top level key within the JSON (first_webhook_call, second_webhook_call, ...). This top-level-key indicates the webhook you want to fire and is later used within the response to add the response for that call. Down below you will find an explanation on each of the available settings.", $translation_ident ); ?>
<ol>
    <li>
        <strong>http_arguments</strong> (array)
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "This key accepts an array containing multiple arguments from the WP_Http object within WordPress. You can take a look at the argumet list by visiting on the following link:", $translation_ident ); ?> <a title="wordpress.org" target="_blank" href="https://developer.wordpress.org/reference/backend/classes/WP_Http/request/">https://developer.wordpress.org/reference/backend/classes/WP_Http/request/</a>
    </li>
    <li>
        <strong>webhook_url</strong> (string)
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "This contains the webhook URL you want to send the request to. By default, it is set to the same webhook URL you are sending this webhook action call to. You can also define external URL's here and send data out of WordPress.", $translation_ident ); ?>
    </li>
    <li>
        <strong>webhook_name</strong> (string)
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "The name as an identicator when you sent the webhook. By default, it is set to <strong>bulk_actions</strong>. This value will be sent over to the webhook call within the header as well.", $translation_ident ); ?>
    </li>
    <li>
        <strong>webhook_status</strong> (string)
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "Use this argumet to prevent the webhook from being sent in the first place. This allows you to temporarily deactivate the call instead of removing it completely fromthe JSON. To deactivate it, please set it to <strong>inactive</strong>. Default: <strong>active</strong>", $translation_ident ); ?>
    </li>
    <li>
        <strong>webhook_settings</strong> (array)
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "This powerful argument allows you to assign All the settings features, that are available for triggers, for ANY webhook call. That means you can even assign authentication and data mapping templates to triggers just for reformatting the data. Down below, you will find a list with all default trigger settings and its possible values:", $translation_ident ); ?>
        <ol>
            <?php
                foreach( $trigger_settings as $setting => $setting_data ){
                    $value = '';
                    $type = 'unknown';

                    if( isset( $setting_data['type'] ) ){
                        $type = $setting_data['type'];

                        if( $setting_data['type'] === 'select' ){

                            $choices = $setting_data['choices'];

                            if( $setting === 'ww_trigger_authentication' ){
                                $choices = array_replace( $choices, wordpress_webhooks()->auth->flatten_authentication_data( $authentication_templates ) );
                            }

                            if( $setting === 'ww_trigger_data_mapping' ){
                                $choices = array_replace( $choices, wordpress_webhooks()->data_mapping->flatten_data_mapping_data( $data_mapping_templates ) );
                            }

                            $value .= '<ul class="pl-3">';
                            foreach( $choices as $ck => $cv ){
                                $value .= '<li><strong>' . sanitize_title( $ck ) . '</strong> (' . sanitize_text_field( $cv ) . ')' . '</li>';
                            }
                            $value .= '</ul>';

                        } elseif( $setting_data['type'] === 'checkbox' ){
                            $value .= '<ul class="pl-3">';
                            $value .= '<li>0</li>';
                            $value .= '<li>1</li>';
                            $value .= '</ul>';
                        }
                    }
                    

                    echo '<li>';
                    echo '<strong>' . sanitize_title( $setting ) . '</strong> (' . wordpress_webhooks()->helpers->translate( "Type", $translation_ident ) . ' ' . $type . '): ';
                    echo $value;
                    echo '</li>';
                }
            ?>
        </ol>
    </li>
    <li>
        <strong>payload_data</strong> (mixed)
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "This key contains all of the actual data you would like to send to this specific webhook call.", $translation_ident ); ?>
    </li>
</ol>
<h5><?php echo wordpress_webhooks()->helpers->translate( "do_action", $translation_ident ); ?></h5>
<?php echo wordpress_webhooks()->helpers->translate( "The do_action argument is an advanced webhook for developers. It allows you to fire a custom WordPress hook after the bulk_webhooks action was fired.", $translation_ident ); ?>
<br>
<?php echo wordpress_webhooks()->helpers->translate( "You can use it to trigger further logic after the webhook action. Here's an example:", $translation_ident ); ?>
<br>
<br>
<?php echo wordpress_webhooks()->helpers->translate( "Let's assume you set for the <strong>do_action</strong> parameter <strong>fire_this_function</strong>. In this case, we will trigger an action with the hook name <strong>fire_this_function</strong>. Here's how the code would look in this case:", $translation_ident ); ?>
<pre>add_action( 'fire_this_function', 'my_custom_callback_function', 20, 2 );
function my_custom_callback_function( $actions, $return_args ){
    //run your custom logic in here
}
</pre>
<?php echo wordpress_webhooks()->helpers->translate( "Here's an explanation to each of the variables that are sent over within the custom function.", $translation_ident ); ?>
<ol>
    <li>
        <strong>$actions</strong> (array)
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "Contains the validated data from the <code>actions</code> argument.", $translation_ident ); ?>
    </li>
    <li>
        <strong>$return_args</strong> (array)
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "Contains the full response that is sent back to the webhook caller.s", $translation_ident ); ?>
    </li>
</ol>