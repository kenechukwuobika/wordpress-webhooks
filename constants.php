<?php

//Determines if plugin is in development or production environment
define('WW_DEV_MODE',       'development');

// Plugin version.
define( 'WW_VERSION',        '1.0.0' );

// Determines if the plugin is loaded
define( 'WW_SETUP',          true );

// Plugin Root File.
define( 'WW_PLUGIN_FILE',    __FILE__ );

// Plugin base.
define( 'WW_PLUGIN_BASE',    plugin_basename( WW_PLUGIN_FILE ) );

// Plugin Folder Path.
define( 'WW_PLUGIN_DIR',     plugin_dir_path( WW_PLUGIN_FILE ) );

// Plugin Folder URL.
define( 'WW_PLUGIN_URL',     plugin_dir_url( WW_PLUGIN_FILE ) );

// Plugin Root File.
//Defined within /core/includes/backend/classes/WordPress_Webhooks_Helpers.php
//Please check the translation function for the original definition
define( 'WW_TEXTDOMAIN',     'wp-webhooks-pro' );

// Plugin Store URL
define( 'PULL_BYTES',        'https://pullbytes.com' );

// Plugin Store ID
define( 'WW_PLUGIN_ID',    183 );

// News ID
define( 'WW_NEWS_FEED_ID', 1 );
 
 
?>