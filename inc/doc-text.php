<!--usage documentation-->

<div id="tgp" class="wrap">
	{icon}<h2 class="tgp_head">TPG Get Posts Usage</h2>
	<p class="tgp_warn">WARNING: If you copy/paste the commands, the function may not work. If this happens, type the entire command in to avoid introducing hidden characters.</p>
	
	<div id="gp-tabbed-area">
		<ul class="gp-tabs">
			<li><a href="#gp-overview">Overview</a></li>
			<li><a href="#gp-options">Options</a></li>
			<li><a href="#gp-styling">Styling</a></li>
			<li><a href="#gp-examples">Examples</a></li>
		</ul>
		
	<div id="gp-overview">
		<h3>Overview</h3>
		<p>To use it, just put the following into the HTML of any page or post, use as many times as you like on the same page:</p>
		
		<blockquote><pre>[tpg_get_posts]</pre></blockquote>
		<p>this is equivalent to:</p>
		
		<blockquote><pre>[tpg_get_posts show_meta="true" show_entire="false" fields="post_title, post_content" 
		 field_classes ="post_title=p_title_class, post_content=p_content_class, 
		 post_metadata=p_metadata_class, post_byline=p_byline_class" numberposts=5 ]</pre></blockquote>
		
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
		</ol>
	</div>
	<div id="gp-options">	
		<h3>Options</h3>
		<p>Based on the <a href="http://codex.wordpress.org/Template_Tags/get_posts" target="_blank">get_posts</a> template tag, all of the possible parameters associated with this plugin are documented in the WP_Query class to which fetches posts. See the <a href="http://codex.wordpress.org/Class_Reference/WP_Query#Parameters" target="_blank">parameters section</a> of the WP_Query documentation for a list of parameters that this function accepts. </p>
		
		<dl>
		<h4>Some common parameters are:</h4>
			<dt>tag</dt><dd>This allows for the selection of posts by tag.</dd>
		
			<dt>category_name</dt><dd>This allows for the selection of posts by category_name.</dd>
		
			<dt>category</dt><dd>This allows for the selection of posts by category number.</dd>
			<dt>numberposts</dt>
			<dd>Specify the maximum number of posts to select.  The default is 5.</dd>
		
		<h4>Along with all the parameters provided by the WordPress get_posts template tag, this plugin will also accept a few additional parameters:</h4>
			<dt>show_entire</dt><dd>This option show_entire="true" will show the entire post, not just the teaser. Default is "false".</dd>
		
			<dt>show_meta</dt><dd>This option show_meta="false" will suppress the display of metadata. Default is "true".</dd>
		
			<dt>show_byline</dt><dd>This option show_byline="false" will suppress the display of the by-line. Default is "true".</dd>
			
			<dt>thumbnail_size</dt><dd>Enter "thumbnail", "medium", "large" or"full" as the option value and if the thumbnail has been entered, it is used.  Example thumbnail_size="medium". Default is "", ignore thumbnail.  Note:  the thumbnail requires an extra database call before fetching the image from the media gallery, so from a performance standpoint, it is best to insert the images in your post.</dd>
			
			<dt>thumbnail_only</dt><dd>This option thumbnail_only="true" will only the thumbnail as a link to the post page.  Use in conjunction with the thumbnail_size to set the size of the image.   Default is "false".<br />** This is experimental and is subject to change. **</dd>
			
			<dt>show_excerpt</dt><dd>This option show_excerpt="true" will use the custom excerpt, if it exists, instead of the post content.  It will use the entire excerpt entry. Default is "false".</dd>
			
			<dt>more_link_text</dt><dd>This option changes the text to display whenthe more tag is used to produce a teaser.  Enter as more_link_text="My Custom Text". Default is "(read more...)".</dd>
		
			<dt>shorten_title</dt><dd>This option shorten_title="c15" or shorten_title="w15" specifies that the title will be shortened to 15 characters. The 'c' indicates to cut at the character while the 'w' indicates that only whole words in the first 15 characters are included.</dd>
		
			<dt>shorten_content</dt><dd>Using the more tag is generally a better option, but is is provided for consistency. This option shorten_content="c150" or shorten_content="w150" specifies that the content will be shortened to 150 characters, excluding the "read more..." text. The 'c' indicates to cut at the character while the 'w' indicates that only whole words in the first 150 characters are included. The 'read more' tag is processed first, then this process is applied, so a read more tag can cause the text to be shorter than the specified length if placed in the post before the first x characters.</dd>
		
			<dt>text_ellipsis</dt><dd>This parameter allows you to set the ellipsis displayed after shortened text. it defaults to text_ellipsis=' ...' but can be set to anything or nothing text_ellipsis=''.</dd>
		
			<dt>title_tag</dt><dd>This parameter controls the formatting of the title line. The default is to make post titles h2, which is consistent with the regular post markup. title_tag="p" will apply the paragraph markup to the title instead of the h2 markup. Note: do not include the <>.</dd>
		
			<dt>ul_class</dt><dd>This is the class assigned to the bullet list. When this class is provided, the output is returned as an unordered list.</dd>
		
			<dt>fields</dt><dd>This is a comma separated list of fields to show, taken right from the <a href="http://codex.wordpress.org/Database_Description#Table:_wp_posts" target="_blank">wp_posts database</a> table fields. The default is "post_title, post_content".  If only a list of titles is desired, remove the post_content parm from the list and no content will be returned.  At this time only post_title and post_content are selectable.</dd>
		
			<dt>field_classes</dt><dd> This is a special list which assigns a class to a post field.  It is formatted in a key=value sequence separated by a comma.  The key defines a section of the post while the value is the name of a class to which will be provided via a tag wrapped around the field. The default classes are post_title=p_title_class, post_content=p_content_class, post_metadata=p_metadata_class, post_byline=p_byline_class.  The class can be assigned any value and the css set up in a user defined style sheet.  The key fields cannot be changed.</dd>	
		</dl>
		
	</div>
	<div id="gp-styling">	
		<h3>Styling</h3>
		<p>To over-ride the default styling, create a css file in the tgp-get-post/css folder named user-get-posts-style.css.  When the plugin is loaded, the standard style sheet is loaded and then the user defined style sheet is loaded, if it exists.  The user defined style sheet will not be changed by an upgrade.</p>
		<p>There are two ways to alter the styling: 
		<ol>
		<li>In the user stylesheet, redefine the styles which are listed below.  The simplest approach is to copy the styles from tpg-get-posts-style.css and modify them as needed.
		<dt>p_title_class</dt><dd>class of the post title</dd>
		<dt>p_byline_class</dt><dd>class of the post byline</dd>
		<dt>p_content_class</dt><dd>class for the body of the post</dd>
		<dt>p_metadata_class</dt><dd>class for the metadata</dd>
		</li>
		<li>If you need to pass different formatting to different pages, then the short-code must include the list of new classes.  The list must include all the default parameters, even if not altered:
			<p>The default classes are post_title=p_title_class, post_content=p_content_class, post_metadata=p_metadata_class, post_byline=p_byline_class as shown in the following short-code:
		<blockquote><pre>[tpg_get_posts show_meta="true" show_entire="false" fields="post_title, post_content"
field_classes ="post_title=p_title_class, post_content=p_content_class, post_metadata=p_metadata_class,
post_byline=p_byline_class" numberposts=5 ]</pre></blockquote></p></li>
		 </ol></p>
		 <p>To alter the entire post, use method one and modify the #tpg-get-posts-post style.  This is a wrapper div for the entire post.</p>
		 
	</div>	
	<div id="gp-examples">
		<h3>Examples:</h3>
		
		<blockquote><pre>[tpg_get_posts tag="tag1,tag2" numberposts=5 orderby="title]</pre></blockquote>
		
		<p>Shows 5 posts with the tag "tag1" or "tag2" ordered by title. Display the post title and content teaser.</p>
		
		<blockquote><pre>[tpg_get_posts category_name="Events,News" numberposts=2 orderby="title" show_entire="true"]</pre></blockquote>
		
		<p>Shows 2 posts with the category name of "Events" or "News" ordered by title. Display the post title and the entire content.</p>
		
		<blockquote><pre>[tpg_get_posts tag="tag5" fields="post_title" ul_class="p_ul_class"]</pre></blockquote>
		
		<p>Shows a bullet list of post titles. The title will be wrapped in a tag with a class of "class1", the date with a of class "p_ul_class". The title will provide a link to the post. The title can be formatted with a css style .p_ul_class h2 {}.</p>
		
		<h3>How to Use:</h3>{donate}
		<p>If you wish to have a subset of posts appear on a specific page.  The simplest approach is to specify a unique category and select it for the post you want to appear.  You can have multiple categories for a post, so this will not alter your existing website structure.</p>
		
		<p> For instance, suppose you want to show 2 posts on your home page, but not everything you post, only certain dealing with high profile events. The following steps should do this:</p>
		<ol>
			<li>Create a new category "homepage"</li>
			<li>For each post that is to appear on the home page, select the category "homepage"</li>
			<li>On your home page, enter the following shortcode where you want the posts inserted:
			<blockquote><pre>[tpg_get_posts category_name="homepage" numberposts=2]</pre></blockquote></li>
		</ol> 
		<p>That should do it!</p>
	</div>
	</div>
</div>
