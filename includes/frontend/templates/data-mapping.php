<?php

$templates = wordpress_webhooks()->data_mapping->get_data_mapping();
$settings = wordpress_webhooks()->settings->get_data_mapping_key_settings();

?>
<?php add_ThickBox(); ?>
<h2><?php echo wordpress_webhooks()->helpers->translate( 'Data Mapping', 'ww-page-data-mapping' ); ?></h2>

<div>
  <?php if( wordpress_webhooks()->whitelabel->is_active() && ! empty( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_text_data_mapping' ) ) ) : ?>
		<?php echo wordpress_webhooks()->helpers->translate( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_text_data_mapping' ), 'admin-settings-license' ); ?>
  <?php else : ?>
    <?php echo sprintf(wordpress_webhooks()->helpers->translate( 'Create your own data mapping templates down below. Mapping the data allows you to redirect certain data keys to new ones to fit the standards of %1$s (For incoming webhook actions) or your external service (For outgoing webhook triggers). For more information, please check out the data mapping documentation by clicking <a href="%2$s" target="_blank" >here</a>.', 'ww-page-data-mapping' ), WW_NAME, 'https://ironikus.com/docs/knowledge-base/how-to-use-data-mapping/'); ?>
  <?php endif; ?>
</div>

<?php if( ! empty( $templates ) ) : ?>
    <div class="ww-data-mapping-template-wrapper">
        <select id="ww-data-mapping-template-select">
            <option value="empty"><?php echo wordpress_webhooks()->helpers->translate( 'Choose...', 'ww-page-data-mapping' ); ?></option>
            <?php foreach( $templates as $template ) : ?>
                <option value="<?php echo $template->id; ?>"><?php echo wordpress_webhooks()->helpers->translate( $template->name, 'ww-page-data-mapping' ); ?></option>
            <?php endforeach; ?>
        </select>
        <img id="ww-data-mapper-template-loader-img" class="ironikus-loader" src="<?php echo WW_PLUGIN_URL . 'includes/frontend/assets/img/loader-black.gif'; ?>" />
    </div>
    <?php else : ?>
    <div class="ww-empty">
        <?php echo wordpress_webhooks()->helpers->translate( 'You currently don\'t have any data mapping templates available. Please create one first.', 'ww-page-data-mapping' ); ?>
    </div>
<?php endif; ?>

<div id="ww-data-mapping-key-settings">
    <?php
      echo json_encode( $settings, JSON_HEX_QUOT | JSON_HEX_TAG );
    ?>

</div>

<div id="ww-data-mapping-actions"></div>
<div id="ww-data-mapping-wrapper">
    <div class="ww-empty">
        <?php echo wordpress_webhooks()->helpers->translate( 'Please choose a template first.', 'ww-page-data-mapping' ); ?>
    </div>
</div>

<div class="ww-data-mapping-preview">
  <div class="row">
    <div class="col-12">
    <h2><?php echo wordpress_webhooks()->helpers->translate( 'Data Mapping Preview', 'ww-page-data-mapping' ); ?></h2>

    <div>
    <?php if( wordpress_webhooks()->whitelabel->is_active() && ! empty( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_text_data_mapping_preview' ) ) ) : ?>
      <?php echo wordpress_webhooks()->helpers->translate( wordpress_webhooks()->whitelabel->get_setting( 'ww_whitelabel_custom_text_data_mapping_preview' ), 'admin-settings-license' ); ?>
    <?php else : ?>
      <?php echo wordpress_webhooks()->helpers->translate( 'You can use the preview down below to apply your data mapping template to some given data. This allows you to see instant results for your defined data mapping template. <strong>Please note that the preview uses the currently given data mapping template with all of its unsaved changes.</strong> If you want to check it with the saved changes, simply refresh the page without making changes to the mapping template.', 'ww-page-data-mapping' ); ?>
      <br>
      <?php echo sprintf( wordpress_webhooks()->helpers->translate( 'To get started, you can simply include your <strong>JSON-, Query-, or XML-string</strong> down below. <a href="%s" target="_blank">Click here to learn more</a>.', 'ww-page-data-mapping' ), 'https://ironikus.com/docs/knowledge-base/advanced-data-mapping/' ); ?>
    <?php endif; ?>
    </div>
    </div>
  </div>
  <div class="row ww-data-mapping-preview-editor">
    <div class="col-5 ww-data-mapping-preview-input-wrapper">
      <h4 class="negative-headline"><?php echo wordpress_webhooks()->helpers->translate( 'Before Data Mapping', 'ww-page-data-mapping' ); ?></h4>
      <textarea id="ww-data-mapping-preview-input" placeholder="<?php echo wordpress_webhooks()->helpers->translate( 'Include your payload here.', 'ww-page-data-mapping' ); ?>"></textarea>
    </div>
    <div class="col-2 ww-data-mapping-preview-submit-wrapper">
      <p class="btn btn-primary h30 ironikus-data-mapping-preview-submit-button" mapping-type="trigger" >
        <span class="ironikus-save-text active"><?php echo wordpress_webhooks()->helpers->translate( 'Apply for Send Data', 'ww-page-actions' ); ?></span>
        <img class="ironikus-loader" src="<?php echo WW_PLUGIN_URL . 'includes/frontend/assets/img/loader.gif'; ?>" />
      </p>
      <p class="btn btn-primary h30 ironikus-data-mapping-preview-submit-button" mapping-type="action" >
        <span class="ironikus-save-text active"><?php echo wordpress_webhooks()->helpers->translate( 'Apply for Receive Data', 'ww-page-actions' ); ?></span>
        <img class="ironikus-loader" src="<?php echo WW_PLUGIN_URL . 'includes/frontend/assets/img/loader.gif'; ?>" />
      </p>
    </div>
    <div class="col-5 ww-data-mapping-preview-output-wrapper">
      <h4 class="negative-headline"><?php echo wordpress_webhooks()->helpers->translate( 'After Data Mapping', 'ww-page-data-mapping' ); ?></h4>
      <pre id="ww-data-mapping-preview-output" class="json-body"></pre>
    </div>
  </div>
</div>

<div class="ww-data-mapping-helpers">
  <h2><?php echo wordpress_webhooks()->helpers->translate( 'Helpers', 'ww-page-data-mapping' ); ?></h2>
  <table class="table">
    <thead>
      <tr>
        <th scope="col"><?php echo wordpress_webhooks()->helpers->translate( 'Tag', 'ww-page-data-mapping' ); ?></th>
        <th scope="col"><?php echo wordpress_webhooks()->helpers->translate( 'Used by', 'ww-page-data-mapping' ); ?></th>
        <th scope="col"><?php echo wordpress_webhooks()->helpers->translate( 'Description', 'ww-page-data-mapping' ); ?></th>
      </tr>
    </thead>
    <tbody>

      <tr>
        <td scope="row"><strong>{:</strong>key<strong>:}</strong></td>
        <td>
          <?php echo wordpress_webhooks()->helpers->translate( 'Actions', 'ww-page-data-mapping' ); ?>, <?php echo wordpress_webhooks()->helpers->translate( 'Triggers', 'ww-page-data-mapping' ); ?>
        </td>
        <td>
          <?php echo wordpress_webhooks()->helpers->translate( 'By defining {:some_key:} within a <strong>Data Value</strong> field, it will be replaced by the content of the given key of the response. You can also use multiple of these tags. Example: you get the key first_name and you want to add it to the following string: "This is my first name: MYNAME",  you can do the following: "This is my first name: {:first_name:}" ', 'ww-page-data-mapping' ); ?>
        </td>
      </tr>
    </tbody>
  </table>
</div>