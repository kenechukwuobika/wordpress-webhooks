<?php

/*
 * Settings Template
 */

$settings = wordpress_webhooks()->settings->get_settings();
$triggers = wordpress_webhooks()->webhook->get_triggers( false );
$actions = wordpress_webhooks()->webhook->get_actions( false );
$active_webhooks = wordpress_webhooks()->settings->get_active_webhooks();
$current_url_full = wordpress_webhooks()->helpers->get_current_url();



if( did_action( 'ww_settings_saved' ) ){
	echo wordpress_webhooks()->helpers->create_admin_notice( 'The settings are successfully updated. Please refresh the page.', 'success', true );
}

?>

<div class="ww_tabs--settings">
	<ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
		<li class="nav-item waves-effect waves-light">
			<a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="home" aria-selected="false">General Settings</a>
		</li>
		<li class="nav-item waves-effect waves-light">
			<a class="nav-link" id="send-tab" data-toggle="tab" href="#send" role="tab" aria-controls="profile" aria-selected="false">Send Data Actions</a>
		</li>
		<li class="nav-item waves-effect waves-light">
			<a class="nav-link" id="receive-tab" data-toggle="tab" href="#receive" role="tab" aria-controls="profile" aria-selected="false">Receive Data Actions</a>
		</li>
		
	</ul>

	<div class="tab-content" id="myTabContent">
		<div class="tab-pane fade active show" id="general" role="tabpanel" aria-labelledby="general-tab">
		

		
			<h4>General Settings</h4>

			<p>Here you can configure the global settings for our plugin, enable certain features to extend the possibilities for your site, and activate your available webhook actions and triggers.</p>

			<form action="" method="post" id="ww_form--general" class="d-flex flex-column align-items-center">
			
				<div class="table-responsive">
					<table class="ww_settings--table table">
						<thead class="thead-dark">
							<tr>
								<th scope="col">Action</th>
								<th scope="col">Title</th>
								<th scope="col">Description</th>
							</tr>
						</thead>
						<tbody>
							
							<?php 
								foreach ($settings as $setting => $setting_value){ 
									$is_checked = ( $setting_value['type'] == 'checkbox' && $setting_value['value'] == 'yes' ) ? 'checked' : '';
									$value = ( $setting_value['type'] != 'checkbox' ) ? $setting_value['value'] : '1';
									$is_checkbox = ( $setting_value['type'] == 'checkbox' ) ? true : false;
									if($setting_value['label'] === 'Activate Whitelist' || $setting_value['label'] === 'Activate Data Mapping' || $setting_value['label'] === 'Activate Logs'){
										continue;
									}
							?>
							
								<tr>
									<td>
									<?php if( $is_checkbox ) : ?>
										
									<label class="switch ">
										<input id="<?php echo $setting_value['id']; ?>" class="default primary" name="<?php echo $setting; ?>" type="<?php echo $setting_value['type']; ?>" class="regular-text" value="<?php echo $value; ?>" <?php echo $is_checked; ?> />
										<span class="slider round"></span>
									</label>
									<?php else : ?>
										<input id="<?php echo $setting_value['id']; ?>" name="<?php echo $setting; ?>" type="<?php echo $setting_value['type']; ?>" class="regular-text" value="<?php echo $value; ?>" <?php echo $is_checked; ?> />
									<?php endif; ?>
									</td>
									<th scope="row"><?php echo $setting_value['label']; ?></th>
									<td><?php echo $setting_value['description'];?></td>
									
								</tr>

							<?php
								};
							?>

						</tbody>
					</table>
				</div>

				<!-- <input type="submit" data-keiks="keiks" id="ww_btn--general" value="Save Settings" class="ww_btn ww_form--btn"> -->

				<button data-keiks="keiks" id="ww_btn--general" class="ww_btn ww_form--btn">
					<span class="ww_btn--text">Save Settings</span>
					<svg class="ww_btn--icon" xmlns="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/1999/xlink" width='50' height='50' viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
						
						<circle cx="50" cy="50" r="24" stroke-width="6" stroke="#fff" stroke-dasharray="50.26548245743669 50.26548245743669" fill="none" stroke-linecap="round">
						<animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1.5s" keyTimes="0;1" values="0 50 50;360 50 50"/>
						</circle>
					</svg>
				</button>

				

				

			</form>

			<div class="mt-4 d-flex justify-content-center ww_alert alert alert-success">General Settings successfully updated</div>

			
		</div>

		<div class="tab-pane fade" id="send" role="tabpanel" aria-labelledby="send-tab">
			<h4>Activate "Send Data" Triggers</h4>

			<p>Here you can configure the send data settings for our plugin, enable certain features to extend the possibilities for your site, and activate your available webhook actions and triggers.</p>

			<form action="" method="post" id="ww_form--trigger" class="d-flex flex-column align-items-center">
				<table class="ww_settings--table table">
					<thead class="thead-dark">
						<tr>
							<th scope="col">Action</th>
							<th scope="col">Title</th>
							<th scope="col">Description</th>
						</tr>
					</thead>
					<tbody>
						
						<?php 
							foreach ($triggers as $trigger => $trigger_value){ 
								$is_checked = isset( $active_webhooks['triggers'][ $trigger_value['trigger'] ] ) ?  'checked' : '';
						?>
						
							<tr>
								<td>
								<label class="switch ">
									<input id="ww_<?php echo $trigger_value['trigger']; ?>" class="default primary" name="ww_<?php echo $trigger_value['trigger']; ?>" 
									type="checkbox" 
									class="regular-text" value="<?php echo $value; ?>" <?php echo $is_checked; ?> $is_checked />
									<span class="slider"></span>
								</label>
								
								</td>
								<th scope="row"><?php echo $trigger_value['name']; ?></th>
								<td><?php echo $trigger_value['short_description'];?></td>
								
							</tr>

						<?php
							};
						?>

					</tbody>
				</table>

				<button data-keiks="keiks" id="ww_btn--general" class="ww_btn ww_form--btn">
					<span class="ww_btn--text">Save Settings</span>
					<svg class="ww_btn--icon" xmlns="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/1999/xlink" width='50' height='50' viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
						
						<circle cx="50" cy="50" r="24" stroke-width="6" stroke="#fff" stroke-dasharray="50.26548245743669 50.26548245743669" fill="none" stroke-linecap="round">
						<animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1.5s" keyTimes="0;1" values="0 50 50;360 50 50"/>
						</circle>
					</svg>
				</button>

			</form>

			<div class="mt-4 d-flex justify-content-center ww_alert alert alert-success">Trigger Settings successfully updated</div>

			
		</div>

		<div class="tab-pane fade" id="receive" role="tabpanel" aria-labelledby="receive-tab">
			<h4>Activate "Receive Data" Actions</h4>

			<p>Here you can configure the send data settings for our plugin, enable certain features to extend the possibilities for your site, and activate your available webhook actions and triggers.</p>

			<form action="" method="post" id="ww_form--action" class="d-flex flex-column align-items-center">
				<table class="ww_settings--table table ">
					<thead class="thead-dark">
						<tr>
							<th scope="col">Action</th>
							<th scope="col">Title</th>
							<th scope="col">Description</th>
						</tr>
					</thead>
					<tbody>
						
						<?php 
							foreach ($actions as $action => $action_value){ 
								if($action_value['action'] === 'bulk_webhooks') continue;
								$is_checked = isset( $active_webhooks['actions'][ $action_value['action'] ] ) ?  'checked' : '';
						?>
						
							<tr>
								<td>
								<label class="switch ">
									<input id="wwa_<?php echo $action_value['action']; ?>" class="default primary" name="wwa_<?php echo $action_value['action']; ?>" 
									type="checkbox" 
									class="regular-text" value="<?php echo $value; ?>" <?php echo $is_checked; ?> $is_checked />
									<span class="slider"></span>
								</label>
								
								</td>
								<th scope="row"><?php echo $action_value['action']; ?></th>
								<td><?php echo $action_value['short_description'];?></td>
								
							</tr>

						<?php
							};
						?>

					</tbody>
				</table>

				<button data-keiks="keiks" id="ww_btn--action__settings" class="ww_btn ww_form--btn">
					<span class="ww_btn--text">Save Settings</span>
					
					<svg class="ww_btn--icon" xmlns="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/1999/xlink" width='50' height='50' viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
						
						<circle cx="50" cy="50" r="24" stroke-width="6" stroke="#fff" stroke-dasharray="50.26548245743669 50.26548245743669" fill="none" stroke-linecap="round">
						<animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1.5s" keyTimes="0;1" values="0 50 50;360 50 50"/>
						</circle>
					</svg>
				</button>

			</form>

			<div class="mt-4 d-flex justify-content-center ww_alert alert alert-success">Action Settings successfully updated</div>
		</div>
	</div>
	
</div>
