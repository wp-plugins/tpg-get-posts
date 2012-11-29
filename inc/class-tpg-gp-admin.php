<?php
/*
 *  display the settings page
*/
//class tpg_gp_settings extends tpg_get_posts {
class tpg_gp_admin {
	
	private $pp_btn='';
	private $resp_data=array(
					'dl-url'=>'',
					'dl-link'=>'',
					);
					
	//variables set by constructor				
	public $gp_opts=array();
	public $gp_paths=array();
	public $module='';
	public $plugin_data=array();
	
	function __construct($opts,$paths) {
		$this->gp_opts=$opts;
		$this->gp_paths=$paths;
		$this->module='tpg-get-posts';
		$this->plugin_data = get_plugin_data($this->gp_paths['dir'].$this->gp_paths['name'].'.php');
		
		// Register link to the pluging list
		add_filter('plugin_action_links', array(&$this, 'tpg_get_posts_settings_link'), 10, 2);
		// Add the admin menu item
		add_action('admin_menu', array(&$this,'tpg_get_posts_admin'));	

		if ($opts['show-ids']) {
			if ($opts['valid-lic'] && file_exists($paths['dir']."inc/class-tpg-show-ids.php")) {
				$ssid = tpg_gp_factory::create_show_ids();
			}
		}
	}
	
	/**
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
	public function tpg_gp_footer() {
		printf('%1$s by %2$s<br />', $this->plugin_data['Title'].'  Version: '.$this->plugin_data['Version'], $this->plugin_data['Author']);
	}

//	/**
//	 *	add link to plugin text 
//	 * @package WordPress
//	 * @subpackage tpg_get_posts
//	 * @since 1.3
//	 *
//	 * add the settings link in the plugin description area
//	 * 
//	 * @param	array	$links
//	 * @param 	 		$file
//	 * @return	array	$links
//	 *
//	 */
	function tpg_get_posts_settings_link($links, $file) {
		static $this_plugin;
		if (!$this_plugin) $this_plugin = plugin_basename($this->gp_paths['base']);
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
		add_action('in_admin_footer', array($this,'tpg_gp_footer'));
		
		//if options have been set, process them & update array
		if( isset($_POST['gp_opts']) ) {
			$new_opts = $_POST['gp_opts'];
			//var_dump($this->gp_opts);echo '<br>';var_dump($new_opts);
			$_func=trim($new_opts['func']);
			unset($new_opts['func']);
			
			//echo "<br>func: *",$_func,"*";			
			switch ($_func) {
				case 'Update Options':
					$this->update_options($new_opts);
					break;
				case 'Validate Lic':
					$this->validate_lic();
					break;
			}
			//refresh options
			$this->gp_opts=tpg_get_posts::get_options();

		}

		$page_content = file_get_contents($this->gp_paths['inc'].'doc-text.php');
		//replace tokens in text
		$page_content = str_replace("{settings}",$this->tpg_gp_bld_setting(),$page_content);
		$page_content = str_replace("{icon}",screen_icon(),$page_content);
		if ($this->gp_opts['valid-lic']) {
			$page_content = str_replace("{donate}",'',$page_content);
		} else {
			$page_content = str_replace("{donate}",$this->pp_btn,$page_content);
		}
		
		echo $page_content;
	
	}
	
	function tpg_gp_bld_setting() {
		$form_output = $this->build_form();
		//set action link for form
		$action_link = str_replace( '%7E', '~', $_SERVER['REQUEST_URI'])."#gp-settings"; 
		//replace tokens in text
		$form_output = str_replace("{action-link}",$action_link,$form_output);
		//check for update & show cur ver 
		$new_ver=$this->check_for_update();
		$v_store = $this->normalize_ver($new_ver);
		$v_plugin= $this->normalize_ver($this->plugin_data['Version']);
		if ($v_store > $v_plugin) {
			$ver_txt = $this->plugin_data['Version'].'&nbsp;&nbsp;Newer version exists '.$new_ver;
		} else {
			$ver_txt = $this->plugin_data['Version'];
		}
		//message for valid lic
		if ($this->gp_opts['valid-lic']) {
			$valid_txt="The license opts have been validated - thank you.";
		} else {
			$valid_txt='';
		}
		
		//set tokens in form
		$form_output = str_replace("{cur-ver}",$ver_txt,$form_output);
		$form_output = str_replace("{valid-lic-msg}",$valid_txt,$form_output);
		$form_output = str_replace("{download-link}",$this->resp_data['dl-link'],$form_output);

		return $form_output;	
	}
	
	/*
	 *	update_options
	 *  update the wp plugin options
	 *
	 * @subpackage tpg_get_posts
	 * @since 2.0
	 *
	 * update options
	 * 	
	 * @param    null
	 * @return   null
	 */
	function update_options($new_opts){
		//chk box will not return values for unchecked items
		if (!array_key_exists("show-ids",$new_opts)) {
			$new_opts['show-ids'] = false;
		} else {
			$new_opts['show-ids'] = true;
		}
		
		if (!array_key_exists("keep-opts",$new_opts)) {
			$new_opts['keep-opts'] = false;
		} else {
			$new_opts['keep-opts'] = true;
		}
		
		//apply new values to gp_opts 
		foreach($new_opts as $key => $value) {
			$this->gp_opts[$key] = $value;
		}
		
		//update with new values
		update_option( 'tpg_gp_opts', $this->gp_opts);
		//$this->set_options();
		echo '<div id="message" class="updated fade"><p><strong>' . __('Settings saved.') . '</strong></p></div>';
	}
	
	/*
	 *	validate lic
	 *  validate the lic options and update the options table
	 *
	 * @param    null
	 * @return   null
	 */
	function validate_lic(){
		$vl = tpg_gp_factory::create_lic_validation($this->gp_opts,$this->gp_paths,$this->module);
		$_resp=$vl->validate_lic();
		$this->gp_opts['valid-lic']=$_resp['valid-lic'];
		//update with new values
		update_option( 'tpg_gp_opts', $this->gp_opts);
		//refresh options
		$this->gp_opts=tpg_get_posts::get_options();
	}
	
	/*
	 * check_for_update
	 * check for an update of the plugin
	 *
	 * @subpackage tpg_get_posts
	 * @since 2.0
	 *
	 * update options
	 * 	
	 * @param    null
	 * @return   null
	 */
	function check_for_update(){
		$_ver='0.0';
		if ($this->gp_opts['valid-lic']) {
			//sec since last update 30x24x60= 43200 sec in 30 day month
			if (!array_key_exists('last-updt',$this->gp_opts) || 	
				($this->gp_opts['last-updt']+ 0) < time() ) {
					$vl = tpg_gp_factory::create_lic_validation($this->gp_opts,$this->gp_paths,$this->module);
					$_ver=$vl->get_version();
					$v_store = $this->normalize_ver($_ver);
					$v_plugin= $this->normalize_ver($this->plugin_data['Version']);
					if (($_ver && $v_store > $v_plugin) || (!file_exists($this->gp_paths['dir']."inc/class-tpg-gp-process-ext.php")) ){
						echo '<div id="message" class="updated"><p><strong>' . __('An update to ver '.$_ver.' is available.') . '</strong></p></div>';
						$_resp=$vl->get_update_link();
						if ($_resp['success']) {
							$this->resp_data['dl-url']=$_resp;
							$this->resp_data['dl-link']='<a href="'.$this->resp_data['dl-url'].'">Download new version</a>';
						} else {
							$this->resp_data['success']=false;
							foreach ($_resp['errors'] as $err) {
								$this->resp_data['errors'][]=$err;
							}
						}
					}
			}
		} 
		return $_ver;
	}
	
	/**
     * normalize version
	 * 
	 * Normalize the version so alpha 2.0.1 and 2.01.0 will compare correctly.  
	 * convert alph ver xx.xx.xx to numeric x.xxxx
	 *
     * @param 	string	version
	 * @return	float	version numeric in x.xxxx
     */
	function normalize_ver($_v) {
	    //convert alph ver xx.xx.xx to x.xxxx
    	$va = array_map('intval',explode('.',$_v));
		return $va[0]+$va[1]*.01+$va[2]*.0001;
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
		if (file_exists($this->gp_paths['css'].$tgp_css)) {
			wp_enqueue_style('tpg_get_posts_admin_css',$this->gp_paths['css_url'].$tgp_css);
		}
		if (file_exists($this->gp_paths['css']."user-get-posts-style.css")) {
			wp_enqueue_style('user_get_posts_css',$this->gp_paths['css_url']."user-get-posts-style.css");
		}
		
		//get jquery tabs code
		wp_enqueue_script('jquery-ui-tabs');
		
		//load admin js code
		if (file_exists($this->gp_paths['js']."tpg-get-posts-admin.js")) {
			wp_enqueue_script('tpg_get-posts_admin_js',$this->gp_paths['js_url']."tpg-get-posts-admin.js");
		}
		
		//generate pp donate button
		//include_once("class-tpg-pp-donate-button.php");
		//$ppb = new tpg_pp_donate_button;
		$ppb = tpg_gp_factory::create_paypal_button();
		$ask="<p>If this plugin helps you build a website, please consider a small donation of $5 or $10 to continue the support of open source software.  Taking one hour&lsquo;s fee and spreading it across multiple plugins is an investment that generates amazing returns.</p><p>Thank you for supporting open source software.</p>";
		$ppb->set_var("for_text","wordpress plugin tpg-get-posts");
		$ppb->set_var("desc",$ask);
		$this->pp_btn = $ppb->gen_donate_button();
	}
	
	/*
	 *	build form for options
	 *  
	 * @package WordPress
	 * @subpackage tpg_get_posts
	 * @since 2.0
	 *
	 * @param    null
	 * @return   null
	 */
	function build_form() {
		//array to hold changes
		$gp_opts = array();
		
		//test the check boxes to see if the value should be checked
		$ck_show_ids = ($this->gp_opts['show-ids'])? 'checked=checked' : '';
		$ck_keep_opts = ($this->gp_opts['keep-opts'])? 'checked=checked' : '';
		$btn_txt = __('Update Options', 'gp_udate_opts' ) ;
		
		//create output form
		$output = <<<EOT
		<div class="wrap">		
	<div class="postbox-container" style="width:100%; margin-right:5%; " >
		<div class="metabox-holder">
			<div id="jq_effects" class="postbox">
				<div class="handlediv" title="Click to toggle"><br /></div>

				<h3><a class="togbox">+</a> TPG Get Posts Options</h3>
				
				<div class="inside"  style="padding:10px;">
					<form name="getposts_options" method="post" action="{action-link}">
						<h4>Premium Options - Current version {cur-ver}</h4>
						<table class="form-table">	
							<tr>		
							<td>License Key: </td><td><input type="text" name="gp_opts[lic-key]" value="{$this->gp_opts['lic-key']}" size="50"> </td><td>(the license key from email received after purchase of premium plugin)</td>
							</tr>
							<tr>
							<td>License email: </td><td><input type="text" name="gp_opts[lic-email]" value="{$this->gp_opts['lic-email']}" size="50"> </td><td>(the email used when purchasing the license)</td>
							</tr>
							<tr><td></td><td>{valid-lic-msg}</td>
							</tr>
							<tr>
							<td>Keep Options on uninstall:  </td><td><input type="checkbox" name="gp_opts[keep-opts]" id="id_keep_opts" value="false" $ck_keep_opts /></td><td>If checked, options will not be deleted on uninstall.  Useful when upgrading.  Uncheck to completely remove premium version.</td>				
							</tr>
							<td>Show Ids:  </td><td><input type="checkbox" name="gp_opts[show-ids]" id="id_show_id" value="true" $ck_show_ids /></td><td>This option applies modifications to the show cat (and other admin pages) to show the id of the entires.  This number is needed for the some of the premium selection options and for the category selector. </td>				
							</tr>
							<tr>
			</table>
							<!--//values are used in switch to determine processing-->
							<p class="submit">
							<input type="submit" class="button-primary tpg-settings-btn" name="gp_opts[func]" value=" $btn_txt" />
							&nbsp;&nbsp;
							<input type="submit" class="button-primary tpg-settings-btn" name="gp_opts[func]" value=" Validate Lic" />
							
							&nbsp;&nbsp;&nbsp;&nbsp; {download-link}
							</p>
								
						
					</form>
				</div>
			</div>
		</div>
	</div>
EOT;

		return $output;
	}	

}
?>