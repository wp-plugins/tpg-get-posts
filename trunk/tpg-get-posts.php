<?php
/*
Plugin Name: TPG Get Posts
Plugin URI: http://www.tpginc.net/blog/wp-plugins/
Description: Adds a shortcode tag [tpg_get_posts] to display posts on page.
Version: 1.0
Author: Criss Swaim
Author URI: http://blog.tpginc.net/
*/

/*  The code is based on nurelm-get-posts

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// functions for formating post
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

// get the posts
function tpg_get_posts_gen($args = '') {
	global $id, $post, $more;
//	global $id, $post, $more, $page, $pages, $multipage, $preview, $pagenow;
		
  $r = shortcode_atts(
    array(
      'numberposts'      => '5',
      'offset'           => '',
      'category'         => '',
      'category_name'    => '',
      'tag'              => '',
      'orderby'          => 'date',
      'order'            => '',
      'include'          => '',
      'exclude'          => '',
      'meta_key'         => '',
      'meta_value'       => '',
      'post_type'        => '',
      'post_status'      => '',
      'post_parent'      => '',
      'nopaging'         => '',
	  'end-of-parms'     => '---------',
	  'post_entire'      => 'false',
	  'show_meta'        => 'true',
      'ul_class'         => '',
      'fields'           => 'post_title, post_content',
      'fields_classes'   => 'p_title_class, p_content_class'),
    $args );
	
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
	$fields_classes_list = explode(",", $r['fields_classes']);

	if ( null === $more_link_text )
		$more_link_text = __( '(read more...)' );
		
	if ($r['post_entire'] == "true") {
		$post_entire = true;
	} else {
		$post_entire = false;
	}
	
	if ($r['show_meta'] == "true") {
		$show_meta = true;
	} else {
		$show_meta = false;
	}
	
	if ($r['ul_class'] == "") {
		$show_as_list = false;
	} else {
		$show_as_list = true;
	}
	
	//
	$content = '<div id="tpg-get-posts" />';
	if ($show_as_list) {
		$content .="<ul class=\"".$r['ul_class']."\">\n";
	}

// get posts
	$posts = get_posts($q_args);
	foreach( $posts as $post ) {
		if ($show_as_list) 
			$content .= "  <li>";
			
		setup_postdata($post);
		$i = 0;
    	foreach ( $fields_list as $field ) {

			if (isset($fields_classes_list[$i])) {
				$content .= "<span class=\"" . trim($fields_classes_list[$i]) . "\">";
			}

			$field = trim($field);
			
			$wkcontent = $post->$field;                                         //get the content
			switch ($field) {
				case "post_title":
					$wkcontent = '<h2><a href="'.get_permalink($post->ID).'" id="">'.$wkcontent.'</a></h2>';
					$wkcontent .= '<p class="p_byline" >By '.get_the_author().' on '.mysql2date('F j, Y', $post->post_date).'</p>';
					break;
				case "post_content":					
					if (!$post_entire) {           //show only teaser 
						$content_strings = preg_split('/<!--more(.*?)?-->/', $wkcontent);
						$wkcontent = '<div id="tpg_post_content">'.$content_strings[0];
//						$wkcontent .= '<a href="'.get_permalink($post->ID).'" class=\"more-link\">'.$more_link_text.'</a></div>';
						$wkcontent .= apply_filters( 'the_content_more_link', ' <a href="' . get_permalink() . "#more-$id\" class=\"more-link\">$more_link_text</a></div>", $more_link_text );
						$wkcontent = force_balance_tags($wkcontent);
					}else {
						$wkcontent = '<div id="tpg_post_content">'.$wkcontent.'</div>';
					}
					break;
			}
			
	  		$content .= $wkcontent;

			if (isset($fields_classes_list[$i])) {
				$content .=  "</span>";
			}
			
			$i++;
		}
// print post metadata
		if ($show_meta) {
			$content .= '<small><p class="p_metadata_class">&nbsp;&nbsp;&nbsp;';
//			$content .= "<b>Posted:</b> ".$post->post_date." | <b>Author:</b> ".get_the_author_login();
			ob_start();
//			echo " | <b>Last Modified:</b> ";
//			the_modified_date( ' Y-m-d ');                                    //date
//			the_modified_date('H:i');                                         //time
			comments_popup_link(' No Comments &#187;', ' 1 Comment &#187;', ' % Comments &#187;');
			$content .= ob_get_clean();
			$content .= " | <b>Filed under:</b> ".get_my_cats($post->ID)."&nbsp;&nbsp;|&nbsp;&nbsp;<b>Tags:</b> ".get_my_tags($post->ID);
			$content .= '</p></small>';
		}
// end of metadata

    	if ($show_as_list) 
			$content .= "</li> <hr class=\"tpg_get_post_hr\" />";
	}	
	
	if ($show_as_list)
		$content .= '</ul>';
	$content .= '</div><!-- #tpg-get-posts -->';
	return $content;	
}

add_shortcode('tpg_get_posts', 'tpg_get_posts_gen');
?>
