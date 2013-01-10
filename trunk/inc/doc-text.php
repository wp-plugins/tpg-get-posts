<!--usage documentation-->

<div id="tgp" class="wrap">
	{icon}<h2 class="tgp-head">TPG Get Posts Usage</h2>
	<!--<p class="tgp-warn">WARNING: If you copy/paste the commands, the function may not work. If this happens, type the entire command in to avoid introducing hidden characters.</p>-->
	<p>&nbsp;</p>
	
	<div id="gp-tabbed-area">
		<ul class="gp-tabs">
			<li><a href="#gp-overview">Overview</a></li>
			<li><a href="#gp-options">Options</a></li>
			<li><a href="#gp-styling">Styling</a></li>
			<li><a href="#gp-examples">Examples</a></li>
			<li><a href="#gp-settings">Settings</a></li>
		</ul>
		
	<div id="gp-overview">
		<h3>Overview</h3>
		<p>To use it, just put the following into the HTML of any page or post, use as many times as you like on the same page:</p>
		
		<p class="tgp-warn">WARNING: If you copy/paste the commands, the function may not work.  Often the hidden &lt;code&gt; and &lt;pre&gt; are copied into the page and only show in the html edit view of the WP editor.  If this happens, type the entire command in to avoid introducing hidden characters.</p>
		
		<blockquote><pre>[tpg_get_posts]</pre></blockquote>
		<p>this is equivalent to:</p>
		
		<blockquote><pre>[tpg_get_posts show_meta="true" show_entire="false" fields="title ,byline,content,metadata" field_classes ="post_title=tpg-title-class, post_content=tpg-content-class,  post_metadata=tpg-metadata-class, post_byline=tpg-byline-class" numberposts=5 ]</pre></blockquote>
		
		<p>This default usage will return the last 5 posts in reverse chronological order. It will display the post similarly to a standard post, honoring the tag to produce a teaser. Meta data showing post date, author, modified date, comments, categories and tags is also displayed.</p>
		
		<p>If the post was created with a more tag inserted, the teaser is shown with a link to 'read more'.   See the option show entire if the entire post is to be shown.  At this time, the excerpt is not recognized.</p>
		
		<p>A common usage is to show post on a page that have a common tag(s):</p>
		
		<blockquote><pre>[tpg_get_posts tag="tag1, tag2,tag3"]</pre></blockquote>
		<p>or to show specific posts on the home page:</p>
		<blockquote><pre>[tpg_get_posts category_name="homepage" numberposts=2]</pre></blockquote>
		{donate}
		<h3>To Do:</h3>
		<ol>
		<li>add pagination</li>
		<li>add template tag...until then to incorporate TPG Get Posts into a template try using 
&lt;?php echo do_shortcode('[tpg_shortcode]'); ?&gt;   </li>
		</ol>
	</div>
	<div id="gp-options">	
		<h3>Options</h3>
		<p>Based on the <a href="http://codex.wordpress.org/Template_Tags/get_posts" target="_blank">get_posts</a> template tag, all of the possible parameters associated with this plugin are documented in the WP_Query class to which fetches posts. See the <a href="http://codex.wordpress.org/Class_Reference/WP_Query#Parameters" target="_blank">parameters section</a> of the WP_Query documentation for a list of parameters that this function accepts. </p>
		
		<dl>
		<h4>Some common parameters are:</h4>
		<p class="tpg-prem">Premium options are in green.</p>
			<dt>tag</dt><dd>This allows for the selection of posts by tag.</dd>
		
			<dt>category_name</dt><dd>This allows for the selection of posts by category_name.</dd>
		
			<dt>category</dt><dd>This allows for the selection of posts by category number.</dd>
			<dt>numberposts</dt>
			<dd>Specify the maximum number of posts to select.  The default is 5.</dd>
			
			<dt class="tpg-prem">category__and</dt> <dd>Boolean which defaults to false.  if set to true, then the selcted categories are selected with and logic.  Category or category_name may be used.</dd> 
			<dt class="tpg-prem">category__in </dt><dd>Boolean which defaults to false.  if set to true, then the selcted categories are selected which are in the list and child categories are not selected.  Category or category_name may be used.</dd>
			<dt class="tpg-prem">'category__not_in</dt> <dd>Boolean which defaults to false.  if set to true, then the selcted categories are selected which are not in the list.  Category or category_name may be used.</dd>
		
		<h4>Along with all the parameters provided by the WordPress get_posts template tag, this plugin will also accept a few additional parameters:</h4>
			<dt>show_entire</dt><dd>This option show_entire="true" will show the entire post, not just the teaser. Default is "false".</dd>
		
			<dt>show_meta</dt><dd>This option show_meta="false" will suppress the display of metadata. Default is "true".</dd>
		
			<dt>show_byline</dt><dd>This option show_byline="false" will suppress the display of the by-line. Default is "true".</dd>
			
			<dt>thumbnail_size</dt><dd>Enter "thumbnail", "medium", "large" or"full" as the option value and if the thumbnail has been entered, it is used.  Example thumbnail_size="medium". Default is "", ignore thumbnail.  </dd>
			
			<dt>thumbnail_only</dt><dd>This option thumbnail_only="true" will only the thumbnail as a link to the post page.  Use in conjunction with the thumbnail_size to set the size of the image.   Default is "false".<br />** This is experimental and is subject to change. **</dd>
			
			<dt>show_excerpt</dt><dd>This option show_excerpt="true" will use the custom excerpt, if it exists, instead of the post content.  It will use the entire excerpt entry. Default is "false".</dd>
			
			<dt class="tpg-prem">mag_layout</dt><dd>This option mag_layout="true" places the thumbnail at the begining of the post items so it can float left and have the title and content beside the image.  The 'post layout' puts the title above the image and only the content wraps around the the image.</dd>
			
			<dt>more_link_text</dt><dd>This option changes the text to display whenthe more tag is used to produce a teaser.  Enter as more_link_text="My Custom Text". Default is "(read more...)".</dd>
		
			<dt>shorten_title</dt><dd>This option shorten_title="c15" or shorten_title="w15" specifies that the title will be shortened to 15 characters. The 'c' indicates to cut at the character while the 'w' indicates that only whole words in the first 15 characters are included.</dd>
		
			<dt>shorten_content</dt><dd>Using the more tag is generally a better option, but is is provided for consistency. This option shorten_content="c150" or shorten_content="w150" specifies that the content will be shortened to 150 characters, excluding the "read more..." text. The 'c' indicates to cut at the character while the 'w' indicates that only whole words in the first 150 characters are included. The 'read more' tag is processed first, then this process is applied, so a read more tag can cause the text to be shorter than the specified length if placed in the post before the first x characters.</dd>
		
			<dt>text_ellipsis</dt><dd>This parameter allows you to set the ellipsis displayed after shortened text. it defaults to text_ellipsis=' ...' but can be set to anything or nothing text_ellipsis=''.</dd>
		
			<dt>title_tag</dt><dd>This parameter controls the formatting of the title line. The default is to make post titles h2, which is consistent with the regular post markup. title_tag="p" will apply the paragraph markup to the title instead of the h2 markup. Note: do not include the <>.</dd>
			
			<dt>title_link</dt><dd>Setting this option to title_link="false" will suppress the wrapping of the title with the hyperlink tag and the title will not be a link. Default is "true".</dd>
		
			<dt>ul-class</dt><dd>This is the class assigned to the bullet list. When this class is provided, the output is returned as an unordered list.</dd>
		
			<dt>fields</dt><dd>This is a comma separated list of fields to be displayed. The default is "title, byline, content, metadata".  If only a list of titles is desired, remove the othe parms from the list and no content will be returned, ie fields="title".</dd>
		
			<dt>field_classes</dt><dd> This is a special list which assigns a class to a post field.  It is formatted in a key=value sequence separated by a comma.  The key defines a section of the post while the value is the name of a class to which will be provided via a tag wrapped around the field. The default classes are post_title=tpg-title-class, post_content=tpg-content-class, post_metadata=tpg-metadata-class, post_byline=tpg-byline-class.  The class can be assigned any value and the css set up in a user defined style sheet.  The key fields cannot be changed.</dd>	

			<dt class="tpg-prem">cf</dt><dd>Invoke the user Custom Functions by passing the codes for each exit to be invoked, ie cf='ppre,ppst,pre,pst,t,b,c,m'. The model function php file is provided in the /ext files folder and instructions are in the comments.
			ppre => before the invoking of the plugin
			ppst => upon completion of plugin, just before returning results
			pre  => before each post
			pst  => after each post
			t,b,c,m => after title,byline,content,metadata -- this allows final editing
			</dd>
			<dt class="tpg-prem">cfp</dt><dd>Custom functions parameters.  This is an optional string that is passed to the custom functions routine.  It must be parsed by the custom function and is defined by the user.</dd>	
		</dl>
		
		<p>To exclude posts, see examples.</p>
		
	</div>
	<div id="gp-styling">	
		<h3>Styling</h3>
		<p>To over-ride the default styling, create a css file in your theme root folder named <b>user-get-posts-style.css</b>.  When the plugin is loaded, the standard style sheet is loaded and then the user defined style sheet is loaded, if it exists.  Any tags in the user style-sheet will override the standard style.</p>
		<p><em><b>By saving your custom user defined style sheet in the theme folder it will not be deleted with an upgrade to the plugin.  This is a change from version 1.x</b></em></p>
		<p>There are two ways to alter the styling: 
		<ol>
		<li>In the user stylesheet, redefine the styles which are listed below.  The simplest approach is to copy the styles from tpg_get_posts-style.css and modify them as needed. **Note: With release 2, the naming conventions for classes changed.  Please use the ones listed below as the older class names will be removed in a future release. 
		<dt class="tpg-prem">tpg-title-class</dt><dd>class of the post title division</dd>
		<dt>tpg-byline-class</dt><dd>class of the post byline</dd>
		<dt>tpg-content-class</dt><dd>class for the body of the post</dd>
		<dt>tpg-metadata-class</dt><dd>class for the metadata</dd>
		<dt>tpg-excerpt-class</dt><dd>class for the excerpt</dd>
		<dt class="tpg-prem">tpg-thumbnail-class</dt><dd>class for the thumbnail division</dd>
		</li>
		<li>If you need to pass different formatting to different pages, then the short-code must include the list of new classes.  The list must include all the default parameters, even if not altered:
			<p>The default classes are post_title=tpg-title-class, post_content=tpg-content-class, post_metadata=tpg-metadata-class, post_byline=tpg-byline-class as shown in the following short-code:
		<blockquote><pre>[tpg_get_posts show_meta="true" show_entire="false" fields="post_title, post_content"
field_classes ="post_title=tpg-title-class, post_content=tpg-content-class, post_metadata=tpg-metadata-class,
post_byline=tpg-byline-class" numberposts=5 ]</pre></blockquote></p></li>
		 </ol></p>
		 <ul>
		  <dt class="tpg-prem">Premium Formatting Control Template</dt><dd>The Premium plugin allows for the formatting of the by line and the meta line.  For example, you can change the byline from showing the default of author, post date to just author or author, last maint date, last maint time.   <br /><br />Within each line, there are several post tags which can be displayed and each tag can be formatted.</dd>
		
		<dt class="tpg-prem">byline_fmt</dt><dd>default byline_fmt=" ,auth,dp" sep,meta_tag,meta_tag....</dd>
		<dt class="tpg-prem">metaline_fmt</dt><dd>default byline_fmt="&nbsp;&nbsp;|&nbsp;&nbsp;,cmt,cat,tag"</dd>	 
		 
		<dt>tags for use in line</dt><dd> Valid tags for use in byline and meta data line are: <br />
		<li>auth_fmt - author name</li> 
		<li>cat_fmt - list of categories assigned to post</li>
		<li>cmt_fmt - comment, with format control for no, 1 or many comments</li>
		<li>dp_fmt - date posted</li>
		<li>dm_fmt - date of last maintenance</li>
		<li>tag_fmt - list of tags assigned to post</li>
		<li>tm_fmt - time of last maintenance</li>
		<li>tp_fmt - time of posting</li>
		<p><b>Note</b>:  if you wish to use a comma in the the formatting, use the code <code>&amp;#44;</code>  The parsing routine uses commas to parse the format options, so the html code must be used to circumvent the parser. </p></li>
		
		<dt class="tpg-prem">auth_fmt</dt><dd>default: auth_fmt=",By ,"   (separator,b4 text,after text)</dd>
		<dt class="tpg-prem">cat_fmt</dt><dd>default: cat_fmt="&amp;#44; ,Filed under: ,"   (separator,b4 text,after text)</dd>
		<dt class="tpg-prem">cmt_fmt</dt><dd>default: cmt_fmt=" No Comments &#187;, 1 Comment &#187;, Comments &#187;"   (nocmt,1-cmt, multi-cmt)</dd>
		<dt class="tpg-prem">dp_fmt</dt><dd>default: dp_fmt="F j&amp;#44; Y, on ,"   (date format,b4 text,after text)</dd>
		<dt class="tpg-prem">dm_fmt</dt><dd>default: dm_fmt="F j&amp;#44; Y, on: ,"   (date format,b4 text,after text)</dd>
		<dt class="tpg-prem">tag_fmt</dt><dd>default: tag_fmt="&amp;#44; ,<b>Tags:</b> ,"    (separator,b4 text,after text)</dd>
		<dt class="tpg-prem">tm_fmt</dt><dd>default: tm_fmt="H:m:s, ,"    (time format,b4 text,after text)</dd>
		<dt class="tpg-prem">tp_fmt</dt><dd>default: tp_fmt="H:m:s, ,"    (time format,b4 text,after text)</dd>
		 </ul>
		 <p>To alter the entire post, use method one and modify the #tpg_get_posts-post style.  This is a wrapper div for the entire post.</p>
		 
	</div>	
	<div id="gp-examples">
		<h3>Examples:</h3>
		
		<blockquote><pre>[tpg_get_posts tag="tag1,tag2" numberposts=5 orderby="title"]</pre></blockquote>
		
		<p>Shows 5 posts with the tag "tag1" or "tag2" ordered by title. Display the post title and content teaser.</p>
		
		<blockquote><pre>[tpg_get_posts category_name="Events,News" numberposts=2 orderby="title" show_entire="true"]</pre></blockquote>
		
		<p>Shows 2 posts with the category name of "Events" or "News" ordered by title. Display the post title and the entire content.</p>
		
		<blockquote><pre>[tpg_get_posts tag="tag5" fields="title"  ul_class="tpg-ul-class"]</pre></blockquote>
		
		<p>Shows a bullet list of post titles. The title will be wrapped in a tag with a class of "tpg-ul-class".  The title will provide a link to the post. The title can be formatted with a css style .tpg_ul_class h2 {}.</p>
		
		<blockquote><pre>[tpg_get_posts category="15,-4" ]</pre></blockquote>
		
		<p>To exclude a category within a selected category, you must use the category id for the selection.  The minus sign in front of the cateory id tells the query to exlude a category.  So this shortcode will select all the posts in category 15 and then eliminate all the post that are also in category 4.</p>
		
		<blockquote><pre>[tpg_get_posts category__in="Events" byline_fmt"auth,dm,tm", dm_fmt="F j&amp;#44; Y, last changed on: ,"]</pre></blockquote>
		
		<p class="tpg-prem">Formats the byline with author, date and time and the date format is defined in the dm_fmt option to produce 'last changed on: Month day, YYYY'.</p>
		
		
		<h3>How to Use:</h3>{donate}
		<p>If you wish to have a subset of posts appear on a specific page.  The simplest approach is to specify a unique category and select it for the post you want to appear.  You can have multiple categories for a post, so this will not alter your existing website structure.</p>
		
		<p> For instance, suppose you want to show 2 posts on your home page, but not everything you post, only those dealing with high profile events. The following steps should do this:</p>
		<ol>
			<li>Create a new category "homepage"</li>
			<li>For each post that is to appear on the home page, select the category "homepage"</li>
			<li>On your home page, enter the following shortcode where you want the posts inserted:
			<blockquote><pre>[tpg_get_posts category_name="homepage" numberposts=2]</pre></blockquote></li>
		</ol> 
		<p>That should do it!</p>
	</div>
	<div id="gp-settings">{settings}
	
		<h3>Instructions for Upgrading to the Premium Version:</h3>
		<p>Purchase a license at <a href="http://www.tpginc.net/product/tpg-get-posts/" target="_blank">http://www.tpginc.net/product/tpg-get-posts/</p>
		<p>After purchasing a licences, an email will be sent to you with the Lic Key.</p>
		
		<ol>To activate:
		<li>Add the Lic Key and Lic Email on the TPG Get Posts Settings tab</li>
		<li>Select the Keep Options on uninstall checkbox</li>
		<li>Click the Update Options to save the options </li>
		<li>Click the Validate Lic to register and receive new update notices</li>
		<br />
		</ol>
		<ol>To manually load the extension:
		<li>Click the download link in the email</li>
		<li>FTP the contents of the /ext folder to your site</li>
		<li>Activate by following instructions above </li>
		</ol>
		
	
	</div>
  </div>
</div>
