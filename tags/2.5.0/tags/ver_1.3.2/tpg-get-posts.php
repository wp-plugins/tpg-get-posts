<?php
/*
Plugin Name: TPG Get Posts
Plugin URI: http://www.tpginc.net/wordpress-plugins/
Description: Adds a shortcode tag [tpg_get_posts] to display posts on page.
Version: 1.3.2
Author: Criss Swaim
Author URI: http://www.tpginc.net/
*/

/*  The code is based on nurelm-get-posts

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * @todo ... Description
 *
 * 1) add excerpt handling 
 * 2) verify exclude code works 
 */



//error_reporting(E_ALL);

// define constants for plugin	
define("TGP_URL",plugin_dir_url(__FILE__));
define("TGP_DIR",plugin_dir_path(__FILE__));
define("TGP_CSS",plugin_dir_path(__FILE__)."css/");
define("TGP_CSS_URL",TGP_URL."css/");
define("TGP_JS_URL",TGP_URL."js/");
define("TGP_INC",plugin_dir_path(__FILE__)."inc/");
define("TGP_PLUGIN_BASE",plugin_basename(__FILE__));

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
	$tpg_gp_settings = new tpg_gp_settings;  
  
}else{  
	if (!class_exists("tpg_gp_process")) {
		require_once plugin_dir_path(__FILE__)."inc/tpg-gp-process.class.php";
	}
	// load front-end class functions
	$tpg_gp_process = new tpg_gp_process;
	
}  

?>