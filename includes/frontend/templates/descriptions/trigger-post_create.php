<?php

/**
 * Template for post create trigger
 * 
 * Webhook type: trigger
 * Webhook name: post_create
 * Template version: 1.0.0
 */

$translation_ident = "trigger-create-post-description";

?>

<?php echo wordpress_webhooks()->helpers->translate( "This webhook trigger is used to send data, on the creation of a post, to one or multiple given webhook URL's.", $translation_ident ); ?>
<br>
<?php echo wordpress_webhooks()->helpers->translate( "This description is uniquely made for the <strong>Send Data On New Post</strong> (post_create) webhook trigger.", $translation_ident ); ?>
<br><br>
<h4><?php echo wordpress_webhooks()->helpers->translate( "How to use <strong>Send Data On New Post</strong> (post_create)", $translation_ident ); ?></h4>
<ol>
    <li><?php echo wordpress_webhooks()->helpers->translate( "To get started, you need to add your receiving URL endpoint, that accepts webhook requests, from the third-party provider or service you want to use.", $translation_ident ); ?></li>
    <li><?php echo wordpress_webhooks()->helpers->translate( "Once you have this URL, please place it into the <strong>Webhook URL</strong> field above.", $translation_ident ); ?></li>
    <li><?php echo wordpress_webhooks()->helpers->translate( "For better identification of the webhook URL, we recommend to also fill the <strong>Webhook Name</strong> field. This field will be used as the slug for your webhook URL. In case you leave it empty, we will automatically generate a random number as an identifier.", $translation_ident ); ?></li>
    <li><?php echo wordpress_webhooks()->helpers->translate( "After you added your <strong>Webhook URL</strong>, press the <strong>Add</strong> button to finish adding the entry.", $translation_ident ); ?></li>
    <li><?php echo wordpress_webhooks()->helpers->translate( "That's it! Now you can receive data on the URL once the trigger fires.", $translation_ident ); ?></li>
    <li><?php echo wordpress_webhooks()->helpers->translate( "Next to the <strong>Webhook URL</strong>, you will find a settings item, which you can use to customize the payload/request.", $translation_ident ); ?></li>
</ol>
<br><br>

<h4><?php echo wordpress_webhooks()->helpers->translate( "When does this trigger fire?", $translation_ident ); ?></h4>
<br>
<?php echo wordpress_webhooks()->helpers->translate( "This trigger is registered on the <strong>add_attachment</strong> hook and the <strong>wp_insert_post</strong> hook:", $translation_ident ); ?> 
<br>
<strong><?php echo wordpress_webhooks()->helpers->translate( "Add attachment", $translation_ident ); ?></strong>: <a title="wordpress.org" target="_blank" href="https://developer.wordpress.org/reference/hooks/add_attachment/">https://developer.wordpress.org/reference/hooks/add_attachment/</a>
<br>
<strong><?php echo wordpress_webhooks()->helpers->translate( "Insert post", $translation_ident ); ?></strong>: <a title="wordpress.org" target="_blank" href="https://developer.wordpress.org/reference/hooks/wp_insert_post/">https://developer.wordpress.org/reference/hooks/wp_insert_post/</a>
<br><br>
<?php echo wordpress_webhooks()->helpers->translate( "This webhook fires on two different hooks since attachments (which are technically posts as well), use a custom logic.", $translation_ident ); ?>
<br>
<br>
<?php echo wordpress_webhooks()->helpers->translate( "Here are the calls within our code we use to fire this trigger:", $translation_ident ); ?>
<pre>add_action( 'add_attachment', array( $this, 'ironikus_trigger_post_create_attachment_init' ), 10, 1 );
add_action( 'wp_insert_post', array( $this, 'ironikus_trigger_post_create_init' ), 10, 3 );</pre>
<?php echo wordpress_webhooks()->helpers->translate( "<strong>IMPORTANT</strong>: Please note that this webhook does not fire, by default, once the actual trigger (wp_insert_post/add_attachment) is fired, but as soon as the WordPress <strong>shutdown</strong> hook fires. This is important since we want to allow third-party plugins to make their relevant changes before we send over the data. To deactivate this functionality, please go to our <strong>Settings</strong> and activate the <strong>Deactivate Post Trigger Delay</strong> settings item. This results in the webhooks firing straight after the initial hook is called.", $translation_ident ); ?>
<br><br><br>
<h4><?php echo wordpress_webhooks()->helpers->translate( "Tipps", $translation_ident ); ?></h4>
<ol>
    <li><?php echo wordpress_webhooks()->helpers->translate( "In case you don't need a specified webhook URL at the moment, you can simply deactivate it by clicking the <strong>Deactivate</strong> link next to the <strong>Webhook URL</strong>. This results in the specified URL not being fired once the trigger fires.", $translation_ident ); ?></li>
    <li><?php echo wordpress_webhooks()->helpers->translate( "You can use the <strong>Send demo</strong> button to send a static request to your specified <strong>Webhook URL</strong>. Please note that the data sent within the request might differ from your live data.", $translation_ident ); ?></li>
    <li><?php echo wordpress_webhooks()->helpers->translate( "Within the <strong>Settings</strong> link next to your <strong>Webhook URL</strong>, you can use customize the functionality of the request. It contains certain default settings like changing the request type the data is sent in, or custom settings, depending on your trigger. An explanation for each setting is right next to it. (Please don't forget to save the settings once you changed them - the button is at the end of the popup.)", $translation_ident ); ?></li>
    <li><?php echo wordpress_webhooks()->helpers->translate( "You can also check the response you get from the demo webhook call. To check it, simply open the console of your browser and you will find an entry there, which gives you all the details about the response.", $translation_ident ); ?></li>
</ol>
<br><br>

<?php echo wordpress_webhooks()->helpers->translate( "In case you would like to learn more about our plugin, please check out our documentation at:", $translation_ident ); ?>
<br>
<a title="Go to ironikus.com/docs" target="_blank" href="https://ironikus.com/docs/article-categories/get-started/">https://ironikus.com/docs/article-categories/get-started/</a>