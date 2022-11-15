<?php
/*
Plugin Name: S-Feed
Plugin URI:  https://social-feed.tech/
Description: Access Instagram data using the Basic Display API via S-Feed proxy.
Author:      Marco Pelloni
Author URI:  https://marcopelloni.com/
License:     GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Version number is automatically adjusted by semantic-release-bot on release, do not adjust manually:
Version: 1.0.0
*/

if ( ! defined( 'ABSPATH' ) ) {
    die();
}

// Definitions
define('SFEED_PLUGIN_PATH', plugin_dir_path( __FILE__ ));
define('SFEED_PLUGIN_URL', plugin_dir_url( __FILE__ ));

// Classes
require_once(SFEED_PLUGIN_PATH . 'src/php/admin.php');
require_once(SFEED_PLUGIN_PATH . 'src/php/functions.php');
require_once(SFEED_PLUGIN_PATH . 'src/php/users.php');

// Actions
add_action('admin_menu', 'sfeed_custom_admin_menu');
add_action('admin_enqueue_scripts', 'sfeed_styles_and_scripts');
add_action('wp_ajax_sfeed_save_url', 'sfeed_save_url');
add_action('wp_ajax_sfeed_remove_url', 'sfeed_remove_url');

// Shortcode
add_shortcode('sfeed', 'sfeed_shortcode'); 

// Updates
require_once(SFEED_PLUGIN_PATH . 'lib/plugin-update-checker-5.0/plugin-update-checker.php');
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://social-feed.tech/releases/s-feed.json',
	__FILE__,
	's-feed'
);