<?php
/**
 * Main plugin file
 * 
 * Contains plugin headers, constants and loads main class
 * 
 * @author Saurabh Shukla <saurabh@yapapaya.com>
 */
/*
  Plugin Name: Ajax Post Title
  Plugin URI: https://github.com/actual-saurabh/ajax-post-title
  Description: Loads Post Title via Ajax
  Version: 0.1
  Author: saurabhshukla
  Author URI: http://github.com/actual-saurabh/
  Text Domain: ya-apt
  Domain Path: /languages
  License: GNU General Public License v2 or later
 */

if ( ! defined( 'YA_APT_KEY_PREFIX' ) ) {
	/**
	 * Prefix for various keys
	 */
	define( 'YA_APT_KEY_PREFIX', 'ya-apt-' );
}

if ( ! defined( 'YA_APT_VER' ) ) {

	/**
	 * Plugin's Version
	 */
	define( 'YA_APT_VER', '0.1' ); // for enqueuing
}

if ( ! defined( 'YA_APT_URL' ) ) {
	/**
	 * Plugin's url
	 */
	define( 'YA_APT_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'YA_APT_PATH' ) ) {
	/**
	 * Plugin's filesystem path
	 */
	define( 'YA_APT_PATH', plugin_dir_path( __FILE__ ) );
}

/**
 * Include the main class
 */
require_once YA_APT_PATH . 'class-ya-apt.php';

$ya_apt = new YA_APT();

// initialise
$ya_apt->init();