<?php
/*
	Base class for TPG Get Posts
	this class is extended for the process or admin page
*/



/**
 * format routine to identify category selection
 *
 * @package WordPress
 * @subpackage tpg_get_posts
 * @since 2.8
 *
 * if request by category name is made, this is a preprocess routine to 
 * convert the name to a category id, allowing for multiple category names
 * 
 * @param    type    $id    post id
 * @return   string         category ids for selection
 *

 */
 
class tpg_get_posts {
	// path variables	 
	public $gp_url = '';
	public $gp_dir = '';
	public $gp_css = '';
	public $gp_css_url = '';
	public $gp_js =	'';
	public $gp_js_url =  '';
	public $gp_inc =  '';
	public $gp_base = '';
	public $gp_name= '';
	
	 // values for thumbnail size
	 public $thumbnail_sizes = array('thumbnail', 'medium', 'large', 'full');
	 
 	// define constants for the plugin
 	public function __construct($url,$dir,$base) {
		$this->set_paths($url,$dir,$base);
		
		if(is_admin()) {
			// Register link to the pluging list
			add_filter('plugin_action_links', array(&$this, 'tpg_get_posts_settings_link'), 10, 2);
			// Add the admin menu item
			add_action('admin_menu', array(&$this,'tpg_get_posts_admin'));
			
		} else {
			// Register the short code
			add_shortcode('tpg_get_posts', array(&$this, 'tpg_get_posts_gen'));
		}

	}
	
	/*
	 *	add footer info on admin page 
	 *
	 * @package WordPress
	 * @subpackage tpg_get_posts
	 * @since 1.3
	 *
	 * write the footer information on options page
	 * 
	 * @param	array	$links
	 * @param 	 		$file
	 * @return	array	$links
	 *
	 */
	public function tgp_footer() {
		$p_data = get_plugin_data($this->gp_dir."tpg-get-posts.php");
		printf('%1$s by %2$s<br />', $p_data['Title'].'  Version: '.$p_data['Version'], $p_data['Author']);
	}

	/**
	 *	add link to plugin text 
	 * @package WordPress
	 * @subpackage tpg_get_posts
	 * @since 1.3
	 *
	 * add the settings link in the plugin description area
	 * 
	 * @param	array	$links
	 * @param 	 		$file
	 * @return	array	$links
	 *
	 */
	function tpg_get_posts_settings_link($links, $file) {
		static $this_plugin;
		if (!$this_plugin) $this_plugin = plugin_basename($this->gp_base);
		if ($file == $this_plugin){
			$settings_link = '<a href="options-general.php?page=tpg-get-posts-settings">'.__('Settings', 'tpg_get_posts').'</a>';
			array_unshift($links, $settings_link);
		}
		return $links;
}

	/**
	 *	add admin menu
	 * @package WordPress
	 * @subpackage tpg_get_posts
	 * @since 1.3
	 *
	 * add the TPG GET POSTS menu item to the Setting tab 
	 * 
	 * @param    void
	 * @return   void
	 *
	 */
	function tpg_get_posts_admin () {
		// if we are in administrator environment
		if (function_exists('add_submenu_page')) {
			add_options_page('TPG Get Posts Settings', 
							'TPG Get Posts', 
							'manage_options',
							'tpg-get-posts-settings', 
							array(&$this,'tpg_gp_show_settings')
							);
		}
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
		
		$this->gp_url = $url;
		$this->gp_dir = $dir;
		$this->gp_css = $dir."css/";
		$this->gp_css_url = $url."css/";
		$this->gp_js =	$dir."js/";
		$this->gp_js_url =  $url."js/";
		$this->gp_inc =  $dir."inc/";
		$this->gp_base = $base;
		$_arr= explode("/",$base);
		$this->gp_name=$_arr[1];
	}

}


?>