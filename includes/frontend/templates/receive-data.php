<?php
$custom_webhooks = wordpress_webhooks()->webhook->get_hooks( 'action' ) ;
$current_url = wordpress_webhooks()->helpers->get_current_url(false);
$clear_form_url = wordpress_webhooks()->helpers->get_current_url();
$action_nonce_data = wordpress_webhooks()->settings->get_action_nonce();
$actions = wordpress_webhooks()->webhook->get_actions();


?>
<div class="d-flex flex-column">

	<div class="d-flex justify-content-between">
		<div class="ww_receivedata--text">
			<h2 class=""><?php echo wordpress_webhooks()->helpers->translate( 'Recevie Data To WordPress Webhooks', 'ww-page-triggers' ); ?></h2>
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

	<div class="alert ww_alert"></div>

	<form class=" d-flex align-items-center">
		
		<div class="form-group mb-0 mr-4">

			
			<input type="text" class="ww_input mb-4 mt-4 form-control" id="ww_webook--action" placeholder=<?php echo "'".wordpress_webhooks()->helpers->translate( 'Enter webhook name', 'ww-page-triggers' )."'"; ?> required>
			
			
		</div>
		
		<button type="submit" id="ww_create--action" class="btn btn-primary ">Create Webhook</button>
	</form>



<form action="" class="ww_search--form d-flex">
	<div class="d-flex align-items-center">
		<input type="text" class="ww_input--sm mb-4 mt-4 form-control" id="ww_search--term" placeholder=<?php echo "'".wordpress_webhooks()->helpers->translate( 'Search webhooks...', 'ww-page-triggers' )."'"; ?> required>
		<svg class="ww_send--icon" xmlns="http://www.w3.org/2000/svg" width="10.102" height="10.102" viewBox="0 0 10.102 10.102">
			<path id="Icon_open-magnifying-glass" data-name="Icon open-magnifying-glass" d="M4.38-.032a4.38,4.38,0,1,0,0,8.76,4.329,4.329,0,0,0,2.077-.513,1.251,1.251,0,0,0,.163.163L7.871,9.628a1.276,1.276,0,1,0,1.8-1.8L8.422,6.575a1.251,1.251,0,0,0-.2-.163,4.321,4.321,0,0,0,.551-2.077,4.385,4.385,0,0,0-4.38-4.38Zm0,1.251A3.114,3.114,0,0,1,7.508,4.347,3.138,3.138,0,0,1,6.682,6.5l-.038.038a1.251,1.251,0,0,0-.163.163,3.131,3.131,0,0,1-2.115.788,3.128,3.128,0,0,1,0-6.257Z" transform="translate(0 0.045)" fill="#395ff5"/>
		</svg>

	</div>
	
</form>



<table class="ww_receive--table table">
  <thead class="thead-dark">
	<tr>
		<th style="width:10%" scope="col">Webhook Name</th>
		<th style="width:40%" scope="col">Webhook Url</th>
		<th style="width:30%" scope="col">Api Key</th>
		<th style="width:20%" scope="col">Actions</th>
	</tr>
  </thead>
  <tbody class="tbody"></tbody>
</table>

<div class="ww_modal">
	<div class="ww_modal--overlay"></div>
	
	<div class="ww_modal--body">
	
		<svg class="ww_modal--close" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 20.177 20.177"><path d="M13.463,3.375A10.088,10.088,0,1,0,23.552,13.463,10.087,10.087,0,0,0,13.463,3.375Zm2.556,13.741L13.463,14.56l-2.556,2.556a.775.775,0,1,1-1.1-1.1l2.556-2.556L9.811,10.907a.775.775,0,1,1,1.1-1.1l2.556,2.556,2.556-2.556a.775.775,0,0,1,1.1,1.1L14.56,13.463l2.556,2.556a.779.779,0,0,1,0,1.1A.77.77,0,0,1,16.019,17.116Z" transform="translate(-3.375 -3.375)" fill="#707070"/></svg>
		
		<div class="ww_modal--1">
			<h4 class="ww_modal--heading mb-4">Available Webhooks Triggers</h4>

			<p class="ww_modal--text">Use the webhook URL down below to connect your external service with your site. This URL receives data from external endpoints and does certain actions on your WordPress site. Please note, that deleting the default main webhook creates automatically a new one. If you need more information, check out the installation and documentation by clicking here.</p>

			<ul class="ww_triggers--list">
			<?php foreach( $actions as $identkey => $action ) {

				$action_name = !empty( $action['name'] ) ? $action['name'] : $action['action'];
				$webhook_name = !empty( $action['action'] ) ? $action['action'] : '';
				$action_callback = !empty( $action['callback'] ) ? $action['callback'] : '';
			?>

				<li class="ww_triggers--items">
					<a href="#" class="ww_actions--links" id=<?php echo $webhook_name;?>><?php echo $webhook_name;?></a>
					
				</li>

			<?php } ?>
			</ul>
		</div>

		<div class="ww_modal--2">
			<div class="ww_tabs">
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item waves-effect waves-light">
						<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false">Outgoing Values</a>
					</li>
					<li class="nav-item waves-effect waves-light">
						<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Description</a>
					</li>

					<li class="nav-item waves-effect waves-light">
						<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Return Values</a>
					</li>

					<li class="nav-item waves-effect waves-light">
						<a class="nav-link" id="profile-tab" data-toggle="tab" href="#test" role="tab" aria-controls="test" aria-selected="false">Test Action</a>
					</li>
					
				</ul>

				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
						loading...
					</div>

					<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="home-tab">
						loading...
					</div>

					

					<div class="tab-pane fade" id="test" role="tabpanel" aria-labelledby="test-tab">
						<form method="post" target="_blank" class="ww_test--form">
							<select type="text" class="ww_input--sm mb-4 mt-4 form-control" id="ww_test--webhook" placeholder=<?php echo "'".wordpress_webhooks()->helpers->translate( 'Filter by trigger', 'ww-page-triggers' )."'"; ?>>
								<option  value="">Select webhook</option>
								<?php foreach( $custom_webhooks as $custom_webhook  => $value) {
									
								$webhook_name = !empty( $custom_webhook ) ? $custom_webhook : '';
								$webhook_url = $value['webhook_url'];
								?>
								<option value="<?php echo $webhook_url."&ww_direct_test=1"; ?>"><?php echo $webhook_name; ?></option>
								<?php } ?>
							</select>

							<select type="text" class="ww_input--sm mb-4 mt-4 form-control" id="ww_test--action" name="action" placeholder=<?php echo "'".wordpress_webhooks()->helpers->translate( 'Filter by trigger', 'ww-page-triggers' )."'"; ?>>
								<option  value="">Select action</option>
								<?php foreach( $actions as $identkey => $action ) {

								$webhook_name = !empty( $action['action'] ) ? $action['action'] : '';
								?>
								<option value="<?php echo $webhook_name; ?>"><?php echo $webhook_name; ?></option>
								<?php } ?>
							</select>
								<div class="ww_parameter--group"></div>

								<input type="submit" class="btn btn-primary" value="Test">

						</form>
					</div>
				</div>
                
			</div>
		</div>
	</div>

	
</div>

	
	
	
	