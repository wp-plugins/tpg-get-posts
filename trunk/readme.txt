===  TPG Get Posts ===
Contributors: Criss Swaim, based on plugin nurelm-get-posts
Donate link: http://tpginc.net/
Tags: get_posts, post, posts, formatting, list, shortcode
Requires at least: 2.?    (only tested on 2.9.2)
Tested up to: 2.9.2
Stable tag: 0.1

Adds a shortcode tag [tpg_get_posts] to display posts within any static page or post.  Posts can be selected by tags.

== Description ==

This plugin adds the ability to put a shortcode tag in a page or post and have it display a list of posts formatted similarly to the standard blog.  The posts can be selected by one or more tag values to show only items relevant to the page.

By default it will show the 5 most recent posts ordered in reverse date order,
but it will accept any of the options provided by the [get_posts template tag](<a href="http://codex.wordpress.org/Template_Tags/get_posts" target=_new>http://codex.wordpress.org/Template_Tags/get_posts</a>).

**WARNING**  If you copy/paste the commands, the function may not work. If this happens, type the entire command in to avoid introducing hidden characters.

To use it, just put the following into the HTML of any page or post, use as many times as you like on the same page:

	[tpg_get_posts]
	
	this is equivalent to:
	
	[tpg_get_posts show_meta="true" post_entire="false" fields="post_title, post_content" 
	fields_classes ="p_title_class, p_content_class" numberposts=5 ]
	
This default usage will return the last 5 posts in reverse chronological order.  It will display the post similarly to a standard post, honoring the <!more> tag to produce a teaser.  Meta data showing post date, 
author, modified date, comments, categories and tags is also displayed.

A common usage is to show post on a page that have a common tag:
	
	[tpg_get_posts tag="tag1, tag2,tag3"]

Along with all the options provided by the get_posts template tag, 
it will also accept a few additional options:

* tag. This allows for the selection of posts by tag.

* show_entire. This option show_entire="true" will show the entire post, not just the teaser. Default is "false"

* show_meta. This option show_meta="false" will suppress the display of metadata.  Default is "true".

* ul_class. This is the class assigned to the bullet list.  When this class is provided, the output is returned as an unordered list.

* fields. This is a comma separated list of fields to show, taken right from the [wp_posts database table fields](http://codex.wordpress.org/Database_Description/2.7#Table:_wp_posts). The default is "post_title, post_content".

* fields_classes.  Another comma separated list that lets you assign a class to each of the fields specified above, which will be provided via a <span> tag wrapped around the field.  The default value for this list is "post_title_class".  The default classes are p_title_class, p_content_class.  The metadata has a class
of p_metadata_class.


A couple of examples:

	[tpg-get_posts tag="tag1,tag2" numberposts=5 orderby="title]

Shows 5 posts with the tag "tag1" or "tag2" ordered by title. Display the post title and content teaser.

	[get_posts tag="tag5" fields="post_title" ul_class="p_ul_class"]

Shows a bullet list of post titles. The title will be wrapped in a <span> tag with a class of "class1", the date with a <span> of class "p_ul_class".  The title will provide a link to the post. The title can be formatted with a css style .p_ul_class h2 {}.

Check the [get_posts template tag](http://codex.wordpress.org/Template_Tags/get_posts) documentation for all of the possible options associated with the tag, and the [wp_posts database table fields](http://codex.wordpress.org/Database_Description/2.7#Table:_wp_posts) for all possible field names.

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

working on it.....

== Screenshots ==

1. This screen shot of a page using the plugin shows how the output is formatted by default. 

== Changelog ==

= 0.1 =
* Initial release. 

== Upgrade Notice ==


