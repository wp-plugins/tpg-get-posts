===  TPG Get Posts ===
Contributors: Criss Swaim
Donate link: http://www.tpginc.net/wordpress-plugins/donate/
Tags: get_posts, post, posts, formatting, list, shortcode
Requires at least: 2.8    
Tested up to: 3.5
Stable tag: 2.02.01

Adds a shortcode tag to display posts within a static page or another post.  

== Description ==
Please review the Changelog for release change notices and save any custom styling before applying any upgrade.

This plugin adds the ability to put a shortcode tag in a page or post and have it display a list of posts formatted similarly to the standard blog.  The posts can be selected by one or more tag values, suchs as tags, category, category_name or any other option supported by the WP get_posts function, to show only items relevant for the page.

By default it will show the 5 most recent posts ordered in reverse date order,
but it will accept most of the options provided by the [get_posts template tag]( href=http://codex.wordpress.org/Template_Tags/get_posts ). If the value of the paramter is an array, it must be parsed by the plugin and not all parms have been implemented.

To use it, just put the following into the HTML of any page or post, use as many times as you like on the same page:

	[tpg_get_posts]

	
This default usage will return the last 5 posts in reverse chronological order.  It will display the post similarly to a standard post, honoring the <!more> tag to produce a teaser.  Meta data showing post date, author, modified date, comments, categories and tags is also displayed.
	
See the usage section in 'Other Notes' for a list of parms and more examples of use.  Full doc on the plugin setting page.

**Recent Change**
	The 2.0 release may not format like the 1.x version.  Be sure to test befor upgrading.
	
== Usage ==

**WARNING**  If you copy/paste the commands, the function may not work. If this happens, type the entire command in to avoid introducing hidden characters.

To use it, just put the following into the HTML of any page or post, use as many times as you like on the same page:

	[tpg_get_posts]
	
	this is equivalent to:
	
	[tpg_get_posts show_meta="true" show_entire="false" fields="title,byline,content,metadata" 
	fields_classes ="post_title=tpg-title-class, post_content=tpg-content-class,post_byline=tpg-byline-class,post_metadata=tpg-metadata-class" numberposts=5 ]
	
This default usage will return the last 5 posts in reverse chronological order.  It will display the post similarly to a standard post, honoring the <!more> tag to produce a teaser.  Meta data showing post date, author, modified date, comments, categories and tags is also displayed.

A common usage is to show post on a page that have a common tag or category:
	
		[tpg_get_posts tag="tag1, tag2,tag3"]
	or 
		[tpg_get_posts category_name="catname1, catname2, catname3"]

See Settings in plugin for full list of parameters

A couple of examples:

Show 5 posts with the tag "tag1" or "tag2" ordered by title. Display the post title and content teaser.

	[tpg_get_posts tag="tag1,tag2" numberposts=5 orderby="title]

Show 2 posts with the category name of "Events" or "News" ordered by title. Display the post title and the entire content.

	[tpg_get_posts category_name="Events,News" numberposts=2 orderby="title show_entire="true"]

Show a bullet list of post titles. The title will be wrapped in a of class "p-ul-class".  The title will provide a link to the post. The title can be formatted with a css style .p-ul-class h2 {}.

	[tpg_get_posts tag="tag5" fields="title" ul_class="p-ul-class"]


== Installation ==

1. Upload the plugin to the `/wp-content/plugins/` directory and unzip it.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Place `[tpg_get_posts]` in your pages. 

== Frequently Asked Questions ==

= How to I format the output? =

Set the format in your css
 
* title - .tpg-title-class
* byline - .tpg-byline-class
* content - .tpg-content-class
* metadata - .tpg-metadata-class
* ul - tpg-ul-class,

With release 1.3.1, a custom stylesheet is supported so changes made in the custom style sheet are not lost with an upgrade

= Can this plugin select by category? =

Yes, multiple category_name(s) can be submitted.  The base WordPress function get-posts accepts only a single category, but multiple category ids.  So in the plugin, the category name is converted to the category id and the category_name parameter is blanked out and the post is requested by multiple ids.

= Can I combine categories and tags? =

Yes, but listing both category and tag as selection criteria forms 'and' logic not 'or' logic.  So if a post meets both selection criteria, then it is selected.  If it meets only a single selection, then it is ignored.  

= Can I select categories with 'and' logic? =

Yes, in premium version.  See the doc on using category__and. 

== Screenshots ==

1. Page without plugin active.
2. Plugin setup on a page - selecting only posts assigned to the category home page and supressing by-line and meta data. 
3. The output from the shortcode.
4. Usage page - documentation on options and styling

== Changelog ==
= 2.2.1 =
* correct show_byline & show_meta test - strip spaces from list items

= 2.2.0 =
* added ability to alter order of post items - title,byline,content,meta
* added ability to activate plugin in widgets
* resolved problem with related posts bug (I think)
* modified premium upgrade to not require a reinstall of plugin

= 2.1.1 =
* remove empty <p> after byline

= 2.1.0 =
* Correct display of thumbnails only image size
* Wrap the thumbnail and title in division
* Modify update notice in premium version
* Add a layout to show heading and content next to thumbnail
* Doc update 

= 2.0.2 =
* Add the premium version functionality which allow selection: category_and, category_in and category_not_in.
* Add ability to format the byline & metadata line.
* Add settings options.  
* Code restructuring and changes some html output.

= 1.3.8 =
* Correct html which was failing the validator.  Removed empty id='' and invalid slash.
* Removed span around entire post which conflicted with heading formatting.
* Changed div id tpg_get_posts-post, tpg-post-content, tpg-get-posts-excerpt and tpg-get-posts-thumbnail to classes

= 1.3.7 =
* Correct when application of filters are applied to content, the 3.6 release removed this function from excerpts & post_entire  
* Thank you Hennie de Klerk for your assist in correcting this

= 1.3.6 =
* Apply title filters before displaying the post title
* Thank you Collin Donahue-Oponski for supplying this patch. 
* Change order of applying filter to content to match base wp 
* Added option title_link="false" to suppress making the title a link

= 1.3.5 =
* This is a code restructure to correct some old (and poor) coding techniques
* correct conflict with WP 3.4 in style loading which caused errors in admin section
* correct conflict with tpg-phplist plugin
* corrected doc 

= 1.3.4 =
* correction for shorten_content which was broken several releases back...guess it isn't used much
* corrected doc to use show_entire instead of post_entire.  post_entire is grandfathered, but not documented.

= 1.3.3 =
* allow more tag text to be changed in either the more tag
  or using new parm more_link_text

= 1.3.2 =
* add support for excerpts
* add thumbnail support
* add thumbnail only -- expiremental feature, subject to change 

= 1.3.1.1= 
* correct readme tag appearing on enteries without a more tag

= 1.3.1 =
* add div wrapper around each post to allow some formatting to entire post
* add custom style sheet support 
* changed process for assigning class names to sections of post
 
= 1.3.0 =
* This change is a documentation and code structure change. No additional features have been added.
* Documetation change to show documentation in the settings page of the plugin instead of the readme.
* Restructure code as a class to reduce risk of name clash
 
= 1.2.4 =
* Modified the display of content to correctly parse the caption for images.  Note that the metadata will move up beside the image if a custom css is not set to clear.  I opted to leave formating to the designer and not change the behavior. 

= 1.2.3 =
* Corrected error introduced in version 1.2.2 when no parameters were passed - the argument parameter defaulted as a space and not an array which threw an invalid type error. 

= 1.2.2 =
* Corrected option behavior to allow additional get_posts options to be accepted.  The earlier releases of this plugin only allowed the options defined in the default table to be passed to WP get_posts.  This fix appends any undefined option to the table and passes it to WP get_posts.  thanks cdaley1981 for pointing this out.

= 1.2.1 =
* Added option to suppress byline with show_byline tag.

= 1.2 =
* Corrected typos in documentation
* Add function to restrict length of title and content.
  New options are available to specify the max length of title and max length of content in characters.  The option also includes a code ('c' or 'w') to specify if the filtered text should only contain whole words.

= 1.1 =
* Add code to honor the page comment settings.  (Thanks to unidentified person for providing the code fix.)
  Problem:  comments were not being allowed on page where the short-code was used.
  Solution:  save the page settings before fetching the posts and then restore settings before returning the page.

= 1.0 =
* Update to allow multiple categories to be entered

= 0.1 =
* Initial release. 

== Upgrade Notice ==

= 1.2.1 =
Added option to supress byline

