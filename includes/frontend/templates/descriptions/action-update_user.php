<?php

/**
 * Template for updating a user
 * 
 * Webhook type: action
 * Webhook name: update_user
 * Template version: 1.0.0
 */

$translation_ident = "action-update-user-description";

?>

<?php echo wordpress_webhooks()->helpers->translate( "This webhook action is used to update a user on your WordPress system via a webhook call.", $translation_ident ); ?>
<br>
<?php echo wordpress_webhooks()->helpers->translate( "The description is uniquely made for the <strong>update_user</strong> webhook action.", $translation_ident ); ?>
<br>
<?php echo wordpress_webhooks()->helpers->translate( "In case you want to first understand how to setup webhook actions in general, please check out the following manuals:", $translation_ident ); ?>
<br>
<a title="Go to ironikus.com/docs" target="_blank" href="https://ironikus.com/docs/article-categories/get-started/">https://ironikus.com/docs/article-categories/get-started/</a>
<br><br>
<h4><?php echo wordpress_webhooks()->helpers->translate( "How to use <strong>update_user</strong>", $translation_ident ); ?></h4>
<ol>
    <li><?php echo wordpress_webhooks()->helpers->translate( "The first argument you need to set within your webhook action request is the <strong>action</strong> argument. This argument is always required. Please set it to <strong>update_user</strong>.", $translation_ident ); ?></li>
    <li><?php echo wordpress_webhooks()->helpers->translate( "It is also required to set the users email address or the user id using the argument <strong>user_email/user_id</strong>. You can as well set both of them, but in this case, the user id has a higher priority than the email for fetching the user.", $translation_ident ); ?></li>
    <li><?php echo wordpress_webhooks()->helpers->translate( "All the other arguments are optional and just extend the updating process of the user.", $translation_ident ); ?></li>
</ol>
<br><br>
<h4><?php echo wordpress_webhooks()->helpers->translate( "Special Arguments", $translation_ident ); ?></h4>
<br>
<h5><?php echo wordpress_webhooks()->helpers->translate( "role", $translation_ident ); ?></h5>
<?php echo wordpress_webhooks()->helpers->translate( "The slug of the role. The default roles have the following slugs: administrator, editor, author, contributor, subscriber", $translation_ident ); ?>
<br>
<strong><?php echo wordpress_webhooks()->helpers->translate( "Important", $translation_ident ); ?></strong>: <?php echo wordpress_webhooks()->helpers->translate( "Please note that once you set this value while updating a user, all of your additional roles are removed from that user. This is a default WordPress behavior. If you don't want that, please only use the <strong>additional_roles</strong> argument and leave this one empty. (In case you set the argument <strong>create_if_none</strong> to <strong>yes</strong>, it will create the user with the default role. If you don't want that, simply remove that role within the <strong>additional_roles</strong> argument again).", $translation_ident ); ?>
<br>
<hr>
<h5><?php echo wordpress_webhooks()->helpers->translate( "additional_roles", $translation_ident ); ?></h5>
<?php echo wordpress_webhooks()->helpers->translate( "This argument allows you to add or remove additional roles on the user. There are two possible ways of doing that:", $translation_ident ); ?>
<ol>
    <li>
        <strong><?php echo wordpress_webhooks()->helpers->translate( "String method", $translation_ident ); ?></strong>
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "This method allows you to add or remove the user roles using a simple string. To make it work, simply add the slug of the role and define the action (add/remove) after, separated by double points (:). If you want to add multiple roles, simply separate them with a semicolon (;). Please refer to the example down below.", $translation_ident ); ?>
        <pre>editor:add;custom-role:add;custom-role-1:remove</pre>
    </li>
    <li>
        <strong><?php echo wordpress_webhooks()->helpers->translate( "JSON method", $translation_ident ); ?></strong>
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "We also support a JSON formatted string, which contains the role slug as the JSON key and the action (add/remove) as the value. Please refer to the example below:", $translation_ident ); ?>
        <pre>{
  "editor": "add",
  "custom-role": "add",
  "custom-role-1": "remove"
}</pre>
    </li>
</ol>
<hr>

<!-- DEPRECTAED ARGUMENT -->
<h5><?php echo wordpress_webhooks()->helpers->translate( "user_meta (Deprecated)", $translation_ident ); ?></h5>
<div class="accordion" id="wpwh-action-accordion-<?php echo $translation_ident; ?>">
    <div class="card">
        <div class="card-header" id="wpwh-action-<?php echo $translation_ident; ?>"  data-toggle="collapse" data-target="#wpwh-action-content-<?php echo $translation_ident; ?>" aria-expanded="false" aria-controls="collapseactionMainData-<?php echo $identkey; ?>">
            <button class="btn btn-link collapsed" type="button">
            <?php echo wordpress_webhooks()->helpers->translate( "Click to see the deprecated description for this argument.", $translation_ident ); ?>
            </button>
        </div>

        <div id="wpwh-action-content-<?php echo $translation_ident; ?>" class="collapse" aria-labelledby="wpwh-action-<?php echo $translation_ident; ?>" data-parent="#wpwh-action-accordion-<?php echo $translation_ident; ?>">
            <div class="card-body">
                <div class="accordion-body__contents">
                    <?php echo wordpress_webhooks()->helpers->translate( "This argument is specifically designed to add/update or remove user meta to your updated user.", $translation_ident ); ?>
                    <br>
                    <?php echo wordpress_webhooks()->helpers->translate( "To create/update or delete custom meta values, we offer you two different ways:", $translation_ident ); ?>
                    <ol>
                        <li>
                            <strong><?php echo wordpress_webhooks()->helpers->translate( "String method", $translation_ident ); ?></strong>
                            <br>
                            <?php echo wordpress_webhooks()->helpers->translate( "This method allows you to add/update or delete the user meta using a simple string. To make it work, separate the meta key from the value using a comma (,). To separate multiple meta settings from each other, simply separate them with a semicolon (;). To remove a meta value, simply set as a value <strong>ironikus-delete</strong>", $translation_ident ); ?>
                            <pre>meta_key_1,meta_value_1;my_second_key,ironikus-delete</pre>
                            <?php echo wordpress_webhooks()->helpers->translate( "<strong>IMPORTANT:</strong> Please note that if you want to use values that contain commas or semicolons, the string method does not work. In this case, please use the JSON method.", $translation_ident ); ?>
                        </li>
                        <li>
                        <strong><?php echo wordpress_webhooks()->helpers->translate( "JSON method", $translation_ident ); ?></strong>
                            <br>
                            <?php echo wordpress_webhooks()->helpers->translate( "This method allows you to add/update or remove the user meta using a JSON formatted string. To make it work, add the meta key as the key and the meta value as the value. To delete a meta value, simply set the value to <strong>ironikus-delete</strong>. Here's an example on how this looks like:", $translation_ident ); ?>
<pre>{
"meta_key_1": "This is my meta value 1",
"another_meta_key": "This is my second meta key!"
"third_meta_key": "ironikus-delete"
}</pre>
                        </li>
                    </ol>
                    <strong><?php echo wordpress_webhooks()->helpers->translate( "Advanced", $translation_ident ); ?></strong>: <?php echo wordpress_webhooks()->helpers->translate( "We also offer JSON to array/object serialization for single user meta values. This means, you can turn JSON into a serialized array or object.", $translation_ident ); ?>
                    <br>
                    <?php echo wordpress_webhooks()->helpers->translate( "As an example: The following JSON <code>{\"price\": \"100\"}</code> will turn into <code>O:8:\"stdClass\":1:{s:5:\"price\";s:3:\"100\";}</code> with default serialization or into <code>a:1:{s:5:\"price\";s:3:\"100\";}</code> with array serialization.", $translation_ident ); ?>
                    <ol>
                        <li>
                            <strong><?php echo wordpress_webhooks()->helpers->translate( "Object serialization", $translation_ident ); ?></strong>
                            <br>
                            <?php echo wordpress_webhooks()->helpers->translate( "This method allows you to serialize a JSON to an object using the default json_decode() function of PHP.", $translation_ident ); ?>
                            <br>
                            <?php echo wordpress_webhooks()->helpers->translate( "To serialize your JSON to an object, you need to add the following string in front of the escaped JSON within the value field of your single meta value of the user_meta argument: <code>ironikus-serialize</code>. Here's a full example:", $translation_ident ); ?>
<pre>{
"meta_key_1": "This is my meta value 1",
"another_meta_key": "This is my second meta key!",
"third_meta_key": "ironikus-serialize{\"price\": \"100\"}"
}</pre>
                            <?php echo wordpress_webhooks()->helpers->translate( "This example will create three user meta entries. The third entry has the meta key <strong>third_meta_key</strong> and a serialized meta value of <code>O:8:\"stdClass\":1:{s:5:\"price\";s:3:\"100\";}</code>. The string <code>ironikus-serialize</code> in front of the escaped JSON will tell our plugin to serialize the value. Please note that the JSON value, which you include within the original JSON string of the user_meta argument, needs to be escaped.", $translation_ident ); ?>
                        </li>
                        <li>
                            <strong><?php echo wordpress_webhooks()->helpers->translate( "Array serialization", $translation_ident ); ?></strong>
                            <br>
                            <?php echo wordpress_webhooks()->helpers->translate( "This method allows you to serialize a JSON to an array using the json_decode( \$json, true ) function of PHP.", $translation_ident ); ?>
                            <br>
                            <?php echo wordpress_webhooks()->helpers->translate( "To serialize your JSON to an array, you need to add the following string in front of the escaped JSON within the value field of your single meta value of the user_meta argument: <code>ironikus-serialize-array</code>. Here's a full example:", $translation_ident ); ?>
<pre>{
"meta_key_1": "This is my meta value 1",
"another_meta_key": "This is my second meta key!",
"third_meta_key": "ironikus-serialize-array{\"price\": \"100\"}"
}</pre>
                            <?php echo wordpress_webhooks()->helpers->translate( "This example will create three user meta entries. The third entry has the meta key <strong>third_meta_key</strong> and a serialized meta value of <code>a:1:{s:5:\"price\";s:3:\"100\";}</code>. The string <code>ironikus-serialize-array</code> in front of the escaped JSON will tell our plugin to serialize the value. Please note that the JSON value, which you include within the original JSON string of the user_meta argument, needs to be escaped.", $translation_ident ); ?>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>

<h5><?php echo wordpress_webhooks()->helpers->translate( "manage_meta_data", $translation_ident ); ?></h5>
<?php echo wordpress_webhooks()->helpers->translate( "This argument integrates the full features of managing user related meta values.", $translation_ident ); ?>
<br>
<br>
<?php echo wordpress_webhooks()->helpers->translate( "<strong>Please note</strong>: This argument is very powerful and requires some good understanding of JSON. It is integrated with the commonly used functions for managing user meta within WordPress. You can find a list of all avaialble functions here: ", $translation_ident ); ?>
<ul>
    <li><strong>add_user_meta()</strong>: <a title="Go to WordPress" target="_blank" href="https://developer.wordpress.org/reference/functions/add_user_meta/">https://developer.wordpress.org/reference/functions/add_user_meta/</a></li>
    <li><strong>update_user_meta()</strong>: <a title="Go to WordPress" target="_blank" href="https://developer.wordpress.org/reference/functions/update_user_meta/">https://developer.wordpress.org/reference/functions/update_user_meta/</a></li>
    <li><strong>delete_user_meta()</strong>: <a title="Go to WordPress" target="_blank" href="https://developer.wordpress.org/reference/functions/delete_user_meta/">https://developer.wordpress.org/reference/functions/delete_user_meta/</a></li>
</ul>
<br>
<?php echo wordpress_webhooks()->helpers->translate( "Down below you will find a complete JSON example that shows you how to use each of the functions above.", $translation_ident ); ?>
<br>
<br>
<?php echo wordpress_webhooks()->helpers->translate( "We also offer JSON to array/object serialization for single user meta values. This means, you can turn JSON into a serialized array or object.", $translation_ident ); ?>
<br>
<?php echo wordpress_webhooks()->helpers->translate( "This argument accepts a JSON construct as an input. This construct contains each available function as a top-level key within the first layer and the assigned data respectively as a value. If you want to learn more about each line, please take a closer look at the bottom of the example.", $translation_ident ); ?>
<pre>{
   "add_user_meta":[
      {
        "meta_key": "first_custom_key",
        "meta_value": "Some custom value"
      },
      {
        "meta_key": "second_custom_key",
        "meta_value": { "some_array_key": "Some array Value" },
        "unique": true
      } 
    ],
   "update_user_meta":[
      {
        "meta_key": "first_custom_key",
        "meta_value": "Some custom value"
      },
      {
        "meta_key": "second_custom_key",
        "meta_value": "The new value",
        "prev_value": "The previous value"
      } 
    ],
   "delete_user_meta":[
      {
        "meta_key": "first_custom_key"
      },
      {
        "meta_key": "second_custom_key",
        "meta_value": "Target specific value"
      } 
    ]
}</pre>
<?php echo wordpress_webhooks()->helpers->translate( "Down below you will find a list that explains each of the top level keys.", $translation_ident ); ?>
<ol>
    <li>
        <strong><?php echo wordpress_webhooks()->helpers->translate( "add_user_meta", $translation_ident ); ?></strong>
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "This key refers to the <strong>add_user_meta()</strong> function of WordPress:", $translation_ident ); ?> <a title="Go to WordPress" target="_blank" href="https://developer.wordpress.org/reference/functions/add_user_meta/">https://developer.wordpress.org/reference/functions/add_user_meta/</a>
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "In the example above, you will find two entries within the add_user_meta key. The first one shows the default behavior using only the meta key and the value. This causes the meta key to be created without checking upfront if it exists - that allows you to create the meta value multiple times.", $translation_ident ); ?>
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "As seen in the second entry, you will find a third key called <strong>unique</strong> that allows you to check upfront if the meta key exists already. If it does, the meta entry is neither created, nor updated. Set the value to <strong>true</strong> to check against existing ones. Default: false", $translation_ident ); ?>
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "If you look closely to the second entry again, the value included is not a string, but a JSON construct, which is considered as an array and will therefore be serialized. The given value will be saved to the database in the following format: <code>a:1:{s:14:\"some_array_key\";s:16:\"Some array Value\";}</code>", $translation_ident ); ?>
    </li>
    <li>
        <strong><?php echo wordpress_webhooks()->helpers->translate( "update_user_meta", $translation_ident ); ?></strong>
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "This key refers to the <strong>update_user_meta()</strong> function of WordPress:", $translation_ident ); ?> <a title="Go to WordPress" target="_blank" href="https://developer.wordpress.org/reference/functions/update_user_meta/">https://developer.wordpress.org/reference/functions/update_user_meta/</a>
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "The example above shows you two entries for this function. The first one is the default set up thats used in most cases. Simply define the meta key and the meta value and the key will be updated if it does exist and if it does not exist, it will be created.", $translation_ident ); ?>
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "The third argument, as seen in the second entry, allows you to check against a previous value before updating. That causes that the meta value will only be updated if the previous key fits to whats currently saved within the database. Default: ''", $translation_ident ); ?>
    </li>
    <li>
        <strong><?php echo wordpress_webhooks()->helpers->translate( "delete_user_meta", $translation_ident ); ?></strong>
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "This key refers to the <strong>delete_user_meta()</strong> function of WordPress:", $translation_ident ); ?> <a title="Go to WordPress" target="_blank" href="https://developer.wordpress.org/reference/functions/delete_user_meta/">https://developer.wordpress.org/reference/functions/delete_user_meta/</a>
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "Within the example above, you will see that only the meta key is required for deleting an entry. This will cause all meta keys on this post with the same key to be deleted.", $translation_ident ); ?>
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "The second argument allows you to target only a specific meta key/value combination. This gets important if you want to target a specific meta key/value combination and not delete all available entries for the given post. Default: ''", $translation_ident ); ?>
    </li>
</ol>
<strong><?php echo wordpress_webhooks()->helpers->translate( "Some tipps:", $translation_ident ); ?></strong>
<ol>
    <li><?php echo wordpress_webhooks()->helpers->translate( "You can include the value for this argument as a simple string to your webhook payload or you integrate it directly as JSON into your JSON payload (if you send a raw JSON response).", $translation_ident ); ?></li>
    <li><?php echo wordpress_webhooks()->helpers->translate( "Changing the order of the functions within the JSON causes the user meta to behave differently. If you, for example, add the <strong>delete_user_meta</strong> key before the <strong>update_user_meta</strong> key, the meta values will first be deleted and then added/updated.", $translation_ident ); ?></li>
    <li><?php echo wordpress_webhooks()->helpers->translate( "The webhook response contains a validted array that shows each initialized meta entry, as well as the response from its original WordPress function. This way you can see if the meta value was updated accordingly.", $translation_ident ); ?></li>
</ol>
<hr>

<?php if( wordpress_webhooks()->helpers->is_plugin_active( 'advanced-custom-fields' ) ){
    wordpress_webhooks()->acf->load_acf_description( $translation_ident );
} ?>

<h5><?php echo wordpress_webhooks()->helpers->translate( "send_email", $translation_ident ); ?></h5>
<?php echo wordpress_webhooks()->helpers->translate( "In case you set the <strong>send_email</strong> argument to <strong>yes</strong>, we will send an email from this WordPress site to the user email, containing his login details.", $translation_ident ); ?>
<br>
<hr>
<h5><?php echo wordpress_webhooks()->helpers->translate( "do_action", $translation_ident ); ?></h5>
<?php echo wordpress_webhooks()->helpers->translate( "The <strong>do_action</strong> argument is an advanced webhook for developers. It allows you to fire a custom WordPress hook after the <strong>update_user</strong> action was fired.", $translation_ident ); ?>
<br>
<?php echo wordpress_webhooks()->helpers->translate( "You can use it to trigger further logic after the webhook action. Here's an example:", $translation_ident ); ?>
<br>
<br>
<?php echo wordpress_webhooks()->helpers->translate( "Let's assume you set for the <strong>do_action</strong> parameter <strong>fire_this_function</strong>. In this case, we will trigger an action with the hook name <strong>fire_this_function</strong>. Here's how the code would look in this case:", $translation_ident ); ?>
<pre>add_action( 'fire_this_function', 'my_custom_callback_function', 20, 4 );
function my_custom_callback_function( $user_data, $user_id, $user_meta, $update ){
    //run your custom logic in here
}
</pre>
<?php echo wordpress_webhooks()->helpers->translate( "Here's an explanation to each of the variables that are sent over within the custom function.", $translation_ident ); ?>
<ol>
    <li>
        <strong>$user_data</strong> (array)
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "Contains the data that is used to update the user.", $translation_ident ); ?>
    </li>
    <li>
        <strong>$user_id</strong> (integer)
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "Contains the user id of the updated user. Please note that it can also contain a wp_error object since it is the response of the wp_insert_user() function.", $translation_ident ); ?>
    </li>
    <li>
        <strong>$user_meta</strong> (string)
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "Contains the unformatted user meta as you sent it over within the webhook request as a string.", $translation_ident ); ?>
    </li>
    <li>
        <strong>$update</strong> (bool)
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "This value will be set to 'true' for the update_user webhook.", $translation_ident ); ?>
    </li>
</ol>
<hr>
<h5><?php echo wordpress_webhooks()->helpers->translate( "create_if_none", $translation_ident ); ?></h5>
<?php echo wordpress_webhooks()->helpers->translate( "In case you set the <strong>create_if_none</strong> argument to <strong>yes</strong>, a user will be created with the given details in case it does not exist.", $translation_ident ); ?>
