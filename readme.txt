=== Series ===

Contributors: greenshady
Donate link: http://themehybrid.com/donate
Tags: widget, taxonomy, shortcode, posts, series
Requires at least: 3.6
Tested up to: 3.7
Stable tag: 0.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds a new taxonomy called "series" to your blog that allows you to link together several posts in a series.

== Description ==

Series is a plugin created to allow users to easily link posts together by using a WordPress taxonomy (like tags or categories) called "series".  It can be particularly useful if you write several posts spanning the same topic and want them tied together in some way that tags or categories doesn't cover.

### Professional Support

If you need professional plugin support from me, the plugin author, you can access the support forums at [Theme Hybrid](http://themehybrid.com/support), which is a professional WordPress help/support site where I handle support for all my plugins and themes for a community of 40,000+ users (and growing).

### Plugin Development

If you're a theme author, plugin author, or just a code hobbyist, you can follow the development of this plugin on it's [GitHub repository](https://github.com/justintadlock/series). 

### Donations

Yes, I do accept donations.  If you want to buy me a beer or whatever, you can do so from my [donations page](http://themehybrid.com/donate).  I appreciate all donations, no matter the size.  Further development of this plugin is not contingent on donations, but they are always a nice incentive.

== Installation ==

1. Unzip the `series.zip` folder.
2. Upload the `series` folder to your `/wp-content/plugins` directory.
3. In your WordPress dashboard, head over to the *Plugins* section.
4. Activate *Series*.

== Frequently Asked Questions ==

### Why was this plugin created?

Originally, it was a bit of a proof-of-concept of how plugins could create custom taxonomies based off a couple of highly-popular WordPress tutorials I wrote ([Custom taxonomies in WordPress 2.8](http://justintadlock.com/archives/2009/05/06/custom-taxonomies-in-wordpress-28) and [Using custom taxonomies to create a movie database](http://justintadlock.com/archives/2009/06/04/using-custom-taxonomies-to-create-a-movie-database)).

However, it was also a plugin I wanted for my personal blog.  I'd been using custom fields for years to handle series, but it was always kind of a crude method of doing so.  When WordPress created the Taxonomy API, I knew it was time to build something simple and usable for handling series on my site.

### What does this plugin do, exactly?

It creates a new taxonomy called "series" for use on your site.  It gives you template tags, shortcodes, and widgets to allow you to more easily tie posts together in a series.

Basically, you get a new meta box on the edit post screen titled "Series" that works just like regular tags.  You can input a series name to add a post to a series.  You also get a "Series" screen under the "Posts" menu in the WordPress admin.

### What widgets are available to use?

* **Series: List Posts** - This widget allows you to list posts from any series you've created.
* **Series: List Related** - This widget displays posts within the current post's series.  So, it only shows up under two conditions: 1) you're viewing a single post and 2) the current post is within a series.

### Are there other functions to use in my theme?

All standard WordPress functions for taxonomies work.  The name of the taxonomy is `series`.  So, if you want to do anything custom, WordPress already has the functions you need.  I'm not going to list them all here.  That'd be just like rewriting a large portion of the WordPress Codex, which is already available to you.

If you're looking for a specific template tag, start with the [category template tags](http://codex.wordpress.org/Template_Tags#Category_tags).  Most of them allow you to use custom taxonomies.

### Can you show me some examples?

Okay.  I'll show a few, but you've probably seen them before if you've done anything with tags or categories.

#### Displaying a "tag" cloud

	<?php wp_tag_cloud( array( 'taxonomy' => 'series' ) ); ?>

#### Displaying the current post's series

	<?php echo get_the_term_list( get_the_ID(), 'series', 'Series: ', ', ', '' ); ?>

#### Displaying a "category" list of series

	<ul>
		<?php wp_list_categories( array( 'taxonomy' => 'series', 'title_li' => false ) ); ?>
	</ul>

### Can I create custom templates for series?

Certainly.  You can create templates for series archives.  Just copy your theme's `archive.php` or `index.php` template.  Then, rename it to `taxonomy-series.php` and make custom modifications from there.

If you want a template for a specific series, name the template `taxonomy-series-exampleslug.php`.

### Can you add feature X?

I'll consider it.  Let me know what features you'd like to see added to the plugin.  Just keep in mind that I want this plugin to stay relatively lightweight.  Any features added should be useful for most of the plugin's users.

### This is way too complicated for me!

Please let me know how I could make things simpler for you in a future version of the plugin.

Also, keep in mind that there are other series plugins out there.  This particular plugin might not be the best fit for you.  However, I'm more than willing to listen to feedback on making things easier.

== Upgrade Notice ==

If upgrading from a version earlier than 0.2.0, be sure to check your widgets.  You may need to reset them.

== Screenshots ==

1. Series meta box on the edit post screen.
2. Widgets on the widgets admin screen.
3. Manage series admin screen.
4. Example widget output in theme.

== Changelog ==

### Version 0.2.0

* Completely overhauled the entire code base.

### Version 0.1

* Plugin launch.