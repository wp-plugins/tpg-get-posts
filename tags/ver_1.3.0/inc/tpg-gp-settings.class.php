<?php
/*
 *  display the settings page
*/
class tpg_gp_settings extends tpg_get_posts {
	
	private $pp_btn='';
	
	function __construct() {
		parent::__construct();
		//generate pp donate button
		include_once("tpg-pp-donate-button.class.php");
		$ppb = new tpg_pp_donate_button;
		$ask="<p>If this plugin helps you build a website, please consider a small donation of $5 or $10 to continue the support of open source software.  Taking one hour&lsquo;s fee and spreading it across multiple plugins is an investment that generates amazing returns.</p><p>Thank you for supporting open source software.</p>";
		$ppb->set_var("for_text","wordpress plugin tpg-get-posts");
		$ppb->set_var("desc",$ask);
		$this->pp_btn = $ppb->gen_donate_button();
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
		//build url to css
		$tgp_css = "tpg-get-posts-style.css";
		//check if file exists with path
		if (file_exists(TGP_CSS.$tgp_css)) {
			wp_enqueue_style('tpg_get_posts_css',TGP_CSS_URL.$tgp_css);
		}
		// footer info for settings page
		add_action('in_admin_footer', array($this,'tgp_footer'));

		$page_content = file_get_contents(TGP_INC.'doc-text.php');
		//replace tokens in text
		$page_content = str_replace("{icon}",screen_icon(),$page_content);
		$page_content = str_replace("{donate}",$this->pp_btn,$page_content);
		
		echo $page_content;
	
	}

}
?>