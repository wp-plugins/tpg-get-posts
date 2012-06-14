<?php
/*
 *  display the settings page
*/
class tpg_gp_settings extends tpg_get_posts {
	
	private $pp_btn='';
	
	function __construct($url,$dir,$base) {
		parent::__construct($url,$dir,$base);
	}
	
	/*
	 * show the settings page
	 *
	 * @package WordPress
	 * @subpackage tpg_get_posts
	 * @since 2.8
	 *
	 * the html text for the setting page is loaded into the content variable 
	 * and then printed.
	 * the style sheet is enqueued using the wp enqueue process
	 * 
	 * @param    type    $id    post id
	 * @return   string         category ids for selection
	 *
	 */ 
	public function tpg_gp_show_settings() {
		//get css, js	
		$this->gp_admin_load_inc();
		
		// footer info for settings page
		add_action('in_admin_footer', array($this,'tgp_footer'));

		$page_content = file_get_contents($this->gp_inc.'doc-text.php');
		//replace tokens in text
		$page_content = str_replace("{icon}",screen_icon(),$page_content);
		$page_content = str_replace("{donate}",$this->pp_btn,$page_content);
		
		echo $page_content;
	
	}
	
	/*
	 *	gp_admin_load_inc
	 *  enque css, js and other items for admin page
	 *
	 * @package WordPress
	 * @subpackage tpg_phplist
	 * @since 0.1
	 *
	 * enque the css, js and other items only when the admin page is called.
	 * 	
	 * @param    null
	 * @return   null
	 */
	function gp_admin_load_inc(){
		//enque css style 

		$tgp_css = "tpg-get-posts-admin.css";
		//check if file exists with path
		if (file_exists($this->gp_css.$tgp_css)) {
			wp_enqueue_style('tpg_get_posts_admin_css',$this->gp_css_url.$tgp_css);
		}
		if (file_exists($this->gp_css."user-get-posts-style.css")) {
			wp_enqueue_style('user_get_posts_css',$this->gp_css_url."user-get-posts-style.css");
		}
		
		//get jquery tabs code
		wp_enqueue_script('jquery-ui-tabs');
		
		//load admin js code
		if (file_exists($this->gp_js."tpg-get-posts-admin.js")) {
			wp_enqueue_script('tpg_get-posts_admin_js',$this->gp_js_url."tpg-get-posts-admin.js");
		}
		
		//generate pp donate button
		include_once("tpg-pp-donate-button.class.php");
		$ppb = new tpg_pp_donate_button;
		$ask="<p>If this plugin helps you build a website, please consider a small donation of $5 or $10 to continue the support of open source software.  Taking one hour&lsquo;s fee and spreading it across multiple plugins is an investment that generates amazing returns.</p><p>Thank you for supporting open source software.</p>";
		$ppb->set_var("for_text","wordpress plugin tpg-get-posts");
		$ppb->set_var("desc",$ask);
		$this->pp_btn = $ppb->gen_donate_button();
	}

}
?>