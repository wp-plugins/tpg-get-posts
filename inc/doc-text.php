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
		
		<blockquote><pre>[tpg_get_posts fields="title ,byline,content,metadata" numberposts=5 
field_classes="post_title=tpg-title-class,post_content=tpg-content-class,post_metadata=tpg-metadata-class, post_byline=tpg-byline-class" ]</pre></blockquote>
		
		<p>This default usage will return the last 5 posts in reverse chronological order. It will display the post similarly to a standard post, honoring the more tag to produce a teaser. Meta data showing post date, author, modified date, comments, categories and tags is also displayed.</p>
		
		<p>If the post was created with a more tag inserted, the teaser is shown with a link to 'read more'.   See the option show entire if the entire post is to be shown.  The excerpt is can be shown with the show_excerpt option.</p>
		
		<p>A common usage is to show post on a page that have a common tag(s):</p>
		
		<blockquote><pre>[tpg_get_posts tag="tag1, tag2,tag3"]</pre></blockquote>
		<p>or to show specific posts on the home page:</p>
		<blockquote><pre>[tpg_get_posts cat="homepage" numberposts=2]</pre></blockquote>
		{donate}
		<h3>To Do:</h3>
		<ol>
		<li>add template tag...until then to incorporate TPG Get Posts into a template try using 
&lt;?php echo do_shortcode('[tpg_get_posts]'); ?&gt;   </li>
		</ol>
		<h3>Premium Options</h3>
		<li>magazine layout option which displays the post header and text next to the post thumbnail</li>
		<li>the short code can be added to a text widget</li>
		<li>extended cat__and, cat__not_in and cat__in and other taxonmy</li>
		<li>extensive formatting of the by line and meta-data line</li>
		<li>allow pagination </li>
		<li>sticky post support</li>

	</div>
	<div id="gp-options">	
		<h3>Options</h3>
		<p>Based on the <a href="http://codex.wordpress.org/Template_Tags/get_posts" target="_blank">get_posts</a> template tag, all of the possible parameters associated with this plugin are documented in the WP_Query class to which fetches posts. See the <a href="http://codex.wordpress.org/Class_Reference/WP_Query#Parameters" target="_blank">parameters section</a> of the WP_Query documentation for a list of parameters that this function accepts. </p><p>Note that if the parameter expects an array, then it must be handled explicitly in the parameter interface.  If that is not listed here, then it is not accepted.</p>
		
		<dl>
		<p class="tpg-prem">Premium options are in green.</p>
		<h4>Selection parameters are:</h4>
			
			<dt>tag</dt><dd>This allows for the selection of posts by tag (slug).</dd>
			<dt>tag_id</dt><dd>This allows for the selection of posts by tag id.</dd>
			<dt>cat</dt><dd>A comma separated list of cateory names,slugs or ids.  <br />These are OR logic comparisons.  Examples:  cat='4', cat='5,3,4', cat='news,events,5' cat='news'.  The category name is the name and not the slug. The coversion routine will look for id, slug and then category.  To accomodate complex taxonomonies and where a category name is repeated as a sub category use either slug or id.  Slugs and id''s are unique where a category name can be repeated.</dd>

			<dt>numberposts</dt><dd>Specify the maximum number of posts to select.  The default is 5.</dd>
			<dt>offset</dt><dd>Specify the number of posts to skip.  This is a standard option to WP_Query.  If offset=3 is entered, the post will start showing at the 4 post.  The default is 0, show all.</dd>
			
			<dt class="tpg-prem">posts_per_page</dt><dd>Specify the number of posts to show on page and enable pagination.  The numberposts option is ignored when this is specified. See the page_next_text and page_prev_text to set the text.  If paging on front page, see fp_pagination option.</dd>
			
			<dt class="tpg-prem">fp_pagination</dt><dd>This option is used in conjunction with the post_per_page option.  If the pagination is on a static front page, set fp_pagination='true'.  </dd>
			
			<dt>post_type</dt><dd>This allows for the selection custom post types.</dd>
			<dt>post_status</dt><dd>This allows for the selection by post status.</dd>
			
			<dt class="tpg-prem">ignore_sticky_posts</dt><dd>Set to false, ignore_sticky_posts='false', to show sticky posts in selection.  By default the sticky posts only show on the home page.  By setting the option, the plugin will show sticky posts on any page.  The sticky posts are added to the beginning of the post list.  If you have requested 4 posts and you have 2 sticky, then 6 posts will be shown on the first page.</dd>
			
			<dt class="tpg-prem">category__and</dt> <dd> A comma separated list of either categories or category_names may be used in this paramter.  The values passed here will replace any value in the cat_name or cat tag. Posts must have be in all the categories (AND logic).</dd> 
			<dt class="tpg-prem">category__in </dt><dd>A comma separated list of either categories or category_names may be used in this paramter.  The values passed here will replace any value in the cat_name or cat tag. Post may be in any of the categories (OR logic) and child posts are not pulled.</dd>
			<dt class="tpg-prem">'category__not_in</dt> <dd>A comma separated list of either categories or category_names may be used in this paramter.  The values passed here will replace any value in the cat_name or cat tag.  Excludes posts in the listed categories.</dd>
			
			<dt class="tpg-prem">tag__and</dt> <dd>A comma separated list of tag_ids may be used in this paramter. Posts must have be in all the tag_ids (AND logic).</dd> 
			<dt class="tpg-prem">tag__in </dt><dd>A comma separated list of tag_ids may be used in this paramter. Posts may be in any of the tag_ids (OR logic).</dd>
			<dt class="tpg-prem">'tag__not_in</dt> <dd>A comma separated list of tag_ids may be used in this paramter. Excludes posts with the listed tag_ids.</dd>
			
			<dt class="tpg-prem">tag_slug__and</dt> <dd>A comma separated list of slugs may be used in this paramter. Posts must have be in all the slugs (AND logic).</dd> 
			<dt class="tpg-prem">'tag_slug__in</dt> <dd>A comma separated list of slugs may be used in this paramter. Posts may be in any of the slugs (OR logic).</dd>
			
			<p>At this time, the following two commands have had limited testing.</p>
			<dt class="tpg-prem">tax_query</dt> <dd>Used to pass the custom taxonomy selection to the plugin.  Because the tax_query accepts nested arrays, the syntax is more complex than other parms and values are passed in json format.  An example using json format: <br> 
tax_query='{"relation":"AND","0":{"taxonomy":"movie_genre","field":"slug","terms":("action","comedy")},"1":{"taxonomy":"actor","field":"id","terms":(103,115,206),"operator":"NOT IN"}}' <br><br>**Note: that json requires the strings to be enclosed with double quotes, so single quotes are required to wrap the tag value.  Also json uses [] to define arrays without keys, but that conflicts with the shortcode syntax.  To work around this, () are substitued in the json string and converted before decoding to an array.</dd> 
			<dt class="tpg-prem">meta_query </dt><dd>Because the meta_query accepts nested arrays, the syntax is more complex than other parms and values are passed in json format.  An example using json format: <br> 
meta_query='({"key":"color","value":"blue","compare":"NOT LIKE"},{"key":"price","value":(20,100),"type":"numeric","compare":"BETWEEN"})' <br><br>**Note: that json requires the strings to be enclosed with double quotes, so single quotes are required to wrap the tag value. Also json uses [] to define arrays without keys, but that conflicts with the shortcode syntax.  To work around this, () are substitued in the json string and converted before decoding to an array.</dd>
			
		
		<h4>Layout/format control parameters:</h4>
		
			<dt>fields</dt><dd>This is a comma separated list of fields to be displayed. The default is "title, byline, content, metadata".  If only a list of titles is desired, remove the othe parms from the list and no content will be returned, ie fields="title".</dd>
		
			<dt>field_classes</dt><dd> This is a special list which assigns a class to a post field.  It is formatted in a key=value sequence separated by a comma.  The key defines a section of the post while the value is the name of a class to which will be provided via a tag wrapped around the field. The default classes are listed below.  The class can be assigned any value and the css set up in a user defined style sheet.  The key fields cannot be changed.	  <br /><br />The following is a list of the default field classes which can be overridden:
			<ul style="padding-left:2em"> <br />
			<li>post_title=tpg-title-class</li>
			<li>post_content=tpg-content-class</li> 
			<li>post_metadata=tpg-metadata-class</li> 
			<li>post_byline=tpg-byline-class</li>
			<li>post_thumbnail=tpg-thumbnail-class</li>
			<li>thumbnail_align=alignleft</li>
			<li>post_excerpt=tpg-excerpt-class</li>
			<li>mag_content=tpg-mag-class</li>
			<li>fi_content=tpg-fi-class</li>
			<li>ul_class=tpg-ul-class</li>
			<li>pagination=tpg-pagination-class</li>
			<li>page-next=tpg-next</li>
			<li>page-prev=tpg-prev</li>
			</ul>
			
			</dd>
			
			<dt class="tpg-prem">fi_layout</dt><dd>This option fi_layout="true" in conjunction with the thumbnail_size="medium" option display the post in a 'featured image' format where the featured image is placed above the title.  The fields option can control what text to display.<br> The thumbnail_size is required when displaying the thumbnail/featured image.</dd>
			
			<dt class="tpg-prem">mag_layout</dt><dd>This option mag_layout="true" in conjunction with the thumbnail_size="thumbnail" option places the thumbnail at the beginning of the post items so it can float left and have the title and content beside the image.  The standard 'post layout' puts the title above the image and only the content wraps around the the image. <br> The thumbnail_size is required when displaying the thumbnail/featured image.</dd>
			
			<dt>more_link_text</dt><dd>This option changes the text to display when the more tag is used to produce a teaser.  Enter as more_link_text="My Custom Text". Default is "(read more...)".</dd>
			
			<dt class="tpg-prem">page_next</dt><dd>The option page_next='true' will show just the Previous and Next link instead of the pagination index.  The default is false.</dd>
		    <dt class="tpg-prem">page_prev_text</dt><dd>Set the text for the previous link. Default is '&laquo; Previous'.</dd> 
		    <dt class="tpg-prem">page_next_text</dt><dd>Set the text for the next link. Defautl is 'Next &raquo;'.</dd>
			
			<dt>shorten_title</dt><dd>This option shorten_title="c15" or shorten_title="w15" specifies that the title will be shortened to 15 characters. The 'c' indicates to cut at the character while the 'w' indicates that only whole words in the first 15 characters are included.</dd>
		
			<dt>shorten_content</dt><dd>Using the more tag is generally a better option, but is is provided for consistency. This option shorten_content="c150" or shorten_content="w150" specifies that the content will be shortened to 150 characters, excluding the "read more..." text. The 'c' indicates to cut at the character while the 'w' indicates that only whole words in the first 150 characters are included. The 'read more' tag is processed first, then this process is applied, so a read more tag can cause the text to be shorter than the specified length if placed in the post before the first x characters.  <br />Also note that this command does not check for embedded tags.  It trims the content when the limit is reached and is not aware of html tags. Thus tags can be broken. It should only be be used with content that is very controlled. Using the read-more tag is safer.</dd>
		
		
			<dt>show_entire</dt><dd>This option show_entire="true" will show the entire post, not just the teaser.It ignores the more tag in the post content.  Default is "false".</dd>
			
			<dt>show_excerpt</dt><dd>This option show_excerpt="true" will use the custom excerpt, if it exists, instead of the post content.  It will use the entire excerpt entry. Default is "false".</dd>
			
			<dt>text_ellipsis</dt><dd>This parameter allows you to set the ellipsis displayed after shortened text. it defaults to text_ellipsis=' ...' but can be set to anything or nothing text_ellipsis=''.</dd>
			
			<dt>thumbnail_size</dt><dd>Enter "none", thumbnail", "medium", "large" or"full" as the option value and if the thumbnail has been entered, it is used.  Example thumbnail_size="medium". Default is "thumbnail".  Your theme may provide additional options for thumbnail sizes.</dd>
			
			<dt>thumbnail_only</dt><dd>This option thumbnail_only="true" will only the thumbnail as a link to the post page.  Use in conjunction with the thumbnail_size to set the size of the image.   Default is "false"</dd>
			
			<dt>thumbnail_link</dt><dd>This option thumbnail_link="true" is the default and will wrap a thumbnail with the link to the post.  Setting to false will prevent the link on the image.</dd>
		
			<dt>title_tag</dt><dd>This parameter controls the formatting of the title line. The default is to make post titles h2, which is consistent with the regular post markup. title_tag="p" will apply the paragraph markup to the title instead of the h2 markup. Note: do not include the <>.</dd>
			
			<dt>title_link</dt><dd>Setting this option to title_link="false" will suppress the wrapping of the title with the hyperlink tag and the title will not be a link. Default is "true".</dd>
		
			<dt>ul-class</dt><dd>This is the class assigned to the bullet list. When this class is provided, the output is returned as an unordered list.</dd>

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
		<li>In the user stylesheet, redefine the styles which are listed below.  The simplest approach is to copy the styles from tpg_get_posts-style.css and modify them as needed. 
		<p>
		<dt>tpg-title-class</dt><dd>class of the post title division</dd>
		<dt>tpg-byline-class</dt><dd>class of the post byline</dd>
		<dt>tpg-content-class</dt><dd>class for the body of the post</dd>
		<dt>tpg-metadata-class</dt><dd>class for the metadata</dd>
		<dt>tpg-excerpt-class</dt><dd>class for the excerpt</dd>
		<dt>tpg-thumbnail-class</dt><dd>class for the thumbnail division</dd>
		
		</p>
		</li>
		<li>If you need to pass different formatting to different pages, then the short-code must include the list of new classes.  The list must include all the default parameters, even if not altered:
			<p>The default classes are post_title=tpg-title-class, post_content=tpg-content-class, post_metadata=tpg-metadata-class, post_byline=tpg-byline-class as shown in the following short-code:
		<blockquote><pre>[tpg_get_posts show_entire="false" fields="title, content, metadata" numberposts=5
field_classes="post_title=tpg-title-class, post_content=tpg-content-class, post_metadata=tpg-metadata-class,post_byline=tpg-byline-class"  ]</pre></blockquote></p></li>
		 </ol></p>
		 <ul>
		  <dt class="tpg-prem">Premium Formatting Control Template</dt><dd>The Premium plugin allows for the formatting of the by line and the meta line.  For example, you can change the byline from showing the default of author, post date to just author or author, last maint date, last maint time.   <br /><br />Within each line, there are several post tags which can be displayed and each tag can be formatted.</dd>
		<dt class="tpg-prem">Format Line Parms</dt><dd>The format line is a comma separated string with the first value being the separator for the formatted string and then a list of the tags or tokens. The general format is: sep,meta_tag,meta_tag....</dd>
		<dt class="tpg-prem">Valid tags:</dt><dd>
		<li>auth - author name</li> 
		<li>cat  - list of categories assigned to post</li>
		<li>cmt  - comment, with format control for no, 1 or many comments</li>
		<li>dp   - date posted</li>
		<li>dm   - date of last maintenance</li>
		<li>tag  - list of tags assigned to post</li>
		<li>tm   - time of last maintenance</li>
		<li>tp   - time of posting</li>
		</dd>
		<dt class="tpg-prem">byline_fmt</dt><dd>default byline_fmt=" ,auth,dp" </dd>
		<dt class="tpg-prem">metaline_fmt</dt><dd>default metaline_fmt="&nbsp;&nbsp;|&nbsp;&nbsp;,cmt,cat,tag"</dd>	 
		 
		<p>The following format options allow customization of the individual fields in the byline or metaline.</p>
		<p><b>Note</b>:  if you wish to use a comma in the the formatting, use the code <code>&amp;#44;</code>  The parsing routine uses commas to parse the format options, so the html code must be used to circumvent the parser. </p>
		
		<dt class="tpg-prem">auth_fmt</dt><dd>default: auth_fmt=",By ,"   (separator,b4 text,after text)</dd>
		<dt class="tpg-prem">cat_fmt</dt><dd>default: cat_fmt="&amp;#44; ,Filed under: ,"   (separator,b4 text,after text)</dd>
		<dt class="tpg-prem">cmt_fmt</dt><dd>default: cmt_fmt=" No Comments &#187;, 1 Comment &#187;, Comments &#187;"   (nocmt,1-cmt, multi-cmt)</dd>
		<dt class="tpg-prem">dp_fmt</dt><dd>default: dp_fmt="F j&amp;#44; Y, on ,"   (date format,b4 text,after text)</dd>
		<dt class="tpg-prem">dm_fmt</dt><dd>default: dm_fmt="F j&amp;#44; Y, on: ,"   (date format,b4 text,after text)</dd>
		<dt class="tpg-prem">tag_fmt</dt><dd>default: tag_fmt="&amp;#44; ,<b>Tags:</b> ,"    (separator,b4 text,after text)</dd>
		<dt class="tpg-prem">tm_fmt</dt><dd>default: tm_fmt="H:m:s, ,"    (time format,b4 text,after text)</dd>
		<dt class="tpg-prem">tp_fmt</dt><dd>default: tp_fmt="H:m:s, ,"    (time format,b4 text,after text)</dd>
		 </ul>
		 
		 
	</div>	
	<div id="gp-examples">
		<h3>Examples:</h3>
		
		<p>Shows 5 posts with the tag "tag1" or "tag2" ordered by title. Display the post title and content teaser.</p>
		
		<blockquote><pre>[tpg_get_posts tag="tag1,tag2" numberposts=5 orderby="title"]</pre></blockquote>
		
		<p>Shows 2 posts with the category name of "Events" or "News" ordered by title. Display the post title and the entire content.</p>
		
		<blockquote><pre>[tpg_get_posts cat="Events,News" numberposts=2 orderby="title" show_entire="true"]</pre></blockquote>
		
		<p>Shows a bullet list of post titles. The title will be wrapped in a tag with a class of "tpg-ul-class".  The title will provide a link to the post. The title can be formatted with a css style .tpg-ul-class h2 {}.</p>
		
		<blockquote><pre>[tpg_get_posts tag="tag5" fields="title"  ul_class="tpg-ul-class"]</pre></blockquote>
		
		<p>To exclude a category within a selected category, you must use the category id for the selection.  The minus sign in front of the cateory id tells the query to exlude a category.  So this shortcode will select all the posts in category 15 and then eliminate all the post that are also in category 4.</p>
		
		<blockquote><pre>[tpg_get_posts cat="15,-4" ]</pre></blockquote>
		
		<p class="tpg-prem">The magazine layout is available in the premium version.  The layout will float the thumbnail to the left and position the title and byline to the right.  The fields parm controls which elements to show.</p>
		
		<blockquote><pre>[tpg_get_posts cat="25" fields="title, byline"  numberposts=1 mag_layout="true" thumbnail_size="thumbnail"]</pre></blockquote>
				
		<p class="tpg-prem">Pagination.  Show 5 posts per page with the pagination index at the end of the posts. </p>
		
		<blockquote><pre>[tpg_get_posts cat="cat1" posts_per_page=5 field_classes="pagination=tpg-pagination-class my-theme-pagination-class"]</pre></blockquote>
		
		<p>If paging on a static front page use:</p>
		<blockquote><pre>[tpg_get_posts cat="cat1" posts_per_page=5 field_classes="pagination=tpg-pagination-class my-theme-pagination-class" fp_pagination="true"]</pre></blockquote>

		<p class="tpg-prem">Formats the byline with author, date and time and the date format is defined in the dm_fmt option to produce 'last changed on: Month day, YYYY'.</p>
		
		<blockquote><pre>[tpg_get_posts category__in="Events" byline_fmt"auth,dm,tm", dm_fmt="F j&amp;#44; Y, last changed on: ,"]</pre></blockquote>
		
		
		<h3>How to Use:</h3>{donate}
		<p>If you wish to have a subset of posts appear on a specific page.  The simplest approach is to specify a unique category and select it for the post you want to appear.  You can have multiple categories for a post, so this will not alter your existing website structure.</p>
		
		<p> For instance, suppose you want to show 2 posts on your home page, but not everything you post, only those dealing with high profile events. The following steps should do this:</p>
		<ol>
			<li>Create a new category "homepage"</li>
			<li>For each post that is to appear on the home page, select the category "homepage"</li>
			<li>On your home page, enter the following shortcode where you want the posts inserted:
			<blockquote><pre>[tpg_get_posts cat="homepage" numberposts=2]</pre></blockquote></li>
		</ol> 
		<p>That should do it!</p>
	</div>
	<div id="gp-settings">{settings}
	
		<h3>Instructions for Upgrading to the Premium Version:</h3>
		<p>Purchase a license at <a href="http://www.tpginc.net/product/tpg-get-posts/" target="_blank">http://www.tpginc.net/product/tpg-get-posts/</a></p>
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
