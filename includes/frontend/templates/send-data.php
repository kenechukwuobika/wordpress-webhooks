<?php
$triggers = wordpress_webhooks()->webhook->get_triggers();
$custom_webhooks = wordpress_webhooks()->webhook->get_hooks( 'trigger' );
uasort($custom_webhooks, function ($a, $b){			
	return strcasecmp($b['date_created'], $a['date_created']);
});
$current_url = wordpress_webhooks()->helpers->get_current_url(false);
$current_url_full = wordpress_webhooks()->helpers->get_current_url();
$data_mapping_templates = wordpress_webhooks()->data_mapping->get_data_mapping();
$authentication_templates = wordpress_webhooks()->auth->get_auth_templates();

?>
<div class="d-flex flex-column">

	<div class="d-flex justify-content-between mb-4">
		<div class="ww_senddata--text">
			<h2 class=""><?php echo wordpress_webhooks()->helpers->translate( 'Create A Webhook Trigger', 'ww-page-triggers' ); ?></h2>
			<div class="main-description">
				<?php if( wordpress_webhooks()->whitelabel->is_active() && ! empty( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_text_send_data' ) ) ) : ?>
					<?php echo wordpress_webhooks()->helpers->translate( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_text_send_data' ), 'admin-settings-license' ); ?>
				<?php else : ?>
					
					<?php echo sprintf( wordpress_webhooks()->helpers->translate( 'Use the webhook URL down below to connect your external service with your site. This URL receives data from external endpoints and does certain actions on your WordPress site. Please note, that deleting the default main webhook creates automatically a new one. If you need more information, check out the installation and documentation by clicking here.' ), '<strong>' . $this->page_title . '</strong>', 'https://ironikus.com/docs/?utm_source=wp-webhooks-pro&utm_medium=send-data-documentation&utm_campaign=WP%20Webhooks%20Pro'); ?>
				<?php endif; ?>

			</div>
		</div>
		<svg class="ww_doc--help" xmlns="http://www.w3.org/2000/svg" width="23.5" height="23.5" viewBox="0 0 23.5 23.5"><path d="M24.063,12.313A11.75,11.75,0,1,1,12.313.563,11.749,11.749,0,0,1,24.063,12.313ZM12.628,4.448A6.137,6.137,0,0,0,7.106,7.468a.569.569,0,0,0,.129.77L8.878,9.485a.568.568,0,0,0,.79-.1c.846-1.074,1.427-1.7,2.715-1.7.968,0,2.165.623,2.165,1.562,0,.71-.586,1.074-1.541,1.61-1.115.625-2.589,1.4-2.589,3.348v.19a.569.569,0,0,0,.569.569h2.653a.569.569,0,0,0,.569-.569v-.063c0-1.349,3.941-1.4,3.941-5.054C18.149,6.532,15.3,4.448,12.628,4.448ZM12.313,16.2a2.179,2.179,0,1,0,2.179,2.179A2.182,2.182,0,0,0,12.313,16.2Z" transform="translate(-0.563 -0.563)" fill="#5643fa"/></svg>
	</div>

	<form class="mb-4">
		<div class="form-group">

			<div class="dropdown">
				<button class="ww_input dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<?php echo wordpress_webhooks()->helpers->translate( 'Select a trigger', 'ww-page-triggers' ); ?>
				</button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<?php foreach( $triggers as $identkey => $trigger ) {

					$trigger_name = !empty( $trigger['name'] ) ? $trigger['name'] : $trigger['trigger'];
					$webhook_name = !empty( $trigger['trigger'] ) ? $trigger['trigger'] : '';
					$trigger_callback = !empty( $trigger['callback'] ) ? $trigger['callback'] : '';
				?>

					<div id="webhook" data-ww-callback=<?php echo $trigger_callback; ?> class="ww_input--item dropdown-item" >
						<span><?php echo $webhook_name?></span>
						<small id="webhook" class="form-text text-muted"><?php echo $trigger_name?></small>
					</div>

				<?php }?>
				
				</div>	
			</div>

			<input type="text" class="ww_input mb-4 mt-4 form-control" id="webhook-name" placeholder=<?php echo "'".wordpress_webhooks()->helpers->translate( 'Enter webhook name', 'ww-page-triggers' )."'"; ?> required>
			
			<input type="text" class="ww_input mb-4 form-control" id="webhook-url" placeholder=<?php echo "'".wordpress_webhooks()->helpers->translate( 'Enter webhook url', 'ww-page-triggers' )."'"; ?> required>

			
		</div>
		<!-- <div class="form-group">
			<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
		</div> -->
		
		<button id="ww_submit" type="submit" class="btn btn-primary">Add trigger</button>
	</form>



<form action="" class="ww_send--filter d-flex">
	<div class="d-flex align-items-center">
		<input type="text" class="ww_input--sm mb-4 mt-4 form-control" id="" placeholder=<?php echo "'".wordpress_webhooks()->helpers->translate( 'Search webhooks...', 'ww-page-triggers' )."'"; ?> required>
		<svg class="ww_send--icon" xmlns="http://www.w3.org/2000/svg" width="10.102" height="10.102" viewBox="0 0 10.102 10.102">
			<path id="Icon_open-magnifying-glass" data-name="Icon open-magnifying-glass" d="M4.38-.032a4.38,4.38,0,1,0,0,8.76,4.329,4.329,0,0,0,2.077-.513,1.251,1.251,0,0,0,.163.163L7.871,9.628a1.276,1.276,0,1,0,1.8-1.8L8.422,6.575a1.251,1.251,0,0,0-.2-.163,4.321,4.321,0,0,0,.551-2.077,4.385,4.385,0,0,0-4.38-4.38Zm0,1.251A3.114,3.114,0,0,1,7.508,4.347,3.138,3.138,0,0,1,6.682,6.5l-.038.038a1.251,1.251,0,0,0-.163.163,3.131,3.131,0,0,1-2.115.788,3.128,3.128,0,0,1,0-6.257Z" transform="translate(0 0.045)" fill="#395ff5"/>
		</svg>

	</div>
	
	<input type="text" class="ww_input--sm mb-4 mt-4 form-control" id="" placeholder=<?php echo "'".wordpress_webhooks()->helpers->translate( 'Filter by trigger', 'ww-page-triggers' )."'"; ?> required>
	<input id="ww-current-url" type="hidden" value="<?php echo $current_url_full; ?>" />
</form>



<table class="table ww_send--table">
  <thead class="thead-dark">
	<tr>
		<th scope="col">Webhook Name</th>
		<th scope="col">Webhook url</th>
		<th scope="col">Trigger</th>
		<th scope="col">Actions</th>
	</tr>
  </thead>
  <tbody>
    
	<?php 
		foreach ($custom_webhooks as $custom_webhook => $value){ 
	?>
	
		<tr id=<?php echo $value['webhook_name'].'-'.$custom_webhook; ?>>
			<th scope="row"><?php echo $custom_webhook; ?></th>
			<td><?php echo $value['webhook_url'];?></td>
			<td><?php echo $value['webhook_name'];?></td>
			<td>
				<a href="#" class="btn btn-primary">demo</a>
				<a href="#" class="btn btn-danger">delete</a>
				<a href="#" class="btn btn-primary">deactivate</a>
				<a href="#" class="btn btn-primary">settings</a>
			</td>
		</tr>

	<?php
		};
	?>

  </tbody>
</table>



	
	
	
	