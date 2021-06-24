<?php

/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package CGB
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

/**
 * Enqueue Gutenberg block assets for both frontend + backend.
 *
 * Assets enqueued:
 * 1. blocks.style.build.css - Frontend + Backend.
 * 2. blocks.build.js - Backend.
 * 3. blocks.editor.build.css - Backend.
 *
 * @uses {wp-blocks} for block type registration & related functions.
 * @uses {wp-element} for WP Element abstraction — structure of blocks.
 * @uses {wp-i18n} to internationalize the block's text.
 * @uses {wp-editor} for WP editor styles.
 * @since 1.0.0
 */
function emedia_finder_cgb_block_assets()
{ // phpcs:ignore
	// Register block styles for both frontend + backend.
	wp_register_style(
		'emedia_finder-cgb-style-css', // Handle.
		plugins_url('dist/blocks.style.build.css', dirname(__FILE__)), // Block style CSS.
		is_admin() ? array('wp-editor') : null, // Dependency to include the CSS after it.
		null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' ) // Version: File modification time.
	);

	// Register block editor script for backend.
	wp_register_script(
		'emedia_finder-cgb-block-js', // Handle.
		plugins_url('/dist/blocks.build.js', dirname(__FILE__)), // Block.build.js: We register the block here. Built with Webpack.
		array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor'), // Dependencies, defined above.
		null, // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: filemtime — Gets file modification time.
		true // Enqueue the script in the footer.
	);

	// Register block editor styles for backend.
	wp_register_style(
		'emedia_finder-cgb-block-editor-css', // Handle.
		plugins_url('dist/blocks.editor.build.css', dirname(__FILE__)), // Block editor CSS.
		array('wp-edit-blocks'), // Dependency to include the CSS after it.
		null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' ) // Version: File modification time.
	);

	// WP Localized globals. Use dynamic PHP stuff in JavaScript via `cgbGlobal` object.
	wp_localize_script(
		'emedia_finder-cgb-block-js',
		'cgbGlobal', // Array containing dynamic data for a JS Global.
		[
			'pluginDirPath' => plugin_dir_path(__DIR__),
			'pluginDirUrl'  => plugin_dir_url(__DIR__),
			// Add more data here that you want to access from `cgbGlobal` object.
		]
	);

	$emfinderHost = get_option('emediafinderdb_cdn_prefix');
	if ($emfinderHost != '') {
		wp_register_script('blockfind', $emfinderHost . '/finder/blockfind/components/javascript/blockfind.js', '', '', true);
		wp_enqueue_script('blockfind');
		wp_register_script('jquery', $emfinderHost . '/finder/blockfind/components/javascript/jquery-1.11.0.min.js', '', '', true);
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-datepicker');
		wp_register_script('popper', $emfinderHost . '/finder/blockfind/components/javascript/bootstrap/4.5.3/js/popper.min.js', '', '', true);
		wp_enqueue_script('popper');
		wp_register_script('bootstrap', $emfinderHost . '/finder/blockfind/components/javascript/bootstrap/4.5.3/js/bootstrap.min.js', '', '', true);
		wp_enqueue_script('bootstrap');
		wp_register_script('bootstrapcss', $emfinderHost . '/finder/blockfind/components/javascript/bootstrap/4.5.3/css/bootstrap.min.css', '', '', true);
		wp_enqueue_script('bootstrapcss');
	}

	wp_register_script(
		'myfirstscript',
		get_template_directory_uri() . '/myscript.js',   //
		array('jquery', 'jquery-ui'),                  //depends on these, however, they are registered by core already, so no need to enqueue them.
		false,
		false
	);
	wp_enqueue_script('myfirstscript');

	/**
	 * Register Gutenberg block on server-side.
	 *
	 * Register the block on server-side to ensure that the block
	 * scripts and styles for both frontend and backend are
	 * enqueued when the editor loads.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type#enqueuing-block-scripts
	 * @since 1.16.0
	 */
	register_block_type(
		'cgb/block-emedia-finder',
		array(
			'style'         => 'emedia_finder-cgb-style-css',
			'editor_script' => 'emedia_finder-cgb-block-js',
			'editor_style'  => 'emedia_finder-cgb-block-editor-css',
		)
	);

	wp_register_script(
		'emedia_finder-cgb-block-js', // Handle.
		plugins_url('/dist/blocks.build.js', dirname(__FILE__)),
		null,
		true
	);

	wp_localize_script(
		'emedia_finder-cgb-block-js',
		'credentials',
		array(
			'emediafinderdb_cdn_prefix' => get_option('emediafinderdb_cdn_prefix'),
			'emediafinderdb_entermediakey' => get_option('emediafinderdb_entermediakey'),
			'emediafinderdb_collectionid' => get_option('emediafinderdb_collectionid'),
			'emediafinderdb_enabled_users' => get_option('emediafinderdb_enabled_users'),
			'emediafinderdb_adminkey' => get_option('emediafinderdb_adminkey'),
			'emediafinderdb_current_wp_user' => wp_get_current_user(),
			'emediafinderdb_main_server' => get_option('emediafinderdb_main_server')
		)
	);
}

add_action('init', 'emedia_finder_cgb_block_assets');
