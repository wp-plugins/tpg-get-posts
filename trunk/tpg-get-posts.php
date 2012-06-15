<?php
/*
Plugin Name: TPG Get Posts
Plugin URI: http://www.tpginc.net/wordpress-plugins/
Description: Adds a shortcode tag to display posts on static page.
Version: 1.3.5
Author: Criss Swaim
Author URI: http://www.tpginc.net/
License: This software is licensed under <a href="http://www.gnu.org/licenses/old-licenses/gpl-2.0.html">GNU GPL</a> version 2.0.

Description:  TPG Get Posts adds a shortcode tag to display posts within a static page or another post.  
*/

/**
 * @todo ... Description
 * 
 * 1) verify exclude code works
 * 2) pagination 
 */



//error_reporting(E_ALL);

/*
 * Main controller for tpg_get_posts
 *
 * @package WordPress
 * @subpackage tpg_get_posts
 * @since 2.8
 *
 * determine if the plugin is being invoked in the frontend or backend and
 * load only the functions needed for that process
 * 
 * the tpg_get_post class sets up the base class that is extended for
 * either the frontend or backend processing.
 *
 */
 
// get base class
if (!class_exists("tpg_get_posts")) {
		require_once plugin_dir_path(__FILE__)."inc/tpg-gp.class.php";
}

// load appropriate class based on admin or front-end
if(is_admin()){
	if (!class_exists("tpg_gp_settings")) {
		require_once plugin_dir_path(__FILE__)."inc/tpg-gp-settings.class.php";
	}
    // load backend class function
	$tpg_gp_settings = new tpg_gp_settings(plugin_dir_url(__FILE__),plugin_dir_path(__FILE__),plugin_basename(__FILE__));  
  
}else{  
	if (!class_exists("tpg_gp_process")) {
		require_once plugin_dir_path(__FILE__)."inc/tpg-gp-process.class.php";
	}
	// load front-end class functions
	$tpg_gp_process = new tpg_gp_process(plugin_dir_url(__FILE__),plugin_dir_path(__FILE__),plugin_basename(__FILE__));
	
}  

?>