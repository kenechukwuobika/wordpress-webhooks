<?php

$whitelist = wordpress_webhooks()->whitelist->get_list();
$whitelist_requests = wordpress_webhooks()->whitelist->get_request_list();
$current_url = wordpress_webhooks()->helpers->get_current_url(false);
$clear_form_url = wordpress_webhooks()->helpers->get_current_url();
$whitelist_nonce_data = wordpress_webhooks()->settings->get_whitelist_nonce();
$shitelist_requests_count = 0;

// START Add IP
if( isset( $_POST['ironikus_WordPress_Webhooks_whitelist_url'] ) ) {
	if ( ! check_admin_referer( $whitelist_nonce_data['action'], $whitelist_nonce_data['arg'] ) ) {
		return;
	}

	$check = wordpress_webhooks()->whitelist->add_item( esc_html( $_POST['ironikus_WordPress_Webhooks_whitelist_url'] ) );
	if( $check ) {
		echo wordpress_webhooks()->helpers->create_admin_notice( array(
			'IP successfully added: %s',
			esc_html( $_POST['ironikus_WordPress_Webhooks_whitelist_url'] )
		), 'success', true );

		$whitelist = wordpress_webhooks()->whitelist->get_list();
	}
}
// END ADd IP

//START Delete IP
if( isset( $_GET['ww_whitelist_delete'] ) ){
	$check = wordpress_webhooks()->whitelist->delete_item( esc_html( $_GET['ww_whitelist_delete'] ) );
	if( $check ){

		if( isset( $whitelist[ $_GET['ww_whitelist_delete'] ] ) ){
			$whitelist_name = $whitelist[ $_GET['ww_whitelist_delete'] ];
		} else {
			$whitelist_name = $_GET['ww_whitelist_delete'];
		}

		echo wordpress_webhooks()->helpers->create_admin_notice( array( 'The following IP was successfully removed: %s', esc_html( $whitelist_name ) ), 'success', true );

		$whitelist = wordpress_webhooks()->whitelist->get_list();
	}
	unset( $_GET[ 'ww_whitelist_delete' ] );
	$clear_form_url = wordpress_webhooks()->helpers->built_url( $current_url, $_GET );
}
//END Delete IP

?>
<div class="wpwh-whitelist-wrapper">
	<h2><?php echo wordpress_webhooks()->helpers->translate( 'Whitelist', 'ww-page-whitelist' ); ?></h2>

	<div>
		<?php if( wordpress_webhooks()->whitelabel->is_active() && ! empty( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_text_whitelist' ) ) ) : ?>
			<?php echo wordpress_webhooks()->helpers->translate( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_text_whitelist' ), 'admin-settings-license' ); ?>
		<?php else : ?>
			<?php echo wordpress_webhooks()->helpers->translate( 'You see this page because you have activated the whitelist. This means, that just selected IP addresses can send data to your website.', 'ww-page-whitelist' ); ?>
		<?php endif; ?>
	</div>
	<?php if( ! empty( $whitelist ) ) : ?>
		<table class="table ironikus-whitelist-table">
			<thead class="thead-dark">
			<tr>
				<th style="width:35%">
					<?php echo wordpress_webhooks()->helpers->translate( 'Allowed IP\'s', 'ww-page-whitelist' ); ?>
				</th>
				<th style="width:10%">
					<?php echo wordpress_webhooks()->helpers->translate( 'Action', 'ww-page-whitelist' ); ?>
				</th>
			</tr>
			</thead>
			<tbody>
				<?php foreach( $whitelist as $key => $url ) : ?>
					<?php if( ! is_string( $url ) ) { continue; } ?>
					<tr>
						<td>
							<input class="ironikus-webhook-input" type='text' name='ironikus_wp_webhooks_pro_whitelist_ip' value="<?php echo $url; ?>" readonly /><br>
						</td>
						<td>
							<div class="ironikus-element-actions">
								<a class="wpwh-whitelist-delete-item" href="<?php echo wordpress_webhooks()->helpers->built_url( wordpress_webhooks()->helpers->get_current_url(), array_merge( $_GET, array( 'ww_whitelist_delete' => $key, ) ) ); ?>" title="<?php echo wordpress_webhooks()->helpers->translate( 'Delete', 'ww-page-whitelist' ); ?>" ><?php echo wordpress_webhooks()->helpers->translate( 'Delete', 'ww-page-whitelist' ); ?></a>
							</div>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php else : ?>
		<div class="ww-empty">
			<?php echo wordpress_webhooks()->helpers->translate( 'You currently don\'t have any IP\'s whitelisted. Please add one to get started.', 'ww-page-whitelist' ); ?>
		</div>
	<?php endif; ?>
	<p class="ironikus-separator"></p>
	<div class="ironikus-add-whitelist-ip">
		<form method="post" action="<?php echo $clear_form_url; ?>">
			<input class="form-control ironikus-webhook-input-new h30" style="width:200px;" type='text' name='ironikus_WordPress_Webhooks_whitelist_url' placeholder="<?php echo wordpress_webhooks()->helpers->translate( 'Add IP address here...', 'ww-page-whitelist' ); ?>" />
			<?php wp_nonce_field( $whitelist_nonce_data['action'], $whitelist_nonce_data['arg'] ); ?>
			<input type="submit" name="submit" id="submit" class="btn btn-primary btn-md" value="<?php echo wordpress_webhooks()->helpers->translate( 'Add IP address', 'ww-page-whitelist' ); ?>">
		</form>
	</div>

	<div class="ironikus-whitelist-requests">
		<h2><?php echo wordpress_webhooks()->helpers->translate( 'Requested IP\'s', 'ww-page-whitelist' ); ?></h2>
		<div style="font-weight:normal;"><?php echo sprintf( wordpress_webhooks()->helpers->translate( 'Below you will find a list of all IP adresses that send requests to your %s API without being whitelisted. We always save the last 20 requests.', 'ww-page-whitelist' ), WW_NAME ); ?></div>

		<?php if( ! empty( $whitelist_requests ) ) : ?>
			<div class="accordion" id="whitelist_requests">
				<?php foreach( $whitelist_requests as $s_time => $data ) : 
					$shitelist_requests_count++;
					?>
					<div class="card">
					<div class="wpwh-whitelist-card-header card-header" whitelist-request-id="<?php echo $shitelist_requests_count; ?>" id="headingWhitelistDescription-<?php echo $shitelist_requests_count; ?>"  data-toggle="collapse" data-target="#collapseWhitelistDescriptionSub-<?php echo $shitelist_requests_count; ?>" aria-expanded="false" aria-controls="collapseWhitelistDescriptionSub-<?php echo $shitelist_requests_count; ?>">
						<button class="btn btn-link collapsed" type="button">
							<?php echo $data['ip']; ?> (<?php echo date( 'Y-m-d H:i:s', $s_time ); ?>)
						</button>
					</div>

					<div id="collapseWhitelistDescriptionSub-<?php echo $shitelist_requests_count; ?>" class="collapse" aria-labelledby="headingWhitelistDescription-<?php echo $shitelist_requests_count; ?>" data-parent="#whitelist_requests">
						<div class="card-body">
							<textarea id="preloader-json-<?php echo $shitelist_requests_count; ?>" style="display:none !important;">
								<?php echo json_encode( $data['data'] ); ?>
							</textarea>
							<pre id="ww-whitelist-json-<?php echo $shitelist_requests_count; ?>" class="json-body"></pre>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<div class="ww-empty">
				<?php echo wordpress_webhooks()->helpers->translate( 'You currently don\'t have any requested IP\'s.', 'ww-page-whitelist' ); ?>
			</div>
		<?php endif; ?>
	</div>
</div>