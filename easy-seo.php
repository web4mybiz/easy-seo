<?php
/*
 * Plugin Name:       Easy SEO
 * Plugin URI:        https://github.com/web4mybiz/easy-seo
 * Description:       Simple plugin to improve review and improve SEO.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Rizwan Iliyas
 * Author URI:        https://wordpress.org/support/users/irizweb/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://wp-media.me/easy-seo/
 * Text Domain:       wpmedia-easy-seo
 * Domain Path:       /languages
 */


defined('ABSPATH') or die('You are not authorized to view this page');

if ( !defined( 'PLUGIN_BASE_NAME' ) ) {
    define( 'PLUGIN_BASE_NAME', plugin_basename( __FILE__ ) );
}
if ( !defined( 'PLUGIN_DIR_URL' ) ) {
    define( 'PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
}

// Composer autoload.
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

use Inc\Database;
use Inc\Admin;
use Inc\Dom;

if( class_exists('Inc\Admin') ){
	// Instantiate the plugin class
	new Inc\Admin();
}

if( class_exists('Inc\Database') ){
	// Instantiate the plugin class
	new Inc\Database();
}


// Trigger a function on plugin activation
register_activation_hook( __FILE__, array( '\Inc\Database', 'crawl_plugin_activation') );

// Trigger a function on plugin deactivation
register_deactivation_hook( __FILE__, array( '\Inc\Database', 'crawl_plugin_deactivation') );