<?php
$triggers = wordpress_webhooks()->webhook->get_triggers();
$custom_webhooks = wordpress_webhooks()->webhook->get_hooks( 'action' );
$current_url = wordpress_webhooks()->helpers->get_current_url(false);
$current_url_full = wordpress_webhooks()->helpers->get_current_url();
$data_mapping_templates = wordpress_webhooks()->data_mapping->get_data_mapping();
$authentication_templates = wordpress_webhooks()->auth->get_auth_templates();


?>
<div class="d-flex flex-column">

	<div class="d-flex justify-content-between mb-4">
		<div class="ww_receivedata--text">
			<h2 class=""><?php echo wordpress_webhooks()->helpers->translate( 'Recevie Data To WordPress Webhooks Pro', 'ww-page-triggers' ); ?></h2>
			<div class="main-description">
				<?php if( wordpress_webhooks()->whitelabel->is_active() && ! empty( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_text_send_data' ) ) ) : ?>
					<?php echo wordpress_webhooks()->helpers->translate( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_text_send_data' ), 'admin-settings-license' ); ?>
				<?php else : ?>
					
					<?php echo sprintf( wordpress_webhooks()->helpers->translate( 'Use the webhook URL down below to connect your external service with your site. This URL receives data from external endpoints and does certain actions on your WordPress site. Please note, that deleting the default main webhook creates automatically a new one. If you need more information, check out the installation and documentation by clicking here.' ), '<strong>' . $this->page_title . '</strong>', 'https://ironikus.com/docs/?utm_source=wp-webhooks-pro&utm_medium=send-data-documentation&utm_campaign=WP%20Webhooks%20Pro'); ?>
				<?php endif; ?>

			</div>
		</div>
		<svg xmlns="http://www.w3.org/2000/svg" width="23.5" height="23.5" viewBox="0 0 23.5 23.5"><path d="M24.063,12.313A11.75,11.75,0,1,1,12.313.563,11.749,11.749,0,0,1,24.063,12.313ZM12.628,4.448A6.137,6.137,0,0,0,7.106,7.468a.569.569,0,0,0,.129.77L8.878,9.485a.568.568,0,0,0,.79-.1c.846-1.074,1.427-1.7,2.715-1.7.968,0,2.165.623,2.165,1.562,0,.71-.586,1.074-1.541,1.61-1.115.625-2.589,1.4-2.589,3.348v.19a.569.569,0,0,0,.569.569h2.653a.569.569,0,0,0,.569-.569v-.063c0-1.349,3.941-1.4,3.941-5.054C18.149,6.532,15.3,4.448,12.628,4.448ZM12.313,16.2a2.179,2.179,0,1,0,2.179,2.179A2.182,2.182,0,0,0,12.313,16.2Z" transform="translate(-0.563 -0.563)" fill="#5643fa"/></svg>
	</div>

	<form class="mb-4 d-flex align-items-center">
		<div class="form-group mb-0 mr-4">

			<div class="dropdown">
				<button class="ww_input dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<?php echo wordpress_webhooks()->helpers->translate( 'Enter webhook name', 'ww-page-triggers' ); ?>
				</button>
					
			</div>

			<input type="text" class="ww_input mb-4 mt-4 form-control" id="webhook-name" placeholder=<?php echo "'".wordpress_webhooks()->helpers->translate( 'Enter webhook name', 'ww-page-triggers' )."'"; ?> required>
			
			<input type="text" class="ww_input mb-4 form-control" id="webhook-url" placeholder=<?php echo "'".wordpress_webhooks()->helpers->translate( 'Enter webhook url', 'ww-page-triggers' )."'"; ?> required>

			
		</div>
		<!-- <div class="form-group">
			<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
		</div> -->
		
		<button type="submit" class="btn btn-primary ">Create Webhook</button>
	</form>



<form action="" class="ww_send--filter d-flex">
	<div class="d-flex align-items-center">
		<input type="text" class="ww_input--sm mb-4 mt-4 form-control" id="" placeholder=<?php echo "'".wordpress_webhooks()->helpers->translate( 'Search webhooks...', 'ww-page-triggers' )."'"; ?> required>
		<svg class="ww_send--icon" xmlns="http://www.w3.org/2000/svg" width="10.102" height="10.102" viewBox="0 0 10.102 10.102">
			<path id="Icon_open-magnifying-glass" data-name="Icon open-magnifying-glass" d="M4.38-.032a4.38,4.38,0,1,0,0,8.76,4.329,4.329,0,0,0,2.077-.513,1.251,1.251,0,0,0,.163.163L7.871,9.628a1.276,1.276,0,1,0,1.8-1.8L8.422,6.575a1.251,1.251,0,0,0-.2-.163,4.321,4.321,0,0,0,.551-2.077,4.385,4.385,0,0,0-4.38-4.38Zm0,1.251A3.114,3.114,0,0,1,7.508,4.347,3.138,3.138,0,0,1,6.682,6.5l-.038.038a1.251,1.251,0,0,0-.163.163,3.131,3.131,0,0,1-2.115.788,3.128,3.128,0,0,1,0-6.257Z" transform="translate(0 0.045)" fill="#395ff5"/>
		</svg>

	</div>
	
</form>



<table class="table">
  <thead class="thead-dark">
	<tr>
		<th style="width:10%" scope="col">Webhook Name</th>
		<th style="width:30%" scope="col">Webhook Url</th>
		<th style="width:20%" scope="col">Api Key</th>
		<th style="width:40%" scope="col">Actions</th>
	</tr>
  </thead>
  <tbody>
    
    <?php 
		foreach ($custom_webhooks as $custom_webhook => $item){ 
	?>
	
		<tr>
			<th scope="row"><?php echo $custom_webhook; ?></th>
			<td>
            <input type="text" value="<?php echo wordpress_webhooks()->webhook->built_url( $custom_webhook, $item['api_key'] );?>" readonly>
            </td>
			<td>
                <input type="text" value="<?php echo $item['api_key'];?>">
                
            </td>
			<td>
				<div class="ww_actions d-flex">
                    <div class="ww_action--items ww_action--danger mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="7.98" height="10.26" viewBox="0 0 7.98 10.26">
                            <path id="Icon_material-delete" data-name="Icon material-delete" d="M8.07,13.62a1.143,1.143,0,0,0,1.14,1.14h4.56a1.143,1.143,0,0,0,1.14-1.14V6.78H8.07Zm7.41-8.55H13.485l-.57-.57h-2.85l-.57.57H7.5V6.21h7.98Z" transform="translate(-7.5 -4.5)" fill="#395ff5"/>
                        </svg>
                        <span>Delete</span>
                    </div>

                    <div class="ww_action--items ww_action--danger mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="11.438" height="11.438" viewBox="0 0 11.438 11.438">
                        <path id="Icon_awesome-stop-circle" data-name="Icon awesome-stop-circle" d="M6.281.563A5.719,5.719,0,1,0,12,6.281,5.718,5.718,0,0,0,6.281.563ZM8.495,8.126a.37.37,0,0,1-.369.369H4.436a.37.37,0,0,1-.369-.369V4.436a.37.37,0,0,1,.369-.369h3.69a.37.37,0,0,1,.369.369Z" transform="translate(-0.563 -0.563)" fill="#395ff5"/>
                        </svg>

                        <span>Deactivate</span>
                    </div>

                    <div class="ww_action--items mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12.26" height="12.263" viewBox="0 0 12.26 12.263">
                        <path id="Icon_ionic-ios-settings" data-name="Icon ionic-ios-settings" d="M15.748,10.63A1.578,1.578,0,0,1,16.76,9.158,6.253,6.253,0,0,0,16,7.335a1.6,1.6,0,0,1-.642.137,1.574,1.574,0,0,1-1.44-2.216A6.235,6.235,0,0,0,12.1,4.5a1.576,1.576,0,0,1-2.944,0,6.253,6.253,0,0,0-1.823.757A1.574,1.574,0,0,1,5.9,7.472a1.547,1.547,0,0,1-.642-.137A6.392,6.392,0,0,0,4.5,9.161a1.577,1.577,0,0,1,0,2.944,6.253,6.253,0,0,0,.757,1.823,1.575,1.575,0,0,1,2.078,2.078,6.29,6.29,0,0,0,1.823.757,1.573,1.573,0,0,1,2.937,0,6.253,6.253,0,0,0,1.823-.757A1.576,1.576,0,0,1,16,13.928a6.29,6.29,0,0,0,.757-1.823A1.585,1.585,0,0,1,15.748,10.63Zm-5.089,2.551a2.554,2.554,0,1,1,2.554-2.554A2.553,2.553,0,0,1,10.659,13.181Z" transform="translate(-4.5 -4.5)" fill="#395ff5"/>
                        </svg>

                        <span>Settings</span>
                    </div>
                </div>
				
			</td>
		</tr>

	<?php 
		
		};
	?>

  </tbody>
</table>



	
	
	
	