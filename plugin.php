<?php

/**
 * Plugin Name: eMediaFinder
 * Plugin URI: https://emediafinder.com
 * Description: eMediafinder Gallery selector
 * Author: EnterMediaDB team
 * Author URI: https://emediafinder.com
 * Version: @@Version@@
 *
 * @package CGB
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

/**
 * Block Initializer.
 */
require_once plugin_dir_path(__FILE__) . 'src/init.php';
require_once plugin_dir_path(__FILE__) . 'src/settings.php';
