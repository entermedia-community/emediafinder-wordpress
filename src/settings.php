<?php

use function PHPSTORM_META\type;

define('WP_DEBUG_LOG', '/tmp/wp-errors.log');
add_action('admin_init', 'emdb_admin_init');

function emdb_admin_init()
{
    register_setting('emdb-publish_options', 'emdb-publish_options', 'sanitize_text_field');

    register_setting('emdb-publish_options', 'emdb_cdn_prefix');
    register_setting('emdb-publish_options', 'emdb_email');
    register_setting('emdb-publish_options', 'emdb_entermediakey');
    register_setting('emdb-publish_options', 'emdb_collectionid');
}

function emdb_plugin_settings_page()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    include(sprintf("%s/templates/settings.php", dirname(__FILE__)));
}


add_action('admin_menu', 'add_emdb_settings_menu');
function add_emdb_settings_menu()
{
    add_options_page(
        'eMediaFinder Settings', // Page Title
        'eMediaFinder', // Menu Title
        'manage_options', // required permission/capability
        'emdb-publish', // menu slug
        'emdb_plugin_settings_page' // callback
    );
}