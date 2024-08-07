<?php

/**
 * WordPress_Webhooks_ACF Class
 *
 * This class contains all of the Advanced Custom Fields related functions
 *
 * @since 3.0.8
 */

/**
 * The api class of the plugin.
 *
 * @since 3.0.8
 * @package WW
 * @author Pullbytes <info@pullbytes.com>
 */
class WordPress_Webhooks_ACF {

	/**
	 * Add ACF specific fields using only acf features
	 *
	 * @param integer $object_id - the id of the given user
	 * @param array $meta_acf - the custom acf construct 
	 * @param integer $type - leave it at false if you want to trigger the logic on posts, otherwise customize it
	 * @return void
	 */
	public function manage_acf_meta( $object_id, $meta_acf, $type = false ){
		$return = array(
			'success' => false,
			'msg' => '',
			'data' => array(),
        );

		if( empty( $object_id ) ){
			$return['msg'] = wordpress_webhooks()->helpers->translate( 'No object id was given.', 'manage-acf-meta' );
			return $return;
		}

		if( empty( $meta_acf ) ){
			$return['msg'] = wordpress_webhooks()->helpers->translate( 'The meta_acf argument cannot be empty.', 'manage-acf-meta' );
			return $return;
		}

		if( is_string( $meta_acf ) && wordpress_webhooks()->helpers->is_json( $meta_acf ) ){
			$meta_acf = json_decode( $meta_acf, true );
		}

		
		if( empty( $meta_acf ) || ! is_array( $meta_acf ) ){
			$return['msg'] = wordpress_webhooks()->helpers->translate( 'There was an issue decoding the meta_acf JSON.', 'manage-acf-meta' );
			return $return;
        }

        //ACF required a definition based on the object type within the $object_id
        if( ! empty( $type ) ){
            $validated_object_id = sanitize_title( $type ) . '_' . intval( $object_id );
        } else {
            $validated_object_id = intval( $object_id );
        }

		foreach( $meta_acf as $function => $data ){
			switch( $function ){
				case 'add_row':

					$return['data']['add_row'] = array();

					foreach( $data as $add_row_key => $add_row_data ){
						if( isset( $add_row_data['selector'] ) && isset( $add_row_data['value'] ) ){
							$return_add_row = add_row( $add_row_data['selector'], $add_row_data['value'], $validated_object_id );

							$return['data']['add_row'][ $add_row_key ] = array(
								'selector' => $add_row_data['selector'],
								'value' => $add_row_data['value'],
								'response' => $return_add_row,
							);
						}
					}
					
				break;
				case 'add_sub_row':

					$return['data']['add_sub_row'] = array();

					foreach( $data as $add_sub_row_key => $add_sub_row_data ){
						if( isset( $add_sub_row_data['selector'] ) && isset( $add_sub_row_data['value'] ) ){
							$return_add_sub_row = add_sub_row( $add_sub_row_data['selector'], $add_sub_row_data['value'], $validated_object_id );

							$return['data']['add_sub_row'][ $add_sub_row_key ] = array(
								'selector' => $add_sub_row_data['selector'],
								'value' => $add_sub_row_data['value'],
								'response' => $return_add_sub_row,
							);
						}
					}

				break;
				case 'delete_field':

					$return['data']['delete_field'] = array();

					foreach( $data as $delete_field_key => $delete_field_data ){
						if( isset( $delete_field_data['selector'] ) ){
							$return_delete_field = delete_field( $delete_field_data['selector'], $validated_object_id );

							$return['data']['delete_field'][ $delete_field_key ] = array(
								'selector' => $delete_field_data['selector'],
								'response' => $return_delete_field,
							);
						}
					}

				break;
				case 'delete_row':

					$return['data']['delete_row'] = array();

					foreach( $data as $delete_row_key => $delete_row_data ){
						if( isset( $delete_row_data['selector'] ) && isset( $delete_row_data['row'] ) ){
							$return_delete_row = delete_row( $delete_row_data['selector'], $delete_row_data['row'], $validated_object_id );

							$return['data']['delete_row'][ $delete_row_key ] = array(
								'selector' => $delete_row_data['selector'],
								'row' => $delete_row_data['row'],
								'response' => $return_delete_row,
							);
						}
					}

				break;
				case 'delete_sub_field':

					$return['data']['delete_sub_field'] = array();

					foreach( $data as $delete_sub_field_key => $delete_sub_field_data ){
						if( isset( $delete_sub_field_data['selector'] ) ){
							$return_delete_sub_field = delete_sub_field( $delete_sub_field_data['selector'], $validated_object_id );

							$return['data']['delete_sub_field'][ $delete_sub_field_key ] = array(
								'selector' => $delete_sub_field_data['selector'],
								'response' => $return_delete_sub_field,
							);
						}
					}

				break;
				case 'delete_sub_row':

					$return['data']['delete_sub_row'] = array();

					foreach( $data as $delete_sub_row_key => $delete_sub_row_data ){
						if( isset( $delete_sub_row_data['selector'] ) && isset( $delete_sub_row_data['row'] ) ){
							$return_delete_sub_row = delete_sub_row( $delete_sub_row_data['selector'], $delete_sub_row_data['row'], $validated_object_id );

							$return['data']['delete_sub_row'][ $delete_sub_row_key ] = array(
								'selector' => $delete_sub_row_data['selector'],
								'row' => $delete_sub_row_data['row'],
								'response' => $return_delete_sub_row,
							);
						}
					}

				break;
				case 'update_field':

					$return['data']['update_field'] = array();

					foreach( $data as $update_field_key => $update_field_data ){
						if( isset( $update_field_data['selector'] ) && isset( $update_field_data['value'] ) ){
							$return_update_field = update_field( $update_field_data['selector'], $update_field_data['value'], $validated_object_id );

							$return['data']['update_field'][ $update_field_key ] = array(
								'selector' => $update_field_data['selector'],
								'value' => $update_field_data['value'],
								'response' => $return_update_field,
							);
						}
					}

				break;
				case 'update_row':

					$return['data']['update_row'] = array();

					foreach( $data as $update_row_key => $update_row_data ){
						if( isset( $update_row_data['selector'] ) && isset( $update_row_data['row'] ) && isset( $update_row_data['value'] ) ){
							$return_update_row = update_row( $update_row_data['selector'], $update_row_data['row'], $update_row_data['value'], $validated_object_id );

							$return['data']['update_row'][ $update_row_key ] = array(
								'selector' => $update_row_data['selector'],
								'row' => $update_row_data['row'],
								'value' => $update_row_data['value'],
								'response' => $return_update_row,
							);
						}
					}

				break;
				case 'update_sub_field':

					$return['data']['update_sub_field'] = array();

					foreach( $data as $update_sub_field_key => $update_sub_field_data ){
						if( isset( $update_sub_field_data['selector'] ) && isset( $update_sub_field_data['value'] ) ){
							$return_update_sub_field = update_sub_field( $update_sub_field_data['selector'], $update_sub_field_data['value'], $validated_object_id );

							$return['data']['update_sub_field'][ $update_sub_field_key ] = array(
								'selector' => $update_sub_field_data['selector'],
								'value' => $update_sub_field_data['value'],
								'response' => $return_update_sub_field,
							);
						}
					}

				break;
				case 'update_sub_row':

					$return['data']['update_sub_row'] = array();

					foreach( $data as $update_sub_row_key => $update_sub_row_data ){
						if( isset( $update_sub_row_data['selector'] ) && isset( $update_sub_row_data['row'] ) && isset( $update_sub_row_data['value'] ) ){
							$return_update_sub_row = update_sub_row( $update_sub_row_data['selector'], $update_sub_row_data['row'], $update_sub_row_data['value'], $validated_object_id );

							$return['data']['update_sub_row'][ $update_sub_row_key ] = array(
								'selector' => $update_sub_row_data['selector'],
								'row' => $update_sub_row_data['row'],
								'value' => $update_sub_row_data['value'],
								'response' => $return_update_sub_row,
							);
						}
					}

				break;
			}
		}

		$return['success'] = true;
		$return['msg'] = wordpress_webhooks()->helpers->translate( 'The given ACF data has been successfully executed.', 'manage-acf-meta' );

		return $return;
	}

public function load_acf_description( $identifier = '' ){
?>
<h5><?php echo wordpress_webhooks()->helpers->translate( "manage_acf_data", $identifier ); ?></h5>
<?php echo wordpress_webhooks()->helpers->translate( "This argument integrates this endpoint with ", $identifier ); ?><a target="_blank" title="Advanced Custom Fields" href="https://www.advancedcustomfields.com/">Advanced Custom Fields</a>.
<br>
<br>
<?php echo wordpress_webhooks()->helpers->translate( "<strong>Please note</strong>: This argument is very powerful and requires some good understanding of JSON. It is integrated with all Update functions offered by ACF. You can find a list of all update functions here: ", $identifier ); ?>
<a href="https://www.advancedcustomfields.com/resources/#functions" target="_blank">https://www.advancedcustomfields.com/resources/#functions</a>
<br>
<?php echo wordpress_webhooks()->helpers->translate( "Down below you will find some examples that show you how to use each of the functions.", $identifier ); ?>
<br>
<br>
<?php echo wordpress_webhooks()->helpers->translate( "This argument accepts a validated JSON construct as an input. This construct contains each available function within its top layers and the assigned data respectively as a value. If you want to learn more about each line, please take a closer look at the bottom of the example.", $identifier ); ?>
<br>
<?php echo wordpress_webhooks()->helpers->translate( "Down below you will find a list that explains each of the top level keys including an example.", $identifier ); ?>
<ol>
    <li>
        <strong><?php echo wordpress_webhooks()->helpers->translate( "add_row", $identifier ); ?></strong>
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "This key refers to the <strong>add_row()</strong> function of ACF:", $identifier ); ?> <a title="Go to Advanced Custom Fields" target="_blank" href="https://www.advancedcustomfields.com/resources/add_row">https://www.advancedcustomfields.com/resources/add_row</a>
<pre>
{
    "add_row": [
      {
        "selector": "demo_repeater",
        "value": {
          "demo_repeater_field": "This is the first text",
          "demo_repeater_url": "https://someurl1.com"
        }
      },
      {
        "selector": "demo_repeater",
        "value": {
          "demo_repeater_field": "This is the second text",
          "demo_repeater_url": "https://someurl2.com"
        }
      }
    ]
}
</pre>
        <?php echo wordpress_webhooks()->helpers->translate( "The example value for this key above shows you on how you can add multiple keys and values using the <strong>add_row()</strong> function. To make it work, you can add an array within the given construct, using the <strong>selector</strong> key for the key of the repeater field and the <strong>value</strong> key for the actual row data. Please note that the value for the row data must be an array using the seen JSON notation (Do not simply include a string). The value for the given example will add a new row to the <strong>demo_repeater_content</strong> repeater field which includes a sub field called <strong>demo_repeater_child_field</strong> and another sub field called <strong>demo_repeater_child_url</strong>.", $identifier ); ?>
    </li>
    <li>
        <strong><?php echo wordpress_webhooks()->helpers->translate( "add_sub_row", $identifier ); ?></strong>
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "This key refers to the <strong>add_sub_row()</strong> function of ACF:", $identifier ); ?> <a title="Go to Advanced Custom Fields" target="_blank" href="https://www.advancedcustomfields.com/resources/add_sub_row">https://www.advancedcustomfields.com/resources/add_sub_row</a>
<pre>
{
    "add_sub_row": [
      {
        "selector": [
          "demo_repeater_content", 1, "sub_repeater"
        ],
        "value": {
          "sub_repeater_field": "Sub Repeater Text Value"
        }
      }
    ]
}
</pre>
        <?php echo wordpress_webhooks()->helpers->translate( "Within the example above, you will see how you can add a row to a sub row (e.g. if the repeater field as also a repeater field). The <strong>selector</strong> key can contain a string or an array that determins the exact position of the sub row. You can see the value for the <strong>selector</strong> key as a mapping to the sub row. The <strong>value</strong> key can contain a string or an array, depending on the choice of the field.", $identifier ); ?>
    </li>
    <li>
        <strong><?php echo wordpress_webhooks()->helpers->translate( "delete_field", $identifier ); ?></strong>
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "This key refers to the <stro>delete_field()</strong> function of ACF:", $identifier ); ?> <a title="Go to Advanced Custom Fields" target="_blank" href="https://www.advancedcustomfields.com/resources/delete_field">https://www.advancedcustomfields.com/resources/delete_field</a>
<pre>
{
    "delete_field": [
      {
        "selector": "demo_field"
      }
    ]
}
</pre>
        <?php echo wordpress_webhooks()->helpers->translate( "To delete a field, you can use the same notation as seen above in the example. Simply add another row to the JSON including the field name, of the field you want to delete, into the <strong>selector</strong> key. This will cause the field to be deleted. You can also use this function to clear repeater fields.", $identifier ); ?>
    </li>
    <li>
        <strong><?php echo wordpress_webhooks()->helpers->translate( "delete_row", $identifier ); ?></strong>
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "This key refers to the <strong>delete_row()</strong> function of ACF:", $identifier ); ?> <a title="Go to Advanced Custom Fields" target="_blank" href="https://www.advancedcustomfields.com/resources/delete_row/">https://www.advancedcustomfields.com/resources/delete_row/</a>
<pre>
{
    "delete_row": [
      {
        "selector": "demo_repeater_row",
        "row": 2
      }
    ]
}
</pre>
        <?php echo wordpress_webhooks()->helpers->translate( "The example above shows that the logic is going to delete the second row for the <strong>demo_repeater_content</strong> repeater field. You can also see that we send over the numeric value for the row which is required by ACF.", $identifier ); ?>
    </li>
    <li>
        <strong><?php echo wordpress_webhooks()->helpers->translate( "delete_sub_field", $identifier ); ?></strong>
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "This key refers to the <strong>delete_sub_field()</strong> function of ACF:", $identifier ); ?> <a title="Go to Advanced Custom Fields" target="_blank" href="https://www.advancedcustomfields.com/resources/delete_sub_field/">https://www.advancedcustomfields.com/resources/delete_sub_field/</a>
<pre>
{
    "delete_sub_field": [
      {
        "selector": [
          "demo_repeater", 2, "sub_repeater", 2, "sub_repeater_field"
        ]
      }
    ]
}
</pre>
        <?php echo wordpress_webhooks()->helpers->translate( "This allows you to delete a specific field within a repeater, flexible content or sub-repeater, etc.. To make it work, you must need to set the <strong>selector</strong> key as an array containing the given mapping of the field you'd like to delete. The example deletes a fiel of a sub-repeater.", $identifier ); ?>
    </li>
    <li>
        <strong><?php echo wordpress_webhooks()->helpers->translate( "delete_sub_row", $identifier ); ?></strong>
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "This key refers to the <strong>delete_sub_row()</strong> function of ACF:", $identifier ); ?> <a title="Go to Advanced Custom Fields" target="_blank" href="https://www.advancedcustomfields.com/resources/delete_sub_row/">https://www.advancedcustomfields.com/resources/delete_sub_row/</a>
<pre>
{
    "delete_sub_row": [
      {
        "selector": [
          "demo_repeater", 2, "sub_repeater"
        ],
        "row": 2
      }
    ]
}
</pre>
        <?php echo wordpress_webhooks()->helpers->translate( "Delete the whole row of a sub-repeater field or flexible content. For the <strong>selector</strong> key you must define an array (as seen in the example) that contains the exact mapping of the repeater/flexible field you want to target. As for the <strong>row</strong> key, you must set the number of the row you want to delete.", $identifier ); ?>
    </li>
    <li>
        <strong><?php echo wordpress_webhooks()->helpers->translate( "update_field", $identifier ); ?></strong>
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "This key refers to the <strong>update_field()</strong> function of ACF:", $identifier ); ?> <a title="Go to Advanced Custom Fields" target="_blank" href="https://www.advancedcustomfields.com/resources/update_field">https://www.advancedcustomfields.com/resources/update_field</a>
<pre>
{
    "update_field":[
      {
        "selector": "first_custom_key",
        "value": "Some custom value"
      },
      {
        "selector": "second_custom_key",
        "value": { "some_array_key": "Some array Value" }
      } 
    ]
}
</pre>
        <?php echo wordpress_webhooks()->helpers->translate( "The example value for this key above shows you on how you can add multiple keys and values using the <strong>update_field()</strong> function. To make it work, you can add an array within the given construct, using the <strong>selector</strong> key for the post meta key and the <strong>value</strong> key for the actual value. The example also shows on how you can include an array. To make that work, you can simply create a sub entry for the value instead of a simple string as seen in the second example.", $identifier ); ?>
    </li>
    <li>
        <strong><?php echo wordpress_webhooks()->helpers->translate( "update_row", $identifier ); ?></strong>
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "This key refers to the <strong>update_row()</strong> function of ACF:", $identifier ); ?> <a title="Go to Advanced Custom Fields" target="_blank" href="https://www.advancedcustomfields.com/resources/update_row">https://www.advancedcustomfields.com/resources/update_row</a>
<pre>
{
    "update_row":[
      {
        "selector": "demo_repeater",
        "row": 2,
        "value": {
          "demo_repeater_field": "New Demo Text",
          "demo_repeater_url": "https://somenewurl.com"
        }
      }
    ]
}
</pre>
        <?php echo wordpress_webhooks()->helpers->translate( "Using the update_row() function, you can update specific or all fields of that given row. To do so, simply define the repeater/flexible content field name afor the <strong>selector</strong> key, the row number for the <strong>row</strong> key and for the <strong>value</strong> key the array containing all of your required fields you want to update.", $identifier ); ?>
    </li>
    <li>
        <strong><?php echo wordpress_webhooks()->helpers->translate( "update_sub_field", $identifier ); ?></strong>
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "This key refers to the <strong>update_sub_field()</strong> function of ACF:", $identifier ); ?> <a title="Go to Advanced Custom Fields" target="_blank" href="https://www.advancedcustomfields.com/resources/update_sub_field">https://www.advancedcustomfields.com/resources/update_sub_field</a>
<pre>
{
    "update_sub_field":[
      {
        "selector": [
          "demo_repeater", 2, "sub_repeater", 1, "sub_repeater_field"
        ],
        "value": "Some New Text"
      }
    ]
}
</pre>
        <?php echo wordpress_webhooks()->helpers->translate( "Use this function if your goal is to update a specific, nested field within a repeater/flexible content. As for the <strong>selector</strong> key, you need to set an array containing the exact mapping position to target the exact field you would like to update. As for the <strong>value</strong>, you can define the content of the field.", $identifier ); ?>
    </li>
    <li>
        <strong><?php echo wordpress_webhooks()->helpers->translate( "update_sub_row", $identifier ); ?></strong>
        <br>
        <?php echo wordpress_webhooks()->helpers->translate( "This key refers to the <strong>update_sub_row()</strong> function of ACF:", $identifier ); ?> <a title="Go to Advanced Custom Fields" target="_blank" href="https://www.advancedcustomfields.com/resources/update_sub_row">https://www.advancedcustomfields.com/resources/update_sub_row</a>
<pre>
{
    "update_sub_row":[
      {
        "selector": [
          "demo_repeater", 2, "sub_repeater"
        ],
        "row": 2,
        "value": {
          "sub_repeater_field": "Updated Sub Row Text"
        }
      }
    ]
}
</pre>
        <?php echo wordpress_webhooks()->helpers->translate( "With this function, you can update a whole row within a repeater/flecible content field. To make it work, please define for the <strong>selector</strong> key an array contianing the exact mapping to target the row you want to update. For the <strong>row</strong> key, please specify the row within the sub field. As for the <strong>value</strong>, please include an array containing all single fields you would like to update.", $identifier ); ?>
    </li>
</ol>
<strong><?php echo wordpress_webhooks()->helpers->translate( "Some tipps:", $identifier ); ?></strong>
<ol>
    <li>
        <?php echo wordpress_webhooks()->helpers->translate( "You can combine all of the functions within a single JSON such as:", $identifier ); ?>
<pre>
{
    "update_field": {},
    "update_row": {},
    "update_sub_field": {},
    "update_sub_row": {}
}
</pre>
    </li>
    <li><?php echo wordpress_webhooks()->helpers->translate( "You can include the value for this argument as a simple string to your webhook payload or you integrate it directly as JSON into your JSON payload (if you send a raw JSON response).", $identifier ); ?></li>
    <li><?php echo wordpress_webhooks()->helpers->translate( "Changing the order of the functions within the JSON causes the added values behave differently. If you, for example, add the <strong>delete_field</strong> key before the <strong>update_field</strong> key, the fields will first be deleted and then added/updated.", $identifier ); ?></li>
    <li><?php echo wordpress_webhooks()->helpers->translate( "The webhook response contains a validted array that shows each initialized meta entry, as well as the response from its original ACF function. This way you can see if the meta value was adjusted accordingly.", $identifier ); ?></li>
</ol>
<hr>
<?php
}

}
