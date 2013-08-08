<?php
/*
  tpg_get_posts front-end processing
*/

//class tpg_gp_process extends tpg_get_posts {
class tpg_gp_process {
	//default parameter array
	private $model_attr = array(
		  'numberposts'      => '5',
		  'offset'           => '',
		  'category'         => '',
		  'category_name'    => '',
		  'tag'              => '',
		  'orderby'          => 'date',
		  'end-of-parms'     => '---------',
		  'show_entire'      => 'false',
		  'show_meta'        => 'true',
		  'show_byline'		 => 'true',
		  'shorten_title'    => '',
		  'shorten_content'  => '',
		  'text_ellipsis'    => ' ...',
		  'ul_class'         => '',
		  'title_tag'        => 'h2',
		  'title_link'       => 'true',
		  'thumbnail_size'	 => '',
		  'thumbnail_only'	 => 'false',
		  'show_excerpt'     => 'false',
		  'more_link_text'   => '(read more...)',
		  'fields'           => 'post_title, post_content',
		  'field_classes'    => '',
		  );
		  //'field_classes'    => 'post_title=tpg-title-class, post_content=tpg-content-class, post_metadata=tpg-metadata-class, post_byline=tpg-byline-class');
		  
	private $model_field_class = array('post_title'=>'tpg-title-class',
								 	'post_content'=>'tpg-content-class', 
								 	'post_metadata'=>'tpg-metadata-class', 
								 	'post_byline'=>'tpg-byline-class',
									'ul_class'=>'tpg-ul-class',
								 );
								 
	//initialized from model each time processed	  
	private $default_attr = array();
	//variables 
	private $gp_prem = false;
	private	$short_content= false;
	private	$sc_style='w';
	private	$sc_len='20';
	private $ellip='';	
	
	// values for thumbnail size
	public $thumbnail_sizes = array('thumbnail', 'medium', 'large', 'full');
	
	
	 
	
//	function __construct($url,$dir,$base) {
//		parent::__construct($url,$dir,$base);
	function __construct($opts,$paths) {
		$this->gp_opts=$opts;
		$this->gp_paths=$paths;
		
		// Register the short code
		add_shortcode('tpg_get_posts', array(&$this, 'tpg_get_posts_gen'));
		add_action( 'wp_enqueue_scripts', array($this,'gp_load_inc') );
		
	}
	
	/*
	 *	gp_load_inc
	 *  enque css, js and other items for proc page
	 *
	 * @package WordPress
	 * @subpackage tpg_get_posts
	 * @since 0.1
	 *
	 * enque the css, js and other items only when on front end.
	 * 	
	 * @param    null
	 * @return   null
	 */
	public function gp_load_inc(){
		//enque css style 
		$tgp_css = "tpg-get-posts-style.css";
		//check if file exists with path
		if (file_exists($this->gp_paths['css'].$tgp_css)) {
			wp_enqueue_style('tpg_get_posts_css',$this->gp_paths['css_url'].$tgp_css);
		}
		if (file_exists($this->gp_paths['theme']."user-get-posts-style.css")) {
			wp_enqueue_style('user_get_posts_css',$this->gp_paths['theme_url']."user-get-posts-style.css");
		}
	}
		
	
	/*
	 * format routine for metadata category 
	 *
	 * @package WordPress
	 * @subpackage tpg_get_posts
	 * @since 2.8
	 *
	 * 
	 * @param    type    $id    post id
	 * @return   string         category ids for selection
	 *
	 */
		 
	function get_my_cats($id,$_sep='') { 
		// init flds
		if ($_sep == ''){
			$_sep=', ';
		}
		$tpg_cats =''; 
		//if categories exist, process them
		if(get_the_category($id)){ 
			//loop through each cat for the post id
			foreach(get_the_category($id) as $cat) {
				//get the category
				$cat_name = $cat->name; 
				$tpg_cats .='<a href="'.get_category_link($cat->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $cat->name ) ) . '">'.$cat->cat_name.'</a>'.$_sep;        
			}
		}
		return trim($tpg_cats,$_sep);
	}
	
	/**
	 * format routine for tag selection
	 *
	 * @package WordPress
	 * @subpackage tpg_get_posts
	 * @since 2.8
	 *
	 * if request by tag is made, this is a preprocess routine to 
	 * convert creates a list of tags in comma delimited format
	 * 
	 * @param    type    $id    	post id
	 * @return   string             string of the tags for selecting posts
	 *
	 */
	
	function get_my_tags($id,$_sep='') {
		// init $tpg_tags fld
		if ($_sep == ''){
			$_sep=', ';
		}
		$tpg_tags =''; 
		// if tags exist, process them
		if(get_the_tags($id)){ 
			// loop through each tag for the post id
			foreach(get_the_tags($id) as $tag) {
				
				$tpg_tags .='<a href="'.get_tag_link($tag->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $tag->name ) ) . '">'.$tag->name.'</a>'.$_sep;
			}
		}
		if ($tpg_tags == "") $tpg_tags = "No Tags ";
		return trim($tpg_tags,$_sep);
	}
	
	/**
	 * shorten text to fixed length or complete word less than length
	 *
	 * @package WordPress
	 * @subpackage tpg_get_posts
	 * @since 2.8
	 *
	 * to control formatting, sometimes it is necessary to restrict a text field to 
	 * a specific length or the last word less than the length 
	 * 
	 * @param    string  $style			the code value of c or w
	 * @param    string  $len			length of the output text
	 * @param    string  $text			the string to be shortened
	 * @return   string  $text			the shortened text string
	 *
	 */
	
	function shorten_text($style='w', $len='20', $text, $ellipsis) {
		//if style is w and the next char is space change style to c
		if ($style == 'w') {
			if (substr($text,$len,1) == " ") {$style = 'c';}
		}
		
		// if style is c shorten to char and truncate
		// if style is w shorten to last complete word
		switch ($style) {
			case 'c' :
				$text = substr($text,0,$len);
				break;
			case 'w' :
				if (strlen($text) <= $len) {
					$text = $text; //do nothing
				} else {
					$text = preg_replace('/\s+?(\S+)?$/', '', substr($text, 0, $len+1));				
				}
				break;
		}
		
		$text .= $ellipsis;                     // add elipse
		return $text;
	}
	
	function cat_name_to_id($_list){
	//if category_names passed, convert to cat_id
		$_sep=",";
		$_ids='';
		$cat_nam_list = explode(",", $_list);
		//loop to get cat id and replace cat_names with cat ids
		foreach ($cat_nam_list as $value) {
			//added to allow for names in ext functions
			if (is_numeric($value )) {
				$_ids .= $value.$_sep;
			} else {
				$_ids .= get_cat_ID($value).$_sep;
			}
		}
		return trim($_ids,$_sep);
	}

	/**
	 * get the posts
	 *
	 * @package WordPress
	 * @subpackage tpg_get_posts
	 * @since 2.8
	 *
	 * to control formatting, sometimes it is necessary to restrict a text field to 
	 * a specific length or the last word less than the length 
	 * 
	 * @param    array    $args   		values from the shortcode passed to this routine
	 * @return   string   $content      the selected formated posts
	 *
	 */

	public function tpg_get_posts_gen($args = '') {
		global $post;

		//set default from model; required to refresh default with mulitple calls
		$this->default_attr = $this->model_attr;
			
		//loop through attributes and if key does not exist add to begin of array 
		if ($args != '') {
			foreach ($args as $key => $value) {
				if (array_key_exists ($key,$this->default_attr)) {
					continue;
				} else {
					$this->default_attr=array($key=>$value)+$this->default_attr;
				}
			}
			reset($args);
		}
		
		reset($this->default_attr);
		
		//now apply any options passed to the default array
		$this->r = shortcode_atts($this->default_attr,$args );
		//echo "<br>get_post r:";print_r($this->r);echo "<br>";
		
		//if category_names passed, convert to cat_id
		if ($this->r['category_name'] != '') {
			$_list=$this->cat_name_to_id($this->r['category_name']);
			$this->r['category'] = $_list;
			//$this->r['category'] = substr_replace($this->r['category'],"",-1);
			$this->r['category_name'] = "";
		}
		//echo "<br>get_post r:";print_r($this->r);echo "<br>";	
		if (method_exists($this,'ext_args')) {
			$this->ext_args();
		} 
		//echo "<br>get_post r:";print_r($this->r);echo "<br>";	
		//set up output fields
		$this->fields_list = explode(",", $this->r['fields']);
		

		//initial class array with defaults from model
		$this->classes_arr = $this->model_field_class;
		//override defaults if passed
		if ($this->r['field_classes'] != '') {
			$field_classes_list = explode(",", $this->r['field_classes']);
			//echo "for each fld class loop<br>";
			foreach ($field_classes_list as $fcl_items) {
				$fcl_item = explode('=',$fcl_items);
				$this->classes_arr[trim($fcl_item[0])] = trim($fcl_item[1]);
			}
		}
				
		//setup parms for query
		$this->q_args = array();
		reset ($this->r);
		while (list($key, $value) =  each($this->r)){
			if ($key == 'end-of-parms') {
				end ($this->r);
				break;
			} 
			if ($value != ''){
				$this->q_args[$key] = $value; 
			}
		}
		
		
		//format args & defaults in $r
		$this->format_args();
		
		//open div and begin post process
		$content = '<div id="tpg-get-posts" >';
		if ($this->show_as_list) {
			$content .="<ul class=\"".$this->r['ul_class']."\">\n";
		}
		
		// get posts
		$tmp_post = $post;                    // save current post/page settings
		
		//echo "<br>get_post a_args:";print_r($this->q_args);echo "<br>";
		
		$posts = get_posts($this->q_args);
		foreach( $posts as $post ) {
			setup_postdata($post);
			$id=$post->ID;
			//echo "<pre>";print_r($post);echo "</pre><br>";
			
			if ($this->thumbnail_only) {
				$t_content = $this->get_thumbnail($post,$thumbnail_size);
				if ($t_content != null) {
					$wkcontent = '<div class="tpg-get-posts-thumbnail"><a href="' . get_permalink() .'">'.$t_content.'</a></div>';
				} else {
					$wkcontent = "<p>thumbnail missing</p>";
				}
				$content .=$wkcontent;	
				continue;
			}	
						
			// if list wrap each post in list; if not list wrap in div
			if ($this->show_as_list) {
				$content .= "  <li>";
			} else {
				$content .= '<div class="tpg-get-posts-post" >';
			}

			$i = 0;
			foreach ( $this->fields_list as $field ) {
	
				$field = trim($field);		
				//echo '<br>',$fld,'<br>';
				//print_r($post);
				$wkcontent = $post->$field;                 //get the content
				switch ($field) {
					case "post_title":
						$wkcontent = ($this->short_title)? $this->shorten_text($this->st_style,$this->st_len,$wkcontent,$this->ellip): $wkcontent;
						$wkcontent = apply_filters( 'the_title', $wkcontent);
						if ($this->title_link) {
							$wkcontent = $this->t_tag_beg.'<a href="'.get_permalink($post->ID).'" >'.$wkcontent.'</a>'.$this->t_tag_end;
						} else {
							$wkcontent = $this->t_tag_beg.$wkcontent.$this->t_tag_end;
						}
						if ($this->show_byline) {
							$wkcontent .= $this->format_byline($post);
						}
						break;
					case "post_content":
						// if not post entire -- show only teaser or excerpt if avaliable and requested					
						if (!$this->show_entire) {           //show only teaser
							if ($this->show_excerpt == true) {
								$e_content = $this->get_excerpt($post);
								if ($e_content == null) {
									$wkcontent = $this->get_post_content($wkcontent,$id);
								} else {
									$wkcontent = '<p class="tpg-get-posts-excerpt">'.$e_content.'</p>';
								}
							} else {
								
								$wkcontent = $this->get_post_content($wkcontent,$id);
							}
						}
						// add thumbnail to content
						if ($this->show_thumbnail ){	
							$t_content = $this->get_thumbnail($post,$this->thumbnail_size);
							if ($t_content != null) {
								$wkcontent = $t_content.$wkcontent;
							}
						}
						//wrap content in div tag
						if (strlen($wkcontent) > 0) {					
							$wkcontent = '<div class="tpg-post-content '.$this->classes_arr[$field].'">'.$wkcontent.'</div>';
							#apply filters for all content
							$wkcontent = apply_filters('the_content',$wkcontent);
							$wkcontent = str_replace(']]>', ']]&gt;', $wkcontent);
						}
						break;
				}
				
				$content .= $wkcontent;
				
				$i++;
			}
			// print post metadata
			if ($this->show_meta) {
				$content .= $this->format_metadata($post);
			}
	
			if ($this->show_as_list) {
				$content .= '</li> <hr class="tpg-get-post-li-hr" >';
				//$content .= '</li>' ;
			} else {
				$content .= '</div>';
			}
		}	
		
		if ($this->show_as_list)
			$content .= '</ul>';
		$content .= '</div><!-- #tpg-get-posts -->';
		
		$post = $tmp_post;            //restore current page/post settings
		return $content;
			
	}
	
	/**
     * Get the post content
     * 
	 * This routine will parse the content at the more tag and return the short version
	 *
     * @param object $wkcontent
     * @return char  $wkcontent
     */
	function get_post_content($wkcontent,$id) {
		$has_teaser=false;
		//$wkarr = preg_split('/<!--more(.*?)?-->/', $wkcontent);
		if ( preg_match('/<!--more(.*?)?-->/', $wkcontent, $matches) ) {
 	    	$wkarr = explode($matches[0], $wkcontent, 2);
			
            if ( !empty($matches[1]) && !empty($this->more_link_text) ) {
 	        	$this->more_link_text = strip_tags(wp_kses_no_null(trim($matches[1])));
			} 
			$has_teaser = true;
		} else {
			$wkarr = array($wkcontent);
		}
		
		if ($this->short_content) {
			$wkcontent = $this->shorten_text($this->sc_style,$this->sc_len,$wkarr[0],$this->ellip);
			if (strlen($wkcontent) >0) {
				$has_teaser = true;
			} else {
				$has_teaser = false;
			}
		}else {
			$wkcontent = $wkarr[0];
		}
		if ($has_teaser) {
			$wkcontent .= apply_filters( 'the_content_more_link', ' <a href="' . get_permalink() . "#more-$id\" class=\"more-link\">$this->more_link_text</a>", $this->more_link_text );
		}
		$wkcontent = force_balance_tags($wkcontent);
		return $wkcontent;
	}
	
	/**
     * Format the by line
     * 
     * @param	object $post
     * @return	string $_byline
     */
	function format_byline($post){
		$_byline = '<p ';
		if (isset($this->classes_arr["post_byline"])) {
			$_byline .= ' class="'.$this->classes_arr["post_byline"].'"';
		}	
		$_byline .= '>By '.get_the_author().' on '.mysql2date('F j, Y', $post->post_date).'</p>';

		$_byline .= '</p>';
		return $_byline;
	}
	
	/**
     * Format the metadata line
     * 
     * @param	object $post
     * @return	string $_metadata
     */
	function format_metadata($post){
		$_metadata = '<p ';
		if (isset($this->classes_arr["post_metadata"])) {
			$_metadata .= 'class="'.$this->classes_arr["post_metadata"].'"';
		}	
		$_metadata .= '>';
		ob_start();
		comments_popup_link(' No Comments &#187;', ' 1 Comment &#187;', ' % Comments &#187;');
		$_metadata .= ob_get_clean();
		$_metadata .= " | <b>Filed under:</b> ".$this->get_my_cats($post->ID)."&nbsp;&nbsp;|&nbsp;&nbsp;<b>Tags:</b> ".$this->get_my_tags($post->ID);
		//$content .= " | <b>Filed under:</b> ".$this->get_my_cats($post->ID)."&nbsp;&nbsp;|&nbsp;&nbsp;<b>Tags:</b> ".$this->get_my_tags($post->ID);
		$_metadata .= '</p>';
		return $_metadata;
	}

	/**
     * Get the post excerpt
     * 
     * @param object $post
     * @return char  $excerpt
     */
	function get_excerpt($post){
        
		if($post->post_excerpt){
	        return $post->post_excerpt;
        } else {
            return null;
        }
    }

    /**
     * Get the post Thumbnail
     * @see http://codex.wordpress.org/Function_Reference/get_the_post_thumbnail
     * @param 	object $post
	 * @return	string $t_content or null
     * 
     */
    function get_thumbnail($post,$tn_size,$t_class="alignleft"){

    	if (has_post_thumbnail($post->ID)) {
			$t_content = get_the_post_thumbnail($post->ID,$tn_size,
				($t_class != null) ? array('class' => $t_class ) : null); 
        	$t_thumbnail = '<a href="' . get_permalink($post->ID).'">'.$t_content.'</a>';          
            return $t_content;
        } else {
            return null;
        }
    }
	
	/**
     * format the arguments from command line
     * 
     * @param 	void
	 * @return	void
     * 
     */
    function format_args(){
		$this->more_link_text = __( $this->r['more_link_text'] );
		
		if ($this->r['show_entire'] == "true") {
			$this->show_entire = true;
		} else {
			$this->show_entire = false;
		}
		
		if ($this->r['show_meta'] == "true") {
			$this->show_meta = true;
		} else {
			$this->show_meta = false;
		}
		
		if ($this->r['show_byline'] == "true") {
			$this->show_byline = true;
		} else {
			$this->show_byline = false;
		}
		
		if ($this->r['title_link'] == "true") {
			$this->title_link = true;
		} else {
			$this->title_link = false;
		}
		
		if ($this->r['ul_class'] == "") {
			$this->show_as_list = false;
		} else {
			$this->show_as_list = true;
		}
		
		if ($this->r['thumbnail_size'] == "") {
			$this->show_thumbnail = false;
		} else {
			if (in_array($this->r['thumbnail_size'], $this->thumbnail_sizes)) {
				$this->thumbnail_size = $this->r['thumbnail_size'];
			} else {
				$this->thumbnail_size = 'thumbnail';
			}
			$this->show_thumbnail = true;
		}

		if ($this->r['thumbnail_only'] == "true") {
			$this->thumbnail_only = true;
		} else {
			$this->thumbnail_only = false;
		}
		
		if ($this->r['show_excerpt'] == "true") {
			$this->show_excerpt = true;
		} else {
			$this->show_excerpt = false;
		}
		
		// set flag to shorten text in title
		$this->ellip = $this->r['text_ellipsis'];
		if ($this->r['shorten_title'] == "") {
			$this->short_title = false;
		} else {
			$this->short_title = true;
			$this->st_style = substr($this->r['shorten_title'],0,1);
			$this->st_len= substr($this->r['shorten_title'],1);
		}
		
		if ($this->r['shorten_content'] == "") {
			$this->short_content = false;
		} else {
			$this->short_content = true;
			$this->sc_style = substr($this->r['shorten_content'],0,1);
			$this->sc_len= substr($this->r['shorten_content'],1);
		}
		
		//set up title tag
		if ($this->r['title_tag'] == '') {
			$this->t_tag_beg = '';
			$this->t_tag_end = '';
		} else {
			$this->t_tag_beg = '<'.$this->r['title_tag'];
			if (isset($this->classes_arr["post_title"])) {
				$this->t_tag_beg .= ' class="'.$this->classes_arr["post_title"].'"';
			}	
			$this->t_tag_beg .= '>';
			$this->t_tag_end = "</".$this->r['title_tag'].">";
		}	
	}
	
}//end class
?>