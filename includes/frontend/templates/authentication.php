<?php
$templates = wordpress_webhooks()->auth->get_auth_templates();
$auth_methods = wordpress_webhooks()->settings->get_authentication_methods();
?>

<div class="d-flex flex-column">

	<div class="d-flex justify-content-between">
		<div class="ww_senddata--text">
			<h2 class=""><?php echo wordpress_webhooks()->helpers->translate( 'Authentication', 'ww-page-triggers' ); ?></h2>
			<div class="main-description">
				<?php if( wordpress_webhooks()->whitelabel->is_active() && ! empty( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_text_send_data' ) ) ) : ?>
					<?php echo wordpress_webhooks()->helpers->translate( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_text_send_data' ), 'admin-settings-license' ); ?>
				<?php else : ?>
					
					<?php echo sprintf( wordpress_webhooks()->helpers->translate( 'Create your own authentication template down below. This allows you to authenticate your outgoing "Send Data" webhook triggers to a given endpoint. For more information, please check out the authentication documentation by clicking here.')); ?>
				<?php endif; ?>

			</div>
		</div>
		
	</div>


	<form class="mb-4" id="ww_auth--form">
	<div class="alert ww_alert"></div>

		<div class="form-group">

			<input type="text" class="ww_input mb-4 mt-4 form-control" id="ww_template--name" placeholder=<?php echo "'".wordpress_webhooks()->helpers->translate( 'Enter template name', 'ww-page-triggers' )."'"; ?> required>

			<select type="text" class="ww_input mb-4 mt-4 form-control" id="ww_choose--auth" name="ww_choose--auth" placeholder=<?php echo "'".wordpress_webhooks()->helpers->translate( 'Choose auth type', 'ww-page-triggers' )."'"; ?>>
				<option class="keiks" value="">Choose auth type</option>
				<?php foreach( $auth_methods as $auth_type => $auth_method ) {
				$auth_method_name = !empty( $auth_method['name'] ) ? $auth_method['name'] : $auth_method['auth_method'];
				?>
				<option value="<?php echo $auth_type; ?>"><?php echo $auth_method_name; ?></option>
				<?php } ?>
			</select>
			
			<div class="ww_append">

			</div>
			

			
		</div>
		<!-- <div class="form-group">
			<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
		</div> -->
		
		<button id="ww_create--auth" type="submit" class="btn btn-primary">Save template</button>
	</form>



<form action="" class="ww_search--form d-flex mb-4 mt-4">
	<div class="d-flex align-items-center">
		<input type="text" class="ww_input--sm form-control" id="ww_search--term" placeholder=<?php echo "'".wordpress_webhooks()->helpers->translate( 'Search templates...', 'ww-page-triggers' )."'"; ?> required>
		<svg class="ww_send--icon mr-2" xmlns="http://www.w3.org/2000/svg" width="10.102" height="10.102" viewBox="0 0 10.102 10.102">
			<path id="Icon_open-magnifying-glass" data-name="Icon open-magnifying-glass" d="M4.38-.032a4.38,4.38,0,1,0,0,8.76,4.329,4.329,0,0,0,2.077-.513,1.251,1.251,0,0,0,.163.163L7.871,9.628a1.276,1.276,0,1,0,1.8-1.8L8.422,6.575a1.251,1.251,0,0,0-.2-.163,4.321,4.321,0,0,0,.551-2.077,4.385,4.385,0,0,0-4.38-4.38Zm0,1.251A3.114,3.114,0,0,1,7.508,4.347,3.138,3.138,0,0,1,6.682,6.5l-.038.038a1.251,1.251,0,0,0-.163.163,3.131,3.131,0,0,1-2.115.788,3.128,3.128,0,0,1,0-6.257Z" transform="translate(0 0.045)" fill="#395ff5"/>
		</svg>

	</div>
	
	<select type="text" class="ww_input--sm form-control" id="ww_filter--auth" placeholder=<?php echo "'".wordpress_webhooks()->helpers->translate( 'Filter by auth type', 'ww-page-triggers' )."'"; ?>>
		<option value="">Filter by auth type</option>
		<?php foreach( $auth_methods as $identkey => $auth_method ) {
		$auth_method_name = !empty( $auth_method['name'] ) ? $auth_method['name'] : $auth_method['auth_method'];
		?>
		<option value="<?php echo $auth_method_name; ?>"><?php echo $auth_method_name; ?></option>
		<?php } ?>
	</select>

	<!-- <input type="submit" value="Filter" class="btn btn-primary align-self-center"> -->

	<input id="ww-current-url" type="hidden" value="<?php echo $current_url_full; ?>" />
</form>



<table class="table ww_auth--table">
  <thead class="thead-dark">
	<tr>
		<th scope="col">Template Type</th>
		<th scope="col">Auth Type</th>
		<th scope="col">Actions</th>
	</tr>
  </thead>
  <tbody class="tbody">
	  <?php
	  	foreach($templates as $template){

		  $template_id = $template->id;
		  $template_name = $template->name;
		  $auth_type = $template->auth_type;
	  ?>

	  

	  <?php
	  	}
	  ?>
  </tbody>
</table>



