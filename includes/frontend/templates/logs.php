<?php


$current_url = wordpress_webhooks()->helpers->get_current_url(false);
$clear_form_url = wordpress_webhooks()->helpers->get_current_url();
$log_nonce_data = wordpress_webhooks()->settings->get_log_nonce();
$log_count = wordpress_webhooks()->logs->get_log_count();

//Create new Wehook
if( isset( $_POST['ww_delete_logs'] ) ) {
	if ( ! check_admin_referer( $log_nonce_data['action'], $log_nonce_data['arg'] ) ) {
		return;
	}

	wordpress_webhooks()->logs->delete_table();
}

$current_items = 10;
$current_offset = 0;

if( isset( $_POST['item_count'] ) && isset( $_POST['item_offset'] ) ){

	$current_items = intval( $_POST['item_count'] );
	$current_offset = intval( $_POST['item_offset'] );

	$logs = wordpress_webhooks()->logs->get_log( $current_offset, $current_items );
} else {
	$logs = wordpress_webhooks()->logs->get_log();
}

?>
<h2><?php echo wordpress_webhooks()->helpers->translate( 'Logs', 'ww-page-logs' ); ?></h2>

<div>
	<?php if( wordpress_webhooks()->whitelabel->is_active() && ! empty( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_text_logs' ) ) ) : ?>
		<?php echo wordpress_webhooks()->helpers->translate( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_text_logs' ), 'admin-settings-license' ); ?>
	<?php else : ?>
		<?php echo wordpress_webhooks()->helpers->translate( 'You see this page because you have activated the logging functionality. This page will log every single request of your website that was triggered either by a valid trigger or by a valid action.', 'ww-page-logs' ); ?>
	<?php endif; ?>
</div>
<div class="ww-logs">
	<div class="ww-log-view">
		<div class="ww-log-list">

		<?php if( ! empty( $logs ) ) : ?>
			<?php foreach( $logs as $data ) : 
				
				$log_time = date( 'Y-m-d H:i:s', strtotime( $data->log_time ) );
				$message = htmlspecialchars( base64_decode( $data->message ) );
				$content_backend = base64_decode( $data->content );
				$identifier = '';
				$webhook_type = '';
				$webhook_name = '';
				$endpoint_response = '';
				$content = '';
				if( wordpress_webhooks()->helpers->is_json( $content_backend ) ){
						$single_data = json_decode( $content_backend, true );
						if( $single_data && is_array( $single_data ) ){
							
							if( isset( $single_data['request_data'] ) ){
								$content = wordpress_webhooks()->logs->sanitize_array_object_values( $single_data['request_data'] );
							}
							
							if( isset( $single_data['response_data'] ) ){
								$endpoint_response = wordpress_webhooks()->logs->sanitize_array_object_values( $single_data['response_data'] );
							}

							if( isset( $single_data['identifier'] ) ){
								$identifier = htmlspecialchars( $single_data['identifier'] );
							}

							if( isset( $single_data['webhook_type'] ) ){
								$webhook_type = htmlspecialchars( $single_data['webhook_type'] );
							}

							if( isset( $single_data['webhook_name'] ) ){
								$webhook_name = htmlspecialchars( $single_data['webhook_name'] );
							}

						}
				}

				?>
				<div id="log-element-<?php echo $data->id; ?>" class="log-element" ww-log-id="<?php echo $data->id; ?>">
					#<?php echo $data->id; ?> <?php echo ( $webhook_type ) ? $webhook_type : ''; ?> <?php echo $data->log_time; ?>
					<div id="log-data-<?php echo $data->id; ?>" style="display:none !important;">
						<div id="ww-log-content-<?php echo $data->id; ?>">

							<div class="row">

								<?php if( ! empty( $log_time ) ) : ?>
									<div class="col-sm-4">
										<div class="card">
											<div class="card-header">
												<?php echo wordpress_webhooks()->helpers->translate( 'Log time:', 'ww-page-log' ); ?>
											</div>
											<div class="card-body">
												<p class="card-text"><?php echo $log_time; ?></p>
											</div>
										</div>
									</div>
								<?php endif; ?>
								<?php if( ! empty( $webhook_type ) ) : ?>
									<div class="col-sm-4">
										<div class="card">
											<div class="card-header">
												<?php echo wordpress_webhooks()->helpers->translate( 'The webhook type:', 'ww-page-log' ); ?>
											</div>
											<div class="card-body">
												<p class="card-text"><?php echo $webhook_type; ?></p>
											</div>
										</div>
									</div>
								<?php endif; ?>

								<?php if( ! empty( $message ) ) : ?>
									<div class="col-sm-4">
										<div class="card">
											<div class="card-header">
												<?php echo wordpress_webhooks()->helpers->translate( 'The message:', 'ww-page-log' ); ?>
											</div>
											<div class="card-body">
												<p class="card-text"><?php echo $message; ?></p>
											</div>
										</div>
									</div>
								<?php endif; ?>

								<?php 
								
								/**
								 * TRIGGER HTML
								 */
								
								if( $webhook_type === 'trigger' ) : ?>

									<?php if( ! empty( $webhook_name ) ) : ?>
										<div class="col-sm-4">
											<div class="card">
												<div class="card-header">
													<?php echo wordpress_webhooks()->helpers->translate( 'The webhook trigger (Send Data) name:', 'ww-page-log' ); ?>
												</div>
												<div class="card-body">
													<p class="card-text"><?php echo $webhook_name; ?></p>
												</div>
											</div>
										</div>
									<?php endif; ?>
									<?php if( ! empty( $identifier ) ) : ?>
										<div class="col-sm-4">
											<div class="card">
												<div class="card-header">
													<?php echo wordpress_webhooks()->helpers->translate( 'The URL the request was sent to:', 'ww-page-log' ); ?>
												</div>
												<div class="card-body">
													<p class="card-text"><?php echo $identifier; ?></p>
												</div>
											</div>
										</div>
									<?php endif; ?>

									<?php if( isset( $content ) ) : ?>
										<div class="col-sm-12">
											<div class="card">
												<div class="card-header">
													<?php echo wordpress_webhooks()->helpers->translate( 'Outgoing data:', 'ww-page-log' ); ?>
												</div>
												<div class="card-body">
													<p class="card-text">
														<?php echo wordpress_webhooks()->helpers->translate( 'In the JSON down below contains the whole request we sent based on your fired trigger. You will find the data within the body key.', 'ww-page-log' ); ?>
													</p>
													<div id="ww-log-json-<?php echo $data->id; ?>" class="wpwhlog-visually-hidden">
														<?php echo json_encode( $content, JSON_HEX_QUOT | JSON_HEX_TAG ); ?>
													</div>
													<pre id="ww-log-json-output-<?php echo $data->id; ?>" class="json-body"></pre>
												</div>
											</div>
										</div>
									<?php endif; ?>

									<?php if( isset( $endpoint_response ) ) : ?>
										<div class="col-sm-12">
											<div class="card">
												<div class="card-header">
													<?php echo wordpress_webhooks()->helpers->translate( 'Endpoint Response:', 'ww-page-log' ); ?>
												</div>
												<div class="card-body">
													<p class="card-text">
														<?php echo wordpress_webhooks()->helpers->translate( 'In JSON contains the data we got back from the server where we sent the webhook request to.', 'ww-page-log' ); ?>
													</p>
													<div id="ww-log-json-endpoint-<?php echo $data->id; ?>" class="wpwhlog-visually-hidden">
														<?php echo json_encode( $endpoint_response, JSON_HEX_QUOT | JSON_HEX_TAG ); ?>
													</div>
													<pre id="ww-log-json-endpoint-output-<?php echo $data->id; ?>" class="json-body"></pre>
												</div>
											</div>
										</div>
									<?php endif; ?>

								<?php 
								
								/**
								 * ACTION HTML
								 */

								elseif( $webhook_type === 'action' ) : ?>

									<?php if( ! empty( $webhook_name ) ) : ?>
										<div class="col-sm-4">
											<div class="card">
												<div class="card-header">
													<?php echo wordpress_webhooks()->helpers->translate( 'The webhook action (Receive Data) name:', 'ww-page-log' ); ?>
												</div>
												<div class="card-body">
													<p class="card-text"><?php echo $webhook_name; ?></p>
												</div>
											</div>
										</div>
									<?php endif; ?>
									<?php if( ! empty( $identifier ) ) : ?>
										<div class="col-sm-4">
											<div class="card">
												<div class="card-header">
													<?php echo wordpress_webhooks()->helpers->translate( 'The IP where the webhook action came from:', 'ww-page-log' ); ?>
												</div>
												<div class="card-body">
													<p class="card-text"><?php echo $identifier; ?></p>
												</div>
											</div>
										</div>
									<?php endif; ?>

									<?php if( isset( $content['content_type'] ) ) : ?>
										<div class="col-sm-4">
											<div class="card">
												<div class="card-header">
													<?php echo wordpress_webhooks()->helpers->translate( 'Content type:', 'ww-page-log' ); ?>
												</div>
												<div class="card-body">
													<p class="card-text">
														<?php echo $content['content_type']; ?>
													</p>
												</div>
											</div>
										</div>
									<?php endif; ?>

									<?php if( isset( $content['content'] ) ) : ?>
										<div class="col-sm-12">
											<div class="card">
												<div class="card-header">
													<?php echo wordpress_webhooks()->helpers->translate( 'Incoming data:', 'ww-page-log' ); ?>
												</div>
												<div class="card-body">
													<p class="card-text">
														<?php echo wordpress_webhooks()->helpers->translate( 'In the JSON down below, you will find further details on the data that was sent to your webhook URL.', 'ww-page-log' ); ?>
													</p>
													<div id="ww-log-json-<?php echo $data->id; ?>" class="wpwhlog-visually-hidden">
														<?php echo json_encode( $content['content'] ); ?>
													</div>
													<pre id="ww-log-json-output-<?php echo $data->id; ?>" class="json-body"></pre>
												</div>
											</div>
										</div>
									<?php endif; ?>

								<?php 
								
								/**
								 * FALLBACK HTML
								 */

								else : ?>

									<?php if( ! empty( $webhook_name ) ) : ?>
										<div class="col-sm-6">
											<div class="card">
												<div class="card-header">
													<?php echo wordpress_webhooks()->helpers->translate( 'The webhook name:', 'ww-page-log' ); ?>
												</div>
												<div class="card-body">
													<p class="card-text"><?php echo $webhook_name; ?></p>
												</div>
											</div>
										</div>
									<?php endif; ?>
									<?php if( ! empty( $identifier ) ) : ?>
										<div class="col-sm-6">
											<div class="card">
												<div class="card-header">
													<?php echo wordpress_webhooks()->helpers->translate( 'The identifier:', 'ww-page-log' ); ?>
												</div>
												<div class="card-body">
													<p class="card-text"><?php echo $identifier; ?></p>
												</div>
											</div>
										</div>
									<?php endif; ?>
									<?php if( ! empty( $content ) ) : ?>
										<div class="col-sm-12">
											<div class="card">
												<div class="card-header">
													<?php echo wordpress_webhooks()->helpers->translate( 'Data details:', 'ww-page-log' ); ?>
												</div>
												<div class="card-body">
													<p class="card-text">
														<?php echo wordpress_webhooks()->helpers->translate( 'These details contain further information about the sent data', 'ww-page-log' ); ?>
													</p>
													<div id="ww-log-json-<?php echo $data->id; ?>" class="wpwhlog-visually-hidden">
														<?php echo $content; ?>
													</div>
													<pre id="ww-log-json-output-<?php echo $data->id; ?>" class="json-body"></pre>
												</div>
											</div>
										</div>
									<?php endif; ?>

								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		<?php else : ?>
		<div class="ww-empty">
			<?php echo wordpress_webhooks()->helpers->translate( 'You currently don\'t have any logs available.', 'ww-page-logs' ); ?>
		</div>
		<?php endif; ?>
		</div>
		<div id="ww-log-data">
			<div id="ww-log-content">
				<?php echo wordpress_webhooks()->helpers->translate( 'Click on one of the elements on the left to see its data.', 'ww-page-log' ); ?>
			</div>
		</div>
	</div>

	<div class="ww-log-action-wrapper">
		<div class="alignleft">
			<div class="ww-log-action">
				<form method="post" action="<?php echo $clear_form_url; ?>">
					<?php wp_nonce_field( $log_nonce_data['action'], $log_nonce_data['arg'] ); ?>
					<input type="hidden" name="ww_delete_logs" value="1">
					<input type="submit" name="submit" id="submit" class="btn btn-primary btn-md" value="<?php echo wordpress_webhooks()->helpers->translate( 'Delete Logs', 'ww-page-logs' ) . ' (' . intval( $log_count ) . ')'; ?>">
				</form>
			</div>
		</div>
		<div class="tablenav-pages">
			<form method="post" action="<?php echo $clear_form_url; ?>">
				<label>
					<span><?php echo wordpress_webhooks()->helpers->translate( 'Number of logs', 'ww-page-logs' ); ?></span>
					<input type="text" class="form-control" name="item_count" value="<?php echo $current_items; ?>" placeholder="<?php echo wordpress_webhooks()->helpers->translate( 'E.g. 10', 'ww-page-logs' ); ?>">
				</label>
				<label>
					<span><?php echo wordpress_webhooks()->helpers->translate( 'Offset', 'ww-page-logs' ); ?></span>
					<input type="text" class="form-control" name="item_offset" value="<?php echo $current_offset; ?>" placeholder="<?php echo wordpress_webhooks()->helpers->translate( 'E.g. 5', 'ww-page-logs' ); ?>">
				</label>
				<input type="submit" name="submit" id="submit" class="btn btn-primary btn-md" value="<?php echo wordpress_webhooks()->helpers->translate( 'Filter Logs', 'ww-page-logs' ); ?>">
			</form>
		</div>
	</div>
</div>