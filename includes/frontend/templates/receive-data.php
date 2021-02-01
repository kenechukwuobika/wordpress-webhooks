<?php
$custom_webhooks = wordpress_webhooks()->webhook->get_hooks( 'action' ) ;
$current_url = wordpress_webhooks()->helpers->get_current_url(false);
$clear_form_url = wordpress_webhooks()->helpers->get_current_url();
$action_nonce_data = wordpress_webhooks()->settings->get_action_nonce();
$actions = wordpress_webhooks()->webhook->get_actions();


?>
<div class="d-flex flex-column ww_main">

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

	<form class=" d-flex align-items-center ww_receivedata--form">
		
	<div class="ant-row ant-form-item">
		<div class="ant-col ant-form-item-label">
			<label for="ww_webook--action" class="ant-form-item-required" title="Webhook Name">Webhook Name</label>
		</div>
		<div class="ant-col ant-form-item-control">
			<div class="ant-form-item-control-input">
				<div class="ant-form-item-control-input-content">
					<span class="ant-input-affix-wrapper">
						<input type="text" id="ww_webook--action" class="ant-input" placeholder="<?php echo "'".wordpress_webhooks()->helpers->translate( 'Enter webhook name', 'ww-page-triggers' )."'"; ?>">
					</span>
				</div>
			</div>
		</div>
	</div>
		
		<div class="ant-row ant-form-item" style="display: flex; align-self: flex-end; margin-bottom: 30px; margin-left: 20px;">
				<div class="ant-col ant-form-item-control">
					<div class="ant-form-item-control-input">
						<div class="ant-form-item-control-input-content">
							<button type="submit" id="ww_create--action" class="ant-btn ant-btn-primary ant-btn-block" ant-click-animating-without-extra-node="false">
								<span class="ant-btn-loading-icon">
									<span role="img" aria-label="loading" class="anticon anticon-loading anticon-spin">
										<svg viewBox="0 0 1024 1024" focusable="false" data-icon="loading" width="1em" height="1em" fill="currentColor" aria-hidden="true">
											<path d="M988 548c-19.9 0-36-16.1-36-36 0-59.4-11.6-117-34.6-171.3a440.45 440.45 0 00-94.3-139.9 437.71 437.71 0 00-139.9-94.3C629 83.6 571.4 72 512 72c-19.9 0-36-16.1-36-36s16.1-36 36-36c69.1 0 136.2 13.5 199.3 40.3C772.3 66 827 103 874 150c47 47 83.9 101.8 109.7 162.7 26.7 63.1 40.2 130.2 40.2 199.3.1 19.9-16 36-35.9 36z"></path>
										</svg>
									</span>
								</span>
								<span>Create webhook</span>
							</button>
						</div>
					</div>
				</div>
			</div>
	</form>



<form action="" class="ww_search--form d-flex mt-4">
<div class="ant-row ant-form-item" style="width: 15rem;">
		<div class="ant-col ant-form-item-control">
			<div class="ant-form-item-control-input">
				<div class="ant-form-item-control-input-content">
					<span class="ant-input-affix-wrapper align-items-center" style="height: 2.5rem;">
					<span class="ant-input-prefix"><span role="img" aria-label="search" class="anticon anticon-search mr-0"><svg viewBox="64 64 896 896" focusable="false" data-icon="search" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M909.6 854.5L649.9 594.8C690.2 542.7 712 479 712 412c0-80.2-31.3-155.4-87.9-212.1-56.6-56.7-132-87.9-212.1-87.9s-155.5 31.3-212.1 87.9C143.2 256.5 112 331.8 112 412c0 80.1 31.3 155.5 87.9 212.1C256.5 680.8 331.8 712 412 712c67 0 130.6-21.8 182.7-62l259.7 259.6a8.2 8.2 0 0011.6 0l43.6-43.5a8.2 8.2 0 000-11.6zM570.4 570.4C528 612.7 471.8 636 412 636s-116-23.3-158.4-65.6C211.3 528 188 471.8 188 412s23.3-116.1 65.6-158.4C296 211.3 352.2 188 412 188s116.1 23.2 158.4 65.6S636 352.2 636 412s-23.3 116.1-65.6 158.4z"></path></svg></span></span>
						<input type="text" id="ww_search--term" class="ant-input" placeholder="<?php echo wordpress_webhooks()->helpers->translate( 'Search Webhooks', 'ww-page-triggers' ) ?>">
					</span>
				</div>
			</div>
		</div>
	</div>
	
</form>


<div class="table-responsive">
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
</div>


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

	
	
	
	