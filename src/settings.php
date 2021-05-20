<?php

if (!function_exists('emediafinderdb_admin_init')) {
    add_action('admin_init', 'emediafinderdb_admin_init');
    function emediafinderdb_admin_init()
    {
        register_setting('emediafinderdb-publish_options', 'emediafinderdb-publish_options', 'sanitize_text_field');

        register_setting('emediafinderdb-publish_options', 'emediafinderdb_cdn_prefix');
        register_setting('emediafinderdb-publish_options', 'emediafinderdb_email');
        register_setting('emediafinderdb-publish_options', 'emediafinderdb_entermediakey');
        register_setting('emediafinderdb-publish_options', 'emediafinderdb_collectionid');
        register_setting('emediafinderdb-publish_options', 'emediafinderdb_enabled_users');
        register_setting('emediafinderdb-publish_options', 'emediafinderdb_main_server');
        register_setting('emediafinderdb-publish_options', 'emediafinderdb_adminkey');
    }
}

if (!function_exists('emediafinderdb_add_settings_menu') && !function_exists('emediafinderdb_plugin_settings_page')) {
    add_action('admin_menu', 'emediafinderdb_add_settings_menu');
    function emediafinderdb_plugin_settings_page()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
        include(sprintf("%s/templates/settings.php", dirname(__FILE__)));
    }
    function emediafinderdb_add_settings_menu()
    {
        add_options_page(
            'eMediaFinder Settings', // Page Title
            'eMediaFinder', // Menu Title
            'manage_options', // required permission/capability
            'emdb-publish', // menu slug
            'emediafinderdb_plugin_settings_page' // callback
        );
    }
}
if (!function_exists('emediafinderdb_load_custom_wp_admin_style')) {
    /* load js and styles for admin sites */
    add_action('admin_enqueue_scripts', 'emediafinderdb_load_custom_wp_admin_style');
    function emediafinderdb_load_custom_wp_admin_style()
    {
        $plugin_path = plugin_dir_url(__FILE__);
        wp_register_style('custom_wp_admin_css_bootstrap', $plugin_path . 'assets/bootstrap.min.css', false, '5.0.0-beta3');
        wp_enqueue_style('custom_wp_admin_css_bootstrap');
        wp_register_style('custom_wp_admin_css', $plugin_path . 'assets/admin.css', false, '1.0.0');
        wp_enqueue_style('custom_wp_admin_css');
        wp_register_script('emediafinderdb_admin_js', $plugin_path . 'assets/admin.js', '', '', true);
        wp_enqueue_script('emediafinderdb_admin_js');
    }
}
