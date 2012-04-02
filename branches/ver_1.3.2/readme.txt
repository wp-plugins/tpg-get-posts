===  TPG Get Posts ===
Contributors: Criss Swaim
Donate link: http://www.tpginc.net/wordpress-plugins/donate/
Tags: get_posts, post, posts, formatting, list, shortcode
Requires at least: 2.8    
Tested up to: 3.3
Stable tag: 1.3.1

Adds a shortcode tag [tpg_get_posts] to display posts within any page or post.  

== Description ==

This plugin adds the ability to put a shortcode tag in a page or post and have it display a list of posts formatted similarly to the standard blog.  The posts can be selected by one or more tag values, suchs as tags, category, category_name or any other option supported by the WP get_posts function, to show only items relevant for the page.

By default it will show the 5 most recent posts ordered in reverse date order,
but it will accept any of the options provided by the [get_posts template tag]( href=http://codex.wordpress.org/Template_Tags/get_posts ).

To use it, just put the following into the HTML of any page or post, use as many times as you like on the same page:

	[tpg_get_posts]

	
This default usage will return the last 5 posts in reverse chronological order.  It will display the post similarly to a standard post, honoring the <!more> tag to produce a teaser.  Meta data showing post date, author, modified date, comments, categories and tags is also displayed.
	
See the usage section in 'Other Notes' for a list of parms and more examples of use.
	
== Usage ==

**WARNING**  If you copy/paste the commands, the function may not work. If this happens, type the entire command in to avoid introducing hidden characters.

To use it, just put the following into the HTML of any page or post, use as many times as you like on the same page:

	[tpg_get_posts]
	
	this is equivalent to:
	
	[tpg_get_posts show_meta="true" post_entire="false" fields="post_title, post_content" 
	fields_classes ="p_title_class, p_content_class" numberposts=5 ]
	
This default usage will return the last 5 posts in reverse chronological order.  It will display the post similarly to a standard post, honoring the <!more> tag to produce a teaser.  Meta data showing post date, author, modified date, comments, categories and tags is also displayed.

A common usage is to show post on a page that have a common tag or category:
	
		[tpg_get_posts tag="tag1, tag2,tag3"]
	or 
		[tpg_get_posts category_name="catname1, catname2, catname3"]

See Settings in plugin for full list of parameters

A couple of examples:

Shows 5 posts with the tag "tag1" or "tag2" ordered by title. Display the post title and content teaser.

	[tpg_get_posts tag="tag1,tag2" numberposts=5 orderby="title]

Shows 2 posts with the category name of "Events" or "News" ordered by title. Display the post title and the entire content.

	[tpg_get_posts category_name="Events,News" numberposts=2 orderby="title show_entire="true"]

Shows a bullet list of post titles. The title will be wrapped in a <span> tag with a class of "class1", the date with a <span> of class "p_ul_class".  The title will provide a link to the post. The title can be formatted with a css style .p_ul_class h2 {}.

	[tpg_get_posts tag="tag5" fields="post_title" ul_class="p_ul_class"]


== Installation ==

1. Upload the plugin to the `/wp-content/plugins/` directory and unzip it.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Place `[tpg_get_posts]` in your pages. 

== Frequently Asked Questions ==

= How to I format the output? =

Set the format in your css
 
* heading - .p_title_class
* byline - .p_byline
* content - .p_content_class
* metadata - .p_metadata_class

= Can this plugin select by category? =

Yes, multiple category_name(s) can be submitted.  The base WordPress function get_posts accepts only a single category, but multiple category ids.  So in the plugin, the category name is converted to the category id and the category_name parameter is blanked out and the post is requested by multiple ids.

= Can I combine categories and tags? =

Yes, but listing both category and tag as selection criteria forms 'and' logic not 'or' logic.  So if a post meets both selection criteria, then it is selected.  If it meets only a single selection, then it is ignored.  

== Screenshots ==

1. Page without plugin active.
2. Plugin setup on a page - selecting only posts assigned to the category home page and supressing by-line and meta data. 
3. The output from the shortcode.

== Changelog ==

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

