<?php
/*
Plugin Name: TPG Get Posts
Plugin URI: http://www.tpginc.net/wordpress-plugins/
Description: Adds a shortcode tag to display posts on static page.
Version: 2.02.02
Author: Criss Swaim
Author URI: http://www.tpginc.net/
License: This software is licensed under <a href="http://www.gnu.org/licenses/old-licenses/gpl-2.0.html">GNU GPL</a> version 2.0 or later.

Description:  TPG Get Postsadds a shortcode tag 'tpg-get-posts' to display posts within a static page or another post.  
*/

/**
 * @todo ... Description
 * 
 * 1) pagination 
 */

/*
 * Main controller for tpg-get-posts
 *
 * @package WordPress
 * @subpackage tpg-get-posts
 * @since 2.8
 *
 * determine if the plugin is being invoked in the frontend or backend and
 * load only the functions needed for that process
 * 
 * the tpg-get-post class sets up the base class that is extended for
 * either the frontend or backend processing.
 *
 */

//error_reporting(E_ALL ^ E_NOTICE);
//error_reporting(E_ALL);

// get base class
if (!class_exists("tpg_get_posts")) {
    require_once plugin_dir_path(__FILE__)."inc/class-tpg-get-posts.php";
}

//get plugin options & set paths
$gp = new tpg_get_posts(plugin_dir_url(__FILE__),plugin_dir_path(__FILE__),plugin_basename(__FILE__));

//get class factory
if (!class_exists("tpg_gp_factory")) {
    require_once($gp->gp_paths["dir"]."inc/class-tpg-gp-factory.php");
}
// load appropriate class based on admin or front-end
if(is_admin()){
    // load backend class function
    $tpg_gp_admin = tpg_gp_factory::create_admin($gp->gp_opts,$gp->gp_paths);
  
}else{
	
    // load front-end class functions
    $tpg_gp_process = tpg_gp_factory::create_process($gp->gp_opts,$gp->gp_paths);

    //load custom functions
    if (file_exists($gp->gp_paths['theme']."user-get-posts-custom-functions.php")) {
        include($gp->gp_paths['theme']."user-get-posts-custom-functions.php");
    }
}  

?>
