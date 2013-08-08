<?php
/*
 *	Base class for TPG Get Posts
 *	this class is gets the options and sets paths
 *
 * @package WordPress
 * @subpackage tpg_get_posts
 * @since 2.0
 *
 */
class tpg_get_posts {
	// path variables	 
	public $gp_paths=array(
			"url" => '',
			"dir" => '',
			"css" => '',
			"css_url" => '',
			"js" => '',
			"js_url" => '',
			"inc" => '',
			"base" => '',
			"name" => '',
			"theme_dir" => '',
			);		
	public $gp_opts=array(
			"lic-key"=>"",
			"lic-email"=>"",
			"valid-lic"=>false,
			"show-ids"=>false,
			"keep-opts"=>false,
			"last-updt"=>0,
			);

 	// define constants for the plugin
 	public function __construct($url,$dir,$base) {
		$this->set_paths($url,$dir,$base);
		$this->gp_opts = $this->get_options();
		$this->gp_opts['cur-version']=$this->plugin_get_version();
	}
	
	/**
	 *	get_options
	 * @package WordPress
	 * @subpackage tpg_get_posts
	 * @since 2.0
	 *
	 * get any options for the plugin 
	 * 
	 * @param	void
	 * @return	array   assoc array of opts
	 *
	 */
	public function get_options() {
			return get_option("tpg_gp_opts", $this->gp_opts);
	}
		
	/**
	 *	set_paths
	 * @package WordPress
	 * @subpackage tpg_get_posts
	 * @since 1.3.5
	 *
	 * add the TPG GET POSTS menu item to the Setting tab 
	 * 
	 * @param	string	url
	 * @param 	string	directory path from home
	 * @param	string	base to plugin
	 * @return	void
	 *
	 */
	function set_paths($url,$dir,$base) {

		$this->gp_paths['url'] = $url;
		$this->gp_paths['dir'] = $dir;
		$this->gp_paths['css'] = $dir."css/";
		$this->gp_paths['css_url'] = $url."css/";
		$this->gp_paths['js'] =	$dir."js/";
		$this->gp_paths['js_url'] =  $url."js/";
		$this->gp_paths['inc'] =  $dir."inc/";
		$this->gp_paths['base'] = $base;
		$_arr= preg_split("#[/.]#",$base);
		$this->gp_paths['name'] = $_arr[1];
		$this->gp_paths["theme"] = get_theme_root().'/'.get_template().'/';
		$this->gp_paths["theme_url"] = get_bloginfo("template_url").'/';
	}
	
	/**
	 * Returns current plugin version.
	 * 
	 * @return string Plugin version
	 */
	function plugin_get_version() {
		if ( ! function_exists( 'get_plugin_data' ) )
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		$plugin_name=$this->gp_paths['name'].'.php';
		$plugin_data = get_plugin_data( $this->gp_paths['dir'].$plugin_name );
		return $plugin_data['Version'];
	}

}


?>