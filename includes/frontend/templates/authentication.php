<?php
$templates = wordpress_webhooks()->auth->get_auth_templates();
$auth_methods = wordpress_webhooks()->settings->get_authentication_methods();
?>

<div class="d-flex flex-column ww_main">

	<div class="d-flex justify-content-between">
		<div class="ww_senddata--text">
			<h2 class=""><?php echo wordpress_webhooks()->helpers->translate( 'Authentication', 'ww-page-triggers' ); ?></h2>
			<div class="main-description">
				<?php if( defined('WW_PRO_SETUP') && wordpress_webhooks()->whitelabel->is_active() && ! empty( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_text_authentication' ) ) ) : ?>
					<?php echo wordpress_webhooks()->helpers->translate( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_text_authentication' ), 'admin-settings-license' ); ?>
				<?php else : ?>
					
					<?php echo sprintf( wordpress_webhooks()->helpers->translate( 'Create your own authentication template down below. This allows you to authenticate your outgoing "Send Data" webhook triggers to a given endpoint. For more information, please check out the authentication documentation by clicking here.')); ?>
				<?php endif; ?>

			</div>
		</div>
		
	</div>


	<form class="mb-4" id="ww_auth--form">
		<div class="alert ww_alert"></div>

		<div class="form-group">

			<div class="ant-row ant-form-item" style="width: 25rem;">
				<div class="ant-col ant-form-item-label">
					<label for="ww_template--name" class="ant-form-item-required" title="Template Name">Template Name</label>
				</div>
				<div class="ant-col ant-form-item-control">
					<div class="ant-form-item-control-input">
						<div class="ant-form-item-control-input-content">
							<span class="ant-input-affix-wrapper">
								<input type="text" id="ww_template--name" name="ww_template--name" class="ant-input" placeholder="'Enter template name'">
							</span>
						</div>
					</div>
				</div>
			</div>

			<div class="ant-row ant-form-item" style="width: 25rem;">
				<div class="ant-col ant-form-item-label">
					<label for="ww_choose--auth" class="ant-form-item-required" title="Auth Type">Auth Type</label>
				</div>
				<div class="ant-select ant-select-single ant-select-show-arrow ant-select-open" style="height:32px">
					<div class="ant-select-selector">
					
						<span class="ant-select-selection-search">
							<input autocomplete="off" name="ww_choose--auth" id="ww_choose--auth" type="search" class="ant-select-selection-search-input" role="combobox" aria-haspopup="listbox" aria-owns="rc_select_7_list" aria-autocomplete="list" aria-controls="rc_select_7_list" aria-activedescendant="rc_select_7_list_0" readonly="" unselectable="on" value="" id="rc_select_7" style="opacity: 0;" aria-expanded="true">
						</span>
						<span class="ant-select-selection-item" title="Choose auth type">Choose auth type</span>
					</div>
				<span class="ant-select-arrow" unselectable="on" aria-hidden="true" style="user-select: none;">
					<span role="img" aria-label="down" class="anticon anticon-down ant-select-suffix">
						<svg viewBox="64 64 896 896" focusable="false" data-icon="down" width="1em" height="1em" fill="currentColor" aria-hidden="true">
							<path d="M884 256h-75c-5.1 0-9.9 2.5-12.9 6.6L512 654.2 227.9 262.6c-3-4.1-7.8-6.6-12.9-6.6h-75c-6.5 0-10.3 7.4-6.5 12.7l352.6 486.1c12.8 17.6 39 17.6 51.7 0l352.6-486.1c3.9-5.3.1-12.7-6.4-12.7z"></path>
						</svg>
					</span>
				</span>

				<div class="ant-select-dropdown ant-select-dropdown-placement-bottomLeft ant-select-dropdown-hidden" id="ww_change--auth">
					<div role="listbox" id="rc_select_7_list" style="height: 0px; width: 0px; overflow: hidden;">
						<div aria-label="All" role="option" id="rc_select_7_list_0" aria-selected="true">Choose auth type</div>
							<div aria-label="Cloths" role="option" id="rc_select_7_list_1" aria-selected="false">Choose auth type</div>
						</div>
						<div class="rc-virtual-list" style="position: relative;">
							<div class="rc-virtual-list-holder" style="max-height: 256px; overflow-y: hidden; overflow-anchor: none;"><div>
							<div class="rc-virtual-list-holder-inner" style="display: flex; flex-direction: column;">
								<div aria-selected="true" class="ant-select-item ant-select-item-option ant-select-item-option-selected" title="All">
									<div class="ant-select-item-option-content">Choose auth type</div>
									<span class="ant-select-item-option-state" unselectable="on" aria-hidden="true" style="user-select: none;"></span>
								</div>
								<?php foreach( $auth_methods as $auth_type => $auth_method ) {
									if($auth_type === 'digest_auth'){
										continue;
									}
									$auth_method_name = !empty( $auth_method['name'] ) ? $auth_method['name'] : $auth_method['auth_method'];
									?>
									<div aria-selected="false" class="ant-select-item ant-select-item-option" title="<?php echo $auth_method_name; ?>">
										<div class="ant-select-item-option-content" ww-data-value="<?php echo $auth_type; ?>"><?php echo $auth_method_name; ?></div>
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

			
		</div>		

		<div class="ww_auth--add_fields"></div>
		
		<div class="ant-row ant-form-item">
				<div class="ant-col ant-form-item-control">
					<div class="ant-form-item-control-input">
						<div class="ant-form-item-control-input-content">
							<button type="submit" id="ww_create--auth" class="ant-btn ant-btn-primary ant-btn-block" ant-click-animating-without-extra-node="false">
								<span class="ant-btn-loading-icon">
									<span role="img" aria-label="loading" class="anticon anticon-loading anticon-spin">
										<svg viewBox="0 0 1024 1024" focusable="false" data-icon="loading" width="1em" height="1em" fill="currentColor" aria-hidden="true">
											<path d="M988 548c-19.9 0-36-16.1-36-36 0-59.4-11.6-117-34.6-171.3a440.45 440.45 0 00-94.3-139.9 437.71 437.71 0 00-139.9-94.3C629 83.6 571.4 72 512 72c-19.9 0-36-16.1-36-36s16.1-36 36-36c69.1 0 136.2 13.5 199.3 40.3C772.3 66 827 103 874 150c47 47 83.9 101.8 109.7 162.7 26.7 63.1 40.2 130.2 40.2 199.3.1 19.9-16 36-35.9 36z"></path>
										</svg>
									</span>
								</span>
								<span>Save template</span>
							</button>
						</div>
					</div>
				</div>
			</div>

	</form>

<form action="" class="ww_search--form d-flex align-items-center mt-4">
	
	
	

	<div class="ant-row ant-form-item" style="width: 15rem;">
		<div class="ant-col ant-form-item-control">
			<div class="ant-form-item-control-input">
				<div class="ant-form-item-control-input-content">
					<span class="ant-input-affix-wrapper align-items-center" style="height: 2.5rem;">
					<span class="ant-input-prefix"><span role="img" aria-label="search" class="anticon anticon-search mr-0"><svg viewBox="64 64 896 896" focusable="false" data-icon="search" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M909.6 854.5L649.9 594.8C690.2 542.7 712 479 712 412c0-80.2-31.3-155.4-87.9-212.1-56.6-56.7-132-87.9-212.1-87.9s-155.5 31.3-212.1 87.9C143.2 256.5 112 331.8 112 412c0 80.1 31.3 155.5 87.9 212.1C256.5 680.8 331.8 712 412 712c67 0 130.6-21.8 182.7-62l259.7 259.6a8.2 8.2 0 0011.6 0l43.6-43.5a8.2 8.2 0 000-11.6zM570.4 570.4C528 612.7 471.8 636 412 636s-116-23.3-158.4-65.6C211.3 528 188 471.8 188 412s23.3-116.1 65.6-158.4C296 211.3 352.2 188 412 188s116.1 23.2 158.4 65.6S636 352.2 636 412s-23.3 116.1-65.6 158.4z"></path></svg></span></span>
						<input type="text" id="ww_search--term" class="ant-input" placeholder="<?php echo wordpress_webhooks()->helpers->translate( 'Search templates', 'ww-page-triggers' ); ?>">
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
            <span class="ant-select-selection-item" title="Select a template" >Select a template</span>
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
            <div aria-label="All" role="option" id="rc_select_7_list_0" aria-selected="true">Select a template</div>
                <div aria-label="Cloths" role="option" id="rc_select_7_list_1" aria-selected="false">Select a template</div>
            </div>
            <div class="rc-virtual-list" style="position: relative;">
                <div class="rc-virtual-list-holder" style="max-height: 256px; overflow-y: hidden; overflow-anchor: none;"><div>
				<div class="rc-virtual-list-holder-inner" style="display: flex; flex-direction: column;">

				<div aria-selected="true" class="ant-select-item ant-select-item-option ant-select-item-option-selected" title="All">
					<div class="ant-select-item-option-content ww_filter--auth">Select a template</div>
					<span class="ant-select-item-option-state" unselectable="on" aria-hidden="true" style="user-select: none;"></span>
				</div>
			
				<?php foreach( $auth_methods as $identkey => $auth_method ) {
					if($auth_method['name'] === 'Digest Auth'){
						continue;
					}
					$auth_method_name = !empty( $auth_method['name'] ) ? $auth_method['name'] : $auth_method['auth_method'];
				?>
					<div aria-selected="true" class="ant-select-item ant-select-item-option ant-select-item-option-selected" title="All">
                        <div class="ant-select-item-option-content ww_filter--auth" ww-data-value="<?php echo $auth_method_name; ?>"><?php echo $auth_method_name; ?></div>
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
					<div class="ant-card-head-title">Available Authentication Templates</div>
				</div>
			</div>
			<div class="ant-card-body">
				<div class="ant-table-wrapper">
					<div class="ant-spin-nested-loading">
						<div class="ant-spin-container">
							<div class="ant-table">
								<div class="ant-table-container">
									<div class="ant-table-content">
										<table style="table-layout: auto;" class="ww_auth--table">
											<colgroup></colgroup>
											<thead class="ant-table-thead">
												<tr>
													<th class="ant-table-cell">
														<span>Template Name</span>
													</th>
													
													<th class="ant-table-cell">
														<span>Auth Type</span>
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


