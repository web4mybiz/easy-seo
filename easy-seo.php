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

require_once( dirname( __FILE__).'/inc/class-admin-options.php' );


if( class_exists('EasySEOAdminOptions') ){

	// Instantiate the plugin class
	new EasySEOAdminOptions();

}