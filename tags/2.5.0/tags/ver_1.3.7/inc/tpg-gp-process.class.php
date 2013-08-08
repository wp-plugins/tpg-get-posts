<?php
/*
  tpg_get_posts front-end processing
*/


class tpg_gp_process extends tpg_get_posts {
	//variables 
	private	$short_content= false;
	private	$sc_style='w';
	private	$sc_len='20';
	private $ellip='';	
	
	function __construct($url,$dir,$base) {
		parent::__construct($url,$dir,$base);
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
		if (file_exists($this->gp_css.$tgp_css)) {
			wp_enqueue_style('tpg_get_posts_css',$this->gp_css_url.$tgp_css);
		}
		if (file_exists($this->gp_css."user-get-posts-style.css")) {
			wp_enqueue_style('user_get_posts_css',$this->gp_css_url."user-get-posts-style.css");
		}
	}
		
	
	/*
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
		 
	function get_my_cats($id) { 
		// init $tpg_cats fld
		$tpg_cats =''; 
		//if categories exist, process them
		if(get_the_category($id)){ 
			//loop through each cat for the post id
			foreach(get_the_category($id) as $cat) {
				//get the category
				$cat_name = $cat->name;
				//string cats serparated by ','  
				$tpg_cats .= $cat_name.',';         
			}
		}
	//	substr_replace($tpg_cats,"",-1);             // remove last ','
		return substr_replace($tpg_cats,"",-1);
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
	
	function get_my_tags($id) {
		// init $tpg_tags fld
		$tpg_tags =''; 
		// if tags exist, process them
		if(get_the_tags($id)){ 
			// loop through each tag for the post id
			foreach(get_the_tags($id) as $tag) {
				//get the tag
				$tag_name = $tag->name;
				//string tags serparated by ',' 
				$tpg_tags .= $tag_name.',';
			}
		}
		if ($tpg_tags == "") $tpg_tags = "No Tags ";
	//	substr_replace($tpg_tags,"",-1);   // remove last ','
		return  substr_replace($tpg_tags,"",-1);
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
		global $id, $post, $more, $more_link_text;
	
		//default values passed to get_posts
		$default_attr =   
		array(
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
		  'field_classes'    => 'post_title=p_title_class, post_content=p_content_class, post_metadata=p_metadata_class, post_byline=p_byline_class');
		
		//loop through attributes and add to array if key does not exist
		if ($args != '') {
			foreach ($args as $key => $value) {
				if (array_key_exists ($key,$default_attr)) {
					continue;
				} else {
					$default_attr=array($key=>$value)+$default_attr;
				}
			}
			reset($args);
		}
		
		reset($default_attr);
		
		//now apply any options passed to the default array
		$r = shortcode_atts($default_attr,$args );
		
		//if multiple category_names passed, convert to cat_id
		$cat_nam_list = explode(",", $r['category_name']);
		if (sizeof($cat_nam_list) <= 1 ) {
			//single or no cat name submitted - continue  
		} else {
			//loop to get cat id and replace cat_names with cat ids
			foreach ($cat_nam_list as $value) {
				$r['category'] .= get_cat_ID($value).",";
			}
			$r['category'] = substr_replace($r['category'],"",-1);
			$r['category_name'] = "";
		}
		
		//setup parms for query
		$q_args = array();
		reset ($r);
		while (list($key, $value) =  each($r)){
			if ($key == 'end-of-parms') {
				end ($r);
				break;
			} 
			if ($value != ''){
				$q_args[$key] = $value; 
			}
		}
		
		//set up output fields
		$fields_list = explode(",", $r['fields']);
		
		//build assoc array for class assignment
		$field_classes_list = explode(",", $r['field_classes']);
		$classes_arr = array();
		foreach ($field_classes_list as $fcl_items) {
			$fcl_item = explode('=',$fcl_items);
			$classes_arr[trim($fcl_item[0])] = trim($fcl_item[1]);
		}
	
		$more_link_text = __( $r['more_link_text'] );
		
		//legacy for typo in early release
		if (array_key_exists('post_entire',$r)) {
			$r['show_entire']=$r['post_entire'];
		}
		
		if ($r['show_entire'] == "true") {
			$show_entire = true;
		} else {
			$show_entire = false;
		}
		
		if ($r['show_meta'] == "true") {
			$show_meta = true;
		} else {
			$show_meta = false;
		}
		
		if ($r['show_byline'] == "true") {
			$show_byline = true;
		} else {
			$show_byline = false;
		}
		
		if ($r['title_link'] == "true") {
			$title_link = true;
		} else {
			$title_link = false;
		}
		
		if ($r['ul_class'] == "") {
			$show_as_list = false;
		} else {
			$show_as_list = true;
		}
		
		if ($r['thumbnail_size'] == "") {
			$show_thumbnail = false;
		} else {
			if (in_array($r['thumbnail_size'], $this->thumbnail_sizes)) {
				$thumbnail_size = $r['thumbnail_size'];
			} else {
				$thumbnail_size = 'thumbnail';
			}
			$show_thumbnail = true;
		}

		if ($r['thumbnail_only'] == "true") {
			$thumbnail_only = true;
		} else {
			$thumbnail_only = false;
		}
		
		if ($r['show_excerpt'] == "true") {
			$show_excerpt = true;
		} else {
			$show_excerpt = false;
		}
		
		// set flag to shorten text in title
		$this->ellip = $r['text_ellipsis'];
		if ($r['shorten_title'] == "") {
			$short_title = false;
		} else {
			$short_title = true;
			$st_style = substr($r['shorten_title'],0,1);
			$st_len= substr($r['shorten_title'],1);
		}
		
		if ($r['shorten_content'] == "") {
			$this->short_content = false;
		} else {
			$this->short_content = true;
			$this->sc_style = substr($r['shorten_content'],0,1);
			$this->sc_len= substr($r['shorten_content'],1);
		}
		
		//set up title tag
		if ($r['title_tag'] == '') {
			$t_tag_beg = '';
			$t_tag_end = '';
		} else {
			$t_tag_beg = '<'.$r['title_tag'];
			if (isset($classes_arr["post_title"])) {
				$t_tag_beg .= ' class="'.$classes_arr["post_title"].'"';
			}	
			$t_tag_beg .= '>';
			$t_tag_end = "</".$r['title_tag'].">";
		}
		
		//open div and begin post process
		$content = '<div id="tpg-get-posts" />';
		if ($show_as_list) {
			$content .="<ul class=\"".$r['ul_class']."\">\n";
		}
		
		// get posts
		$tmp_post = $post;                    // save current post/page settings
		$posts = get_posts($q_args);
		foreach( $posts as $post ) {
			setup_postdata($post);
			
			if ($thumbnail_only) {
				$t_content = $this->get_thumbnail($post,$thumbnail_size);
				if ($t_content != null) {
					$wkcontent = '<div id="tpg-get-posts-thumbnail"><a href="' . get_permalink() .'">'.$t_content.'</a></div>';
				} else {
					$wkcontent = "<p>thumbnail missing</p>";
				}
				$content .=$wkcontent;	
				continue;
			}	
						
			// if list wrap each post in list; if not list wrap in div
			if ($show_as_list) {
				$content .= "  <li>";
			} else {
				$content .= '<div id="tpg-get-posts-post" />';
			}

			$i = 0;
			foreach ( $fields_list as $field ) {
	
				$field = trim($field);
				
				if (isset($classes_arr[$field])) {
					$content .= "<span class=\"" . $classes_arr[$field] . "\">";
				}			
				
				$wkcontent = $post->$field;                                         //get the content
				switch ($field) {
					case "post_title":
						$wkcontent = ($short_title)? $this->shorten_text($st_style,$st_len,$wkcontent,$this->ellip): $wkcontent;
						$wkcontent = apply_filters( 'the_title', $wkcontent);
						if ($title_link) {
							$wkcontent = $t_tag_beg.'<a href="'.get_permalink($post->ID).'" id="">'.$wkcontent.'</a>'.$t_tag_end;
						} else {
							$wkcontent = $t_tag_beg.$wkcontent.$t_tag_end;
						}
						if ($show_byline) {
							$wkcontent .= '<p  ';
							if (isset($classes_arr["post_byline"])) {
								$wkcontent .= ' class="'.$classes_arr["post_byline"].'"';
							}	
							$wkcontent .= '>By '.get_the_author().' on '.mysql2date('F j, Y', $post->post_date).'</p>';
						}
						break;
					case "post_content":
						// if not post entire -- show only teaser or excerpt if avaliable and requested					
						if (!$show_entire) {           //show only teaser
							if ($show_excerpt == true) {
								$e_content = $this->get_excerpt($post);
								if ($e_content == null) {
									$wkcontent = $this->get_post_content($wkcontent);
								} else {
									$wkcontent = '<p class="tpg-get-posts-excerpt">'.$e_content.'</p>';
								}
							} else {
								
								$wkcontent = $this->get_post_content($wkcontent);
							}
						}
						// add thumbnail to content
						if ($show_thumbnail ){	
							$t_content = $this->get_thumbnail($post,$thumbnail_size);
							if ($t_content != null) {
								$wkcontent = $t_content.$wkcontent;
							}
						}
						//wrap content in div tag					
						$wkcontent = '<div id="tpg_post_content">'.$wkcontent.'</div>';
						#apply filters for all content
						$wkcontent = apply_filters('the_content',$wkcontent);
						$wkcontent = str_replace(']]>', ']]&gt;', $wkcontent);
						break;
				}
				
				$content .= $wkcontent;
	
				if (isset($classes_arr[$field])) {
					$content .=  "</span>";
				}
				
				$i++;
			}
	// print post metadata
			if ($show_meta) {
				$content .= '<p ';
				if (isset($classes_arr["post_metadata"])) {
					$content .= 'class="'.$classes_arr["post_metadata"].'"';
				}	
				$content .= '>';
	//			$content .= "<b>Posted:</b> ".$post->post_date." | <b>Author:</b> ".get_the_author_login();
				ob_start();
	//			echo " | <b>Last Modified:</b> ";
	//			the_modified_date( ' Y-m-d ');                                    //date
	//			the_modified_date('H:i');                                         //time
				comments_popup_link(' No Comments &#187;', ' 1 Comment &#187;', ' % Comments &#187;');
				$content .= ob_get_clean();
				$content .= " | <b>Filed under:</b> ".$this->get_my_cats($post->ID)."&nbsp;&nbsp;|&nbsp;&nbsp;<b>Tags:</b> ".$this->get_my_tags($post->ID);
				$content .= '</p>';
			}
	// end of metadata
	
			if ($show_as_list) {
				$content .= "</li> <hr class=\"tpg_get_post_hr\" />";
			} else {
				$content .= '</div>';
			}
		}	
		
		if ($show_as_list)
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
	public function get_post_content($wkcontent) {
		//legacy design requires globals until refactoring can occur
		global $more_link_text, $id;
		$has_teaser=false;
		//$wkarr = preg_split('/<!--more(.*?)?-->/', $wkcontent);
		if ( preg_match('/<!--more(.*?)?-->/', $wkcontent, $matches) ) {
 	    	$wkarr = explode($matches[0], $wkcontent, 2);
			
            if ( !empty($matches[1]) && !empty($more_link_text) ) {
 	        	$more_link_text = strip_tags(wp_kses_no_null(trim($matches[1])));
			}
			$has_teaser = true;
		} else {
			$wkarr = array($wkcontent);
		}
		
		if ($this->short_content) {
			$wkcontent = $this->shorten_text($this->sc_style,$this->sc_len,$wkarr[0],$this->ellip);
			$has_teaser = true;
		}else {
			$wkcontent = $wkarr[0];
		}
		//$wkcontent = ($this->short_content)? $this->shorten_text($this->sc_style,$this->sc_len,$wkarr[0],$this->ellip): $wkarr[0];
		//if (!empty($wkarr[1])) {
		if ($has_teaser) {
			$wkcontent .= apply_filters( 'the_content_more_link', ' <a href="' . get_permalink() . "#more-$id\" class=\"more-link\">$more_link_text</a>", $more_link_text );
		}
		$wkcontent = force_balance_tags($wkcontent);
		return $wkcontent;
	}
	
	/**
     * Get the post excerpt
     * 
     * @param object $post
     * @return char  $excerpt
     */
	public function get_excerpt($post){
        
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
    public function get_thumbnail($post,$tn_size,$t_class="alignleft"){

    	if (has_post_thumbnail($post->ID)) {
			$t_content = get_the_post_thumbnail($post->ID,$tn_size,
				($t_class != null) ? array('class' => $t_class ) : null); 
        	$t_thumbnail = '<a href="' . get_permalink($post->ID).'">'.$t_content.'</a>';          
            return $t_content;
        } else {
            return null;
        }
    }
}


?>