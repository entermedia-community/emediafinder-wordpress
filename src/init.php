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

	// wp_register_script(
	// 	'emedia_finder-cgb-block-js', // Handle.
	// 	plugins_url('src/blockfind.js', dirname(__FILE__)), // Block.build.js: We register the block here. Built with Webpack.
	// 	array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor'), // Dependencies, defined above.
	// 	null, // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: filemtime — Gets file modification time.
	// 	true // Enqueue the script in the footer.
	// );
	// $emfinderHost = 'https://critobaltunnel.t47.entermediadb.net';
	$emfinderHost = get_option('emdb_cdn_prefix');
	// $entermedia_key = get_option('emdb_entermediakey');
	if ($emfinderHost != '') {
		wp_register_script('blockfind', $emfinderHost . '/finder/blockfind/components/javascript/blockfind.js', '', '', true);
		wp_enqueue_script('blockfind');
		wp_register_script('jquery', $emfinderHost . '/finder/blockfind/components/javascript/jquery-3.3.1.min.js', '', '', true);
		wp_enqueue_script('jquery');
		wp_register_script('bootstrap', $emfinderHost . '/finder/blockfind/components/javascript/bootstrap/4.5.3/js/bootstrap.min.js', '', '', true);
		wp_enqueue_script('bootstrap');
		wp_register_script('popper', $emfinderHost . '/finder/blockfind/components/javascript/bootstrap/4.5.3/js/popper.min.js', '', '', true);
		wp_enqueue_script('popper');
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


	// $cdn_prefix = 'http://localhost:8089';
	// $mediadbappid = '/finder/blockfind';
	// wp_enqueue_script('embed_collection_js_entermedia', $cdn_prefix . $mediadbappid . '/components/javascript/liveajax/liveajax.js');

	// wp_enqueue_style('embed_collection_css_results', $cdn_prefix . $mediadbappid . '/components/javascript/bootstrap/4.5.3/css/bootstrap.min.css');
	// wp_enqueue_style('embed_collection_css_mediaplayer', $cdn_prefix . $mediadbappid . '/components/javascript/jquery-ui/1.12/jquery-ui.css');
	// wp_enqueue_style('embed_collection_css_mediaplayer', $cdn_prefix . $mediadbappid . '/components/javascript/bootstrap/fonts/css/fontawesome-all.min.css');
	// wp_enqueue_style('embed_collection_css_mediaplayer', $cdn_prefix . $mediadbappid . '/components/javascript/grid/grid.css');

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
			'emdb_cdn_prefix' => get_option('emdb_cdn_prefix'),
			'emdb_entermediakey' => get_option('emdb_entermediakey'),
			'emdb_collectionid' => get_option('emdb_collectionid')
		)
	);

	// require_once plugin_dir_path(__FILE__) . 'blockfind.js';
}

// Hook: Block assets.
add_action('init', 'emedia_finder_cgb_block_assets');


// globals?
// $jsessionid = "";

// add_action('init', 'set_cors_headers');
// function set_cors_headers()
// {
// 	header('Access-Control-Allow-Origin: *', true);
// 	header('Referrer-Policy: unsafe-url', true);
// 	header('X-XSS-Protection: 1; mode=block', true);
// 	header('X-Content-Type-Options: nosniff', true);
// }

// custom
// add_action('init', 'maybe_direct_html_output');
// function maybe_direct_html_output()
// {
// 	$htmlrelpath = $_SERVER['REQUEST_URI'];

// 	if (!$htmlrelpath) {
// 		return;
// 	}


// 	if (strpos($htmlrelpath, "/finder") === 0) {
// 		// $htmlfilepath = WP_CONTENT_DIR.$htmlrelpath;
// 		// echo "hello world";
// 		$cdn_prefix = "https://em10.entermediadb.org";
// 		// $mediadbappid = "finder";
// 		$collection_page_url = $cdn_prefix . $htmlrelpath;

// 		// echo $collection_page_url;
// 		$emkey = "adminmd5421c0af185908a6c0c40d50fd5e3f16760d5580bc";
// 		$opts = array(
// 			'http' => array(
// 				'header' => array(
// 					"X-token: $emkey",
// 					"X-tokentype: entermedia",
// 					"Cookie: " . $GLOBALS['jsessionid']
// 				)
// 			)
// 		);

// 		$context = stream_context_create($opts);
// 		$content =  file_get_contents($collection_page_url, false, $context);

// 		file_get_contents('http://example.org');

// 		$cookies = array();
// 		foreach ($http_response_header as $hdr) {
// 			if (preg_match('/^Set-Cookie:\s*([^;]+)/', $hdr, $matches)) {
// 				parse_str($matches[1], $tmp);
// 				$cookies += $tmp;
// 				if (strpos($tmp, "JSESSIONID") === 0) {
// 					$GLOBALS['jsessionid'] = $tmp;
// 				}
// 			}
// 		}
// 		// print_r($cookies);
// 		echo $content;
// 		exit;
// 		// if (!file_exists($htmlfilepath)) {return;}
// 		// echo file_get_contents($htmlrelpath); exit;
// 	}
// }
