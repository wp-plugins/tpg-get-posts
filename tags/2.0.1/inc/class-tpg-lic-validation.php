<?php
/*
 * Licence Validation Class
 *
 * This class will 
 *	(1) validate the lic and set the option to true
 *	(2) check for new versions of software
 *	(3) download the new update
 *
 */
class tpg_lic_validation {
	
	private	$api_url="http://api.tpginc.net/tpg-api-listener.php";
	
	private $bnt_func="";
	private $btn_text="";                       //description on button
	private $btn_desc_b4="";						//text above button
	private $btn_desc_af="";						//text after button
	private $btn_hidden="";						//hidden text <input type=hidden name=cmd value=_s-xclick>
	
	private $data=array();
	
	/**
	 * Constrtor for lic validation
	 *
	 * @param	array	$gp_opts	options array
 	 * @param	array	$gp_paths	paths array
 	 * @param	string	$module		name of module to be validated
	 */
	
	function __construct($_opts,$_paths,$_module) {
		$this->opts=$_opts;
		$this->paths=$_paths;
		$this->module=$_module;	
	}
	
	/**
     * set variables in class
     * 
	 * desc
	 *
     * @param 	string	variable name
	 * @param   string  value 
	 * @return	bool 
     */
	public function set_var($_var,$_val) {
		// var must exist; dynamic var not allowed
		if (array_key_exists($_var, get_class_vars(__CLASS__))) {
			$this->$_var = $_val;
			return true;
		} else {
			return false;
		}
	}

		
	/**
     * Validate license
     * 
	 * desc
	 *
     * @param 	void
	 * @return	void 
     */
	function validate_lic(){
		date_default_timezone_set('UTC');
		$this->data['hash']=time();
		$this->data['module']=$this->module;
		$this->data['func']='validate';
		$this->data['lic-key']=$this->opts['lic-key'];
		$this->data['lic-email']=$this->opts['lic-email'];

    	$_resp = $this->curl_json_req($this->data);
		
		return $_resp;
	}
	
	/**
     * get the version from the repository
     * 
	 * Get the version of the premium plugin from the tpg repository
	 *
     * @param 	void
	 * @return	void 
     */
	function get_version(){
		date_default_timezone_set('UTC');
		$this->data['hash']=time();
		$this->data['module']=$this->module;
		$this->data['func']='get-version';
		$this->data['lic-key']=$this->opts['lic-key'];
		$this->data['lic-email']=$this->opts['lic-email'];

    	$_resp = $this->curl_json_req( $this->data);
		
		if ($_resp['success']) {
			return $_resp['metadata']['version'];
		} else {
			return false;
		}
	}
	
	/**
     * get update link
     * 
	 * get the link to download the software
	 *
     * @param 	void
	 * @return	void 
     */
	function get_update_link(){
		date_default_timezone_set('UTC');
		$this->data['hash']=time();
		$this->data['module']=$this->module;
		$this->data['func']='get-update-link';
		
		$this->data['order']=$this->opts['lic-key'];
		$this->data['email']=$this->opts['lic-email'];
		
    	$_resp = $this->curl_json_req( $this->data);
		
		if ($_resp['success']) {
			return $_resp['dl-url'];
		} else {
			return $_resp;
		}
	}
	
	/**
     * curl_json_req
     * 
	 * send a request to the api 
	 * 
     * @param 	void
	 * @return	void 
     */
	 function curl_json_req($data,$url=''){
		
		if ($url=='') {
			$url=$this->api_url; 
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' ));
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array("parms" => $data)));
		curl_setopt($ch, CURLOPT_POST, true); 
		$_res = curl_exec($ch);
		
		//res false error, res true chk for json fmt
		if ($_res){
			$_r = json_decode($_res,true);
			if (is_null($_r)) {$_r = $_res;}
		} else {
			//get curl error
			$_r = curl_errno($ch);
		} 

		curl_close($ch);
		return $_r;

}

	 
	/**
     * gen_update_button
	 * 
	 * create update button
	 *
     * @param 	void
	 * @return	void 
     */
	function gen_update_button(){
		$this->bnt_func="update";
		$this->btn_text="update";     
		$this->btn_desc_b4="";	
		$this->btn_desc_af="";	
		$this->btn_hidden="";						//hidden text <input type=hidden name=cmd value=_s-xclick>
		$_button = gen_button();
		return $_button;
	}
	
	/**
     * generate button
	 * 
	 * desc
	 *
     * @param 	void
	 * @return	string    button code
     */
	function gen_validate_button(){
		$this->bnt_func="validate";
		$this->btn_text="validate";     
		$this->btn_desc_b4="";	
		$this->btn_desc_af="";	
		$this->btn_hidden="";						//hidden text <input type=hidden name=cmd value=_s-xclick>
		$_button = gen_button();
		return $_button;
	}

	/**
     * generate button
	 * 
	 * desc
	 *
     * @param 	void
	 * @return	string    button code
     */
	function gen_button(){
		$button_code  = '<div id="'.$this->btn_func.'-button-wrapper">';
		if ($this->desc != '') {
			$button_code .= '<div id="'.$this->btn_func.'-desc-b4">'.$this->btn_desc_b4.'</div>';
		}
		$button_code .= '<div id="'.$this->btn_func.'-button"><form action="'.$this->api_url.'" method=post>';
		$button_code .= $this->btn_hiden;
		if ($this->btn_text != '') {
			$button_code .= '<input type=hidden name="funct_desc" value="'.$this->btn_text.'">';
		}
		if ($this->desc_af != '') {
			$button_code .= '<div id="'.$this->btn_func.'-desc-after">'.$this->btn_desc_af.'</div>';
		}
		$button_code .= '</form></div>	</div>';
		return $button_code;
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


}//end class
?>