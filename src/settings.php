<?php

add_action('admin_init', 'emdb_admin_init');
function emdb_admin_init()
{
    register_setting('emdb-publish_options', 'emdb-publish_options', 'sanitize_text_field');

    register_setting('emdb-publish_options', 'emdb_cdn_prefix');
    register_setting('emdb-publish_options', 'emdb_email');
    register_setting('emdb-publish_options', 'emdb_entermediakey');
    register_setting('emdb-publish_options', 'emdb_collectionid');
    register_setting('emdb-publish_options', 'emdb_enabled_users');
    register_setting('emdb-publish_options', 'emdb_main_server');
    register_setting('emdb-publish_options', 'emdb_adminkey');
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

/* load js and styles for admin sites */
function load_custom_wp_admin_style()
{
    wp_register_style('custom_wp_admin_css_bootstrap', WP_PLUGIN_URL . '/emedia-finder/assets/bootstrap.min.css', false, '5.0.0-beta3');
    wp_enqueue_style('custom_wp_admin_css_bootstrap');
    wp_register_style('custom_wp_admin_css', WP_PLUGIN_URL . '/emedia-finder/assets/admin.css', false, '1.0.0');
    wp_enqueue_style('custom_wp_admin_css');
    wp_register_script('emdb_admin_js', WP_PLUGIN_URL . '/emedia-finder/assets/admin.js', '', '', true);
    wp_enqueue_script('emdb_admin_js');
}
add_action('admin_enqueue_scripts', 'load_custom_wp_admin_style');

