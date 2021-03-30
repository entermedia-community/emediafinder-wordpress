<?php
// register actions

use function PHPSTORM_META\type;

define('WP_DEBUG_LOG', '/tmp/wp-errors.log');
add_action('admin_init', 'emdb_admin_init');

function emdb_admin_init()
{
    register_setting('emdb-publish_options', 'emdb-publish_options', 'sanitize_text_field');

    register_setting('emdb-publish_options', 'emdb_cdn_prefix');
	register_setting('emdb-publish_options', 'emdb_entermediakey');
    register_setting('emdb-publish_options', 'emdb_collectionid');
	// register_setting('emdb-publish_options', 'emdb_mediadbappid');
    // register_setting('emdb-publish_options', 'emdb_user');
    // register_setting('emdb-publish_options', 'emdb_pass');

    //add_settings_section('api_settings', 'API Settings', 'plugin_section_text', 'emdb-publish');

    // register_setting('emdb-publish', 'emdb_cdn_prefix');
    // register_setting('emdb-publish', 'emdb_entermediakey');
    // register_setting('emdb-publish', 'emdb_mediadbappid');

    // add_settings_field('emdb_cdn', 'CDN', 'emdb_publish_cdn', 'emdb-publish', 'api_settings');
    // add_settings_field('emdb_user', 'User', 'emdb_publish_user', 'emdb-publish', 'api_settings');
    // add_settings_field('emdb_pass', 'Pass', 'emdb_publish_pass', 'emdb-publish', 'api_settings');

    // add_settings_field('emdb_entermediakey', 'EM Key', 'emdb-publish', 'api_settings');
    // add_settings_field('emdb_mediadbappid', 'API Key', 'emdb-publish', 'api_settings');
}


function emdb_plugin_settings_page()
{

    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    // Render the settings template
    include(sprintf("%s/templates/settings.php", dirname(__FILE__)));
}

// function plugin_section_text()
// {
//     echo '<p>Here you can set all the options for using the API</p>';
// }

// function emdb_publish_cdn()
// {
//     $options = get_option('emdb_cdn');
//     printf('<input id="emdb_cdn" name="emdb_cdn" type="text" value="%s" />',esc_attr($options));
// }

// function emdb_publish_user()
// {
//     $options = get_option('emdb_user');
//     printf('<input id="emdb_user" name="emdb_user" type="text" value="%s" />',esc_attr($options));
// }

// function emdb_publish_pass()
// {
//     $options = get_option('emdb_pass');
//     printf('<input id="emdb_pass" name="emdb_pass" type="text" value="%s" />',esc_attr($options));
// }


add_action('admin_menu', 'add_emdb_settings_menu');
function add_emdb_settings_menu()
{

    // Add a page to manage this plugin's settings
    add_options_page(
        'EnterMedia DB Plugin Settings', // Page Title
        'EnterMedia DB', // Menu Title
        'manage_options', // required permission/capability
        'emdb-publish', // menu slug
        'emdb_plugin_settings_page' // callback
    );
}
