<?php

/**
 * Template for executing a custom action
 * 
 * Webhook type: action
 * Webhook name: ww_test
 * Template version: 1.0.0
 */

$translation_ident = "action-ironikus-test-description";

?>

<?php echo sprintf( wordpress_webhooks()->helpers->translate( "This webhook action is only used for testing purposes to test if %s works properly on your WordPress website.", $translation_ident ), WW_NAME ); ?>
<br>
<?php echo wordpress_webhooks()->helpers->translate( "This description is uniquely made for the <strong>ww_test</strong> webhook action.", $translation_ident ); ?>
<br>
<?php echo wordpress_webhooks()->helpers->translate( "In case you want to first understand on how to setup webhook actions in general, please check out the following manuals:", $translation_ident ); ?>
<br>
<a title="Go to ironikus.com/docs" target="_blank" href="https://ironikus.com/docs/article-categories/get-started/">https://ironikus.com/docs/article-categories/get-started/</a>
<br><br>
<h4><?php echo wordpress_webhooks()->helpers->translate( "How to use <strong>ww_test</strong>", $translation_ident ); ?></h4>
<ol>
    <li><?php echo wordpress_webhooks()->helpers->translate( "The first argument you need to set within your webhook action request is the <strong>action</strong> argument. This argument is always required. Please set it to <strong>ww_test</strong>.", $translation_ident ); ?></li>
    <li><?php echo wordpress_webhooks()->helpers->translate( "The second argument you need to set is <strong>test_var</strong>. Please set it to <strong>test-value123</strong>", $translation_ident ); ?></li>
</ol>
<h4><?php echo wordpress_webhooks()->helpers->translate( "Tipp", $translation_ident ); ?></h4>
<?php echo sprintf( wordpress_webhooks()->helpers->translate( "This webhook makes sense if you want to test if %s works properly on your WordPress website. You can try to setup different values to see how the webhook interacts with your site.", $translation_ident ), WW_NAME ); ?>
<br>
<?php echo wordpress_webhooks()->helpers->translate( "You can also use it to test the functionality using our Ironikus assistant:", $translation_ident ); ?>
<a title="ironikus.com" target="_blank" href="https://ironikus.com/assistant/">https://ironikus.com/assistant/</a>