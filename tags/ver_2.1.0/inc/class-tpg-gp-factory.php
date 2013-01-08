<?php
/*
 * Factory Class to return tpg_gp_ classes
 *
 * class factory used for consistent method of building classes for plugin
 *
 * @param    array    $gp_opts   options array
 * @param    array    $gp_paths  paths array
 * @return   class    $obj		class
*/


 class tpg_gp_factory {
	/**
	 * generate the process class
	 *
	 * determine if the lic is valid and if so try to return the premium class
	 * if prem class not found return basic class
	 *
	 * @package WordPress
	 * @subpackage tpg_get_posts
	 * @since 2.0
	 *
	 * @param    array    $gp_opts   options array
	 * @param    array    $gp_paths  paths array
	 * @return   class    $obj		 class
	 */
	function create_process($_opts,$_paths) {
		//var_dump($_paths);
		$_opts['valid-lic']=true;              //test 
		
		if ($_opts['valid-lic'] && file_exists($_paths['dir']."inc/class-tpg-gp-process-ext.php")){
		//if (file_exists($_paths['dir']."inc/class-tpg-gp-process-ext.php")){
			require_once("class-tpg-gp-process.php");
			require_once("class-tpg-gp-process-ext.php");
			$obj = new tpg_gp_process_ext($_opts,$_paths);
		}else {
			require_once("class-tpg-gp-process.php");
			$obj = new tpg_gp_process($_opts,$_paths);
		}
		
		return $obj;
	}
	
	/**
	 * generate the admin class
	 *
	 * create the admin class for back end	 
	 *
	 * @package WordPress
	 * @subpackage tpg_get_posts
	 * @since 2.0
	 *
	 * @param    array    $gp_opts   options array
	 * @param    array    $gp_paths  paths array
	 * @return   class 	  $obj		 class
	 */
	function create_admin($_opts,$_paths) {
		require_once("class-tpg-gp-admin.php");
		$obj = new tpg_gp_admin($_opts,$_paths);
		return $obj;
	}
	
	/**
	 * generate the lic validation class
	 *
	 * create the lic validation class and support maint functions	 
	 *
	 * @package WordPress
	 * @subpackage tpg_get_posts
	 * @since 2.0
	 *
	 * @param    array    $gp_opts   options array
	 * @param    array    $gp_paths  paths array
	 * @return   class 	  $obj		 class
	 */
	function create_lic_validation($_opts,$_paths,$module) {
		require_once("class-tpg-lic-validation.php");
		$obj = new tpg_lic_validation($_opts,$_paths,$module);
		return $obj;
	}
	
	/**
	 * generate the show ids class
	 *
	 * create the show ids class for admin pages 
	 *
	 * @package WordPress
	 * @subpackage tpg_get_posts
	 * @since 2.0
	 *
	 * @param    void
	 * @return   class 	  $obj		 class
	 */
	function create_show_ids() {
		require_once("class-tpg-show-ids.php");
		$obj = new tpg_show_ids();
		return $obj;
	}
	
	/**
	 * generate the paypal button class
	 *
	 * create the paypal class	 
	 *
	 * @package WordPress
	 * @subpackage tpg_get_posts
	 * @since 2.0
	 *
	 * @param    void
	 * @return   class 	  $obj		 class
	 */
	function create_paypal_button() {
		require_once("class-tpg-pp-donate-button.php");
		$obj = new tpg_pp_donate_button();
		return $obj;
	}
 }