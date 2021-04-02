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
<div class="d-flex flex-column ww_main">

	<div class="d-flex justify-content-between">
		<div class="ww_senddata--text">
			<h2 class=""><?php echo wordpress_webhooks()->helpers->translate( 'Create A Webhook Trigger', 'ww-page-triggers' ); ?></h2>
			<div class="main-description">
				<?php if( defined('WW_PRO_SETUP') && wordpress_webhooks()->whitelabel->is_active() && ! empty( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_text_send_data' ) ) ) : ?>
					<?php echo wordpress_webhooks()->helpers->translate( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_text_send_data' ), 'admin-settings-license' ); ?>
				<?php else : ?>
					
					<?php echo sprintf( wordpress_webhooks()->helpers->translate( 'Use the webhook URL down below to connect your external service with your site. This URL receives data from external endpoints and does certain actions on your WordPress site. Please note, that deleting the default main webhook creates automatically a new one. If you need more information, check out the installation and documentation by clicking here.' ), '<strong>' . $this->page_title . '</strong>', 'https://ironikus.com/docs/?utm_source=wp-webhooks-pro&utm_medium=send-data-documentation&utm_campaign=WP%20Webhooks%20Pro'); ?>
				<?php endif; ?>

			</div>
		</div>
		<svg class="ww_doc--help" xmlns="http://www.w3.org/2000/svg" width="23.5" height="23.5" viewBox="0 0 23.5 23.5"><path d="M24.063,12.313A11.75,11.75,0,1,1,12.313.563,11.749,11.749,0,0,1,24.063,12.313ZM12.628,4.448A6.137,6.137,0,0,0,7.106,7.468a.569.569,0,0,0,.129.77L8.878,9.485a.568.568,0,0,0,.79-.1c.846-1.074,1.427-1.7,2.715-1.7.968,0,2.165.623,2.165,1.562,0,.71-.586,1.074-1.541,1.61-1.115.625-2.589,1.4-2.589,3.348v.19a.569.569,0,0,0,.569.569h2.653a.569.569,0,0,0,.569-.569v-.063c0-1.349,3.941-1.4,3.941-5.054C18.149,6.532,15.3,4.448,12.628,4.448ZM12.313,16.2a2.179,2.179,0,1,0,2.179,2.179A2.182,2.182,0,0,0,12.313,16.2Z" transform="translate(-0.563 -0.563)" fill="#5643fa"/></svg>
	</div>


	<form class="mb-4 ant-form ant-form-vertical">
	<!-- <div class="alert ww_alert"></div> -->

	<div class="ww_alert">
		<div data-show="true" class="ant-alert" role="alert">
			
			<div class="ant-alert-content" >
				<div class="ant-alert-message" ></div>
				<div class="ant-alert-description" ></div>
			</div>
		</div>
	</div>

		<div class="form-group">

			<div class="dropdown">
				<div class="ant-row ant-form-item" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<div class="ant-col ant-form-item-label">
						<label for="webhook-url" class="ant-form-item-required" title="Webhook URL">Webhook Triggers</label>
					</div>
					<div class="ant-col ant-form-item-control">
						<div class="ant-form-item-control-input">
							<div class="ant-form-item-control-input-content">
								<button type="text" id="" class="ant-input ww_input--select">Select trigger</button>
							</div>

							<span class="ant-select-arrow" unselectable="on" aria-hidden="true" style="user-select: none;">
								<span role="img" aria-label="down" class="anticon anticon-down ant-select-suffix">
									<svg viewBox="64 64 896 896" focusable="false" data-icon="down" width="1em" height="1em" fill="currentColor" aria-hidden="true">
										<path d="M884 256h-75c-5.1 0-9.9 2.5-12.9 6.6L512 654.2 227.9 262.6c-3-4.1-7.8-6.6-12.9-6.6h-75c-6.5 0-10.3 7.4-6.5 12.7l352.6 486.1c12.8 17.6 39 17.6 51.7 0l352.6-486.1c3.9-5.3.1-12.7-6.4-12.7z"></path>
									</svg>
								</span>
							</span>
						</div>
					</div>
				</div>
			
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<?php foreach( $triggers as $identkey => $trigger ) {

						$trigger_name = !empty( $trigger['name'] ) ? $trigger['name'] : $trigger['trigger'];
						$webhook_name = !empty( $trigger['trigger'] ) ? $trigger['trigger'] : '';
						$trigger_callback = !empty( $trigger['callback'] ) ? $trigger['callback'] : '';

						$settings = array();
					if( ! empty( $trigger['settings'] ) ){

						if( isset( $trigger['settings']['data'] ) ){
							$settings = (array) $trigger['settings']['data'];
						}

						if( isset( $trigger['settings']['load_default_settings'] ) && $trigger['settings']['load_default_settings'] === true ){
								$settings = array_merge( wordpress_webhooks()->settings->get_default_trigger_settings(), $settings );
						}
					}

					//Map dynamic settings
					$required_settings = wordpress_webhooks()->settings->get_required_trigger_settings();
					foreach( $required_settings as $settings_ident => $settings_data ){

						if( $settings_ident == 'ww_trigger_authentication' ){
							if( ! empty( $authentication_templates ) ){
								$required_settings[ $settings_ident ]['choices'] = array_replace( $required_settings[ $settings_ident ]['choices'], wordpress_webhooks()->auth->flatten_authentication_data( $authentication_templates ) );
							} else {
								unset( $required_settings[ $settings_ident ] ); //if empty
							}
						}

					}

					$settings = array_merge( $required_settings, $settings );

					?>

						<div id="webhook" data-ww-callback=<?php echo $trigger_callback; ?> class="ww_input--item dropdown-item" >
							<span><?php echo $webhook_name?></span>
							<small id="webhook" class="form-text text-muted"><?php echo $trigger_name?></small>
						</div>

					<?php }?>
				
				</div>	
			</div>

			
			<div class="ant-row ant-form-item">
				<div class="ant-col ant-form-item-label">
					<label for="webhook-name" class="ant-form-item-required" title="Webhook Name">Webhook Name</label>
				</div>
				<div class="ant-col ant-form-item-control">
					<div class="ant-form-item-control-input">
						<div class="ant-form-item-control-input-content">
							<span class="ant-input-affix-wrapper">
								<input type="text" id="webhook-name" class="ant-input" placeholder="<?php echo "'".wordpress_webhooks()->helpers->translate( 'Enter webhook name', 'ww-page-triggers' )."'"; ?>">
							</span>
						</div>
					</div>
				</div>
			</div>

			<div class="ant-row ant-form-item">
				<div class="ant-col ant-form-item-label">
					<label for="webhook-url" class="ant-form-item-required" title="Webhook URL">Webhook URL</label>
				</div>
				<div class="ant-col ant-form-item-control">
					<div class="ant-form-item-control-input">
						<div class="ant-form-item-control-input-content">
							<span class="ant-input-affix-wrapper">
								<input type="text" id="webhook-url" class="ant-input" placeholder="<?php echo "'".wordpress_webhooks()->helpers->translate( 'Enter webhook url', 'ww-page-triggers' )."'"; ?>">
							</span>
						</div>
					</div>
				</div>
			</div>

			<div class="ant-row ant-form-item">
				<div class="ant-col ant-form-item-control">
					<div class="ant-form-item-control-input">
						<div class="ant-form-item-control-input-content">
							<button type="submit" id="ww_create--trigger" class="ant-btn ant-btn-primary ant-btn-block" ant-click-animating-without-extra-node="false">
								<span class="ant-btn-loading-icon">
									<span role="img" aria-label="loading" class="anticon anticon-loading anticon-spin">
										<svg viewBox="0 0 1024 1024" focusable="false" data-icon="loading" width="1em" height="1em" fill="currentColor" aria-hidden="true">
											<path d="M988 548c-19.9 0-36-16.1-36-36 0-59.4-11.6-117-34.6-171.3a440.45 440.45 0 00-94.3-139.9 437.71 437.71 0 00-139.9-94.3C629 83.6 571.4 72 512 72c-19.9 0-36-16.1-36-36s16.1-36 36-36c69.1 0 136.2 13.5 199.3 40.3C772.3 66 827 103 874 150c47 47 83.9 101.8 109.7 162.7 26.7 63.1 40.2 130.2 40.2 199.3.1 19.9-16 36-35.9 36z"></path>
										</svg>
									</span>
								</span>
								<span>Create trigger</span>
							</button>
						</div>
					</div>
				</div>
			</div>
			
		</div>
		
	</form>

<form action="" class="ww_search--form d-flex align-items-center">
	<div class="ant-row ant-form-item" style="width: 15rem;">
		<div class="ant-col ant-form-item-control">
			<div class="ant-form-item-control-input">
				<div class="ant-form-item-control-input-content">
					<span class="ant-input-affix-wrapper align-items-center" style="height: 2.5rem;">
					<span class="ant-input-prefix"><span role="img" aria-label="search" class="anticon anticon-search mr-0"><svg viewBox="64 64 896 896" focusable="false" data-icon="search" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M909.6 854.5L649.9 594.8C690.2 542.7 712 479 712 412c0-80.2-31.3-155.4-87.9-212.1-56.6-56.7-132-87.9-212.1-87.9s-155.5 31.3-212.1 87.9C143.2 256.5 112 331.8 112 412c0 80.1 31.3 155.5 87.9 212.1C256.5 680.8 331.8 712 412 712c67 0 130.6-21.8 182.7-62l259.7 259.6a8.2 8.2 0 0011.6 0l43.6-43.5a8.2 8.2 0 000-11.6zM570.4 570.4C528 612.7 471.8 636 412 636s-116-23.3-158.4-65.6C211.3 528 188 471.8 188 412s23.3-116.1 65.6-158.4C296 211.3 352.2 188 412 188s116.1 23.2 158.4 65.6S636 352.2 636 412s-23.3 116.1-65.6 158.4z"></path></svg></span></span>
						<input type="text" id="ww_search--term" class="ant-input" placeholder="<?php echo wordpress_webhooks()->helpers->translate( 'Search Webhooks', 'ww-page-triggers' ); ?>">
					</span>
				</div>
			</div>
		</div>
	</div>
	
	<div class="ant-row ant-form-item" style="width: 15rem;">

        <div class="ant-select ant-select-single ant-select-show-arrow ant-select-open" style="height:32px">
            <div class="ant-select-selector">
            
            <span class="ant-select-selection-search">
                <input autocomplete="off" type="search" class="ant-select-selection-search-input" role="combobox" aria-haspopup="listbox" aria-owns="rc_select_7_list" aria-autocomplete="list" aria-controls="rc_select_7_list" aria-activedescendant="rc_select_7_list_0" readonly="" unselectable="on" value="" id="rc_select_7" style="opacity: 0;" aria-expanded="true">
            </span>
            <span class="ant-select-selection-item" title="Select a trigger" >Select a trigger</span>
        </div>
        <span class="ant-select-arrow" unselectable="on" aria-hidden="true" style="user-select: none;">
            <span role="img" aria-label="down" class="anticon anticon-down ant-select-suffix">
                <svg viewBox="64 64 896 896" focusable="false" data-icon="down" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                    <path d="M884 256h-75c-5.1 0-9.9 2.5-12.9 6.6L512 654.2 227.9 262.6c-3-4.1-7.8-6.6-12.9-6.6h-75c-6.5 0-10.3 7.4-6.5 12.7l352.6 486.1c12.8 17.6 39 17.6 51.7 0l352.6-486.1c3.9-5.3.1-12.7-6.4-12.7z"></path>
                </svg>
            </span>
        </span>

        <div class="ant-select-dropdown ant-select-dropdown-placement-bottomLeft ant-select-dropdown-hidden" >
        <div role="listbox" id="rc_select_7_list" style="height: 0px; width: 0px; overflow: hidden;">
            <div aria-label="All" role="option" id="rc_select_7_list_0" aria-selected="true">Select a trigger</div>
                <div aria-label="Cloths" role="option" id="rc_select_7_list_1" aria-selected="false">Select a trigger</div>
            </div>
            <div class="rc-virtual-list" style="position: relative;">
                <div class="rc-virtual-list-holder" style="max-height: 256px; overflow-y: hidden; overflow-anchor: none;"><div>
				<div class="rc-virtual-list-holder-inner" style="display: flex; flex-direction: column;">

				<div aria-selected="true" class="ant-select-item ant-select-item-option ant-select-item-option-selected" title="All">
					<div class="ant-select-item-option-content ww_filter--trigger">Select a trigger</div>
					<span class="ant-select-item-option-state" unselectable="on" aria-hidden="true" style="user-select: none;"></span>
				</div>
			
				<?php foreach( $triggers as $identkey => $trigger ) {

					$trigger_name = !empty( $trigger['name'] ) ? $trigger['name'] : $trigger['trigger'];
					$webhook_name = !empty( $trigger['trigger'] ) ? $trigger['trigger'] : '';
					$trigger_callback = !empty( $trigger['callback'] ) ? $trigger['callback'] : '';
				?>
					<div aria-selected="true" class="ant-select-item ant-select-item-option ant-select-item-option-selected" title="All">
                        <div class="ant-select-item-option-content ww_filter--trigger" ww-data-value="<?php echo $webhook_name; ?>"><?php echo $webhook_name; ?></div>
                        <span class="ant-select-item-option-state" unselectable="on" aria-hidden="true" style="user-select: none;"></span>
					</div>
					
				<?php } ?>
                    
            	</div>
			</div>
            <div class="rc-virtual-list-scrollbar" style="width: 8px; top: 0px; bottom: 0px; right: 0px; position: absolute; display: none;">
                <div class="rc-virtual-list-scrollbar-thumb" style="width: 100%; height: 128px; top: 0px; left: 0px; position: absolute; background: rgba(0, 0, 0, 0.5); border-radius: 99px; cursor: pointer; user-select: none;"></div>
            </div>
        </div>
    </div>

        
				
	</div>
	</div>
	</div>
	

	
	
	<input id="ww-current-url" type="hidden" value="<?php echo $current_url_full; ?>" />
</form>


<div class="ant-row" style="margin-left: -8px; margin-right: -8px;">
	<div class="ant-col ant-col-xs-24 ant-col-sm-24 ant-col-md-24 ant-col-lg-24" style="padding-left: 8px; padding-right: 8px;">
		<div class="ant-card ant-card-bordered table-responsive">
			<div class="ant-card-head">
				<div class="ant-card-head-wrapper">
					<div class="ant-card-head-title">Available Webhook Triggers</div>
				</div>
			</div>
			<div class="ant-card-body">
				<div class="ant-table-wrapper">
					<div class="ant-spin-nested-loading">
						<div class="ant-spin-container">
							<div class="ant-table">
								<div class="ant-table-container">
									<div class="ant-table-content">
										<table style="table-layout: auto;" class="ww_send--table">
											<colgroup></colgroup>
											<thead class="ant-table-thead">
												<tr>
													<th class="ant-table-cell">
														<span>Webhook Name</span>
													</th>
													
													<th class="ant-table-cell">
														<span>Webhook Url</span>
													</th>

													<th class="ant-table-cell">
														<span>Trigger</span>
													</th>

													<th class="ant-table-cell">
														<span>Action</span>
													</th>

												</tr>
											</thead>
											<tbody class="ant-table-tbody ww_tbody">
												
											</tbody>
										</table>
										<div class="ww_append"></div>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
  Launch demo modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header flex-column">
		<div class="d-flex justify-space-between w-100">
		<h5 class="modal-title" id="exampleModalLongTitle">Trigger Settings</h5>
		
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
		</button>
		</div>
		
		<div style="margin-bottom: 0;" class="ww_alert alert alert-success">Trigger Settings successfully updated</div>

      </div>
	  <form action="" id="ww_trigger--settings_form">

		<div class="ww_settings-modal modal-body d-flex flex-column">


		</div>

		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button class="btn btn-primary ww_trigger--setting_btn position-relative">
			<span class="ww_btn--text">Save Settings</span>
				
				<svg class="ww_btn--icon" xmlns="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/1999/xlink" width='50' height='50' viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
							
					<circle cx="50" cy="50" r="24" stroke-width="6" stroke="#fff" stroke-dasharray="50.26548245743669 50.26548245743669" fill="none" stroke-linecap="round">
					<animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1.5s" keyTimes="0;1" values="0 50 50;360 50 50"/>
					</circle>
				</svg>
			</button>
		</div>
	</form>
		
			
			

  </div>
</div>
</div>

<div class="ww_modal">
	<div class="ww_modal--overlay"></div>
	
	<div class="ww_modal--body">
	
		<svg class="ww_modal--close" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 20.177 20.177"><path d="M13.463,3.375A10.088,10.088,0,1,0,23.552,13.463,10.087,10.087,0,0,0,13.463,3.375Zm2.556,13.741L13.463,14.56l-2.556,2.556a.775.775,0,1,1-1.1-1.1l2.556-2.556L9.811,10.907a.775.775,0,1,1,1.1-1.1l2.556,2.556,2.556-2.556a.775.775,0,0,1,1.1,1.1L14.56,13.463l2.556,2.556a.779.779,0,0,1,0,1.1A.77.77,0,0,1,16.019,17.116Z" transform="translate(-3.375 -3.375)" fill="#707070"/></svg>
		
		<div class="ww_modal--1">
			<h4 class="ww_modal--heading mb-4">Available Webhooks Triggers</h4>

			<p class="ww_modal--text">Use the webhook URL down below to connect your external service with your site. This URL receives data from external endpoints and does certain actions on your WordPress site. Please note, that deleting the default main webhook creates automatically a new one. If you need more information, check out the installation and documentation by clicking here.</p>

			<ul class="ww_triggers--list">
			<?php foreach( $triggers as $identkey => $trigger ) {

				$trigger_name = !empty( $trigger['name'] ) ? $trigger['name'] : $trigger['trigger'];
				$webhook_name = !empty( $trigger['trigger'] ) ? $trigger['trigger'] : '';
				$trigger_callback = !empty( $trigger['callback'] ) ? $trigger['callback'] : '';
			?>

				<li class="ww_triggers--items">
					<a href="#" class="ww_triggers--links" id=<?php echo $webhook_name;?>><?php echo $webhook_name;?></a>
					<input type="hidden" id=<?php echo "short_description-".$webhook_name;?> value=<?php echo "'".$trigger['short_description']."'";?>>
					<input type="hidden" id=<?php echo "values-".$webhook_name;?> value=<?php echo "'".$trigger['returns_code']."'";?>>
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
					
				</ul>

				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
						loading...
					</div>

					<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="home-tab">
						loading...
					</div>
				</div>
                
			</div>
		</div>
	</div>

	
</div>



