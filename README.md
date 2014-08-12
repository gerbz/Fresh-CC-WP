Fresh CC WP
=======================
Everything you need to get wordpress up and running with Bootstrap and other awesomeness

Installation
------------

1. Upload to /wp-content/themes/
2. Rename directory
3. Update theme name in style.css
4. Update screenshot.png
4. Activate theme in WP
5. Update constants name in /assets/php/constants.php
6. Update favicon /assets/ico/favicon.png
7. Update google analytics data in parts/google-analytics.php
8. Add cc_tw_button_count, cc_gp_button_count, cc_fb_button_count post meta fields
9. Update fonts in functions.php

WP Config
------------
1. Settings > Permalinks (make sure there's a .htaccess file)
2. Turn off admin bar in Users >Your Profile > Toolbar
3. Create Home page and set as home in Settings > Reading > Front page displays
4. Create Blog page and set as Posts page in in Settings > Reading > Front page displays
5. Create Search page with default template

Plugin Config
------------
1. Install and Activate "Gravity Forms"
	a. Modify settings: Support key, Output css: No, Output HTML5: Yes
 	b. Now you can include gravity form extras at the top 	of functions.php
 	c. Install any gravity forms addons 	
2. Install Redirection
 	a. http://urbangiraffe.com/plugins/redirection/
3. Install and Activate Wordpress SEO
 	a. https://yoast.com/wordpress/plugins/seo/
 	b. Titles & Metas: check noindex subpages of archives.  Clean up the head hide everything except rss.  In Other tab, disable the author archives if one author
 	c. XML Sitemap: Exclude tags and format
 	d. Permalinks: Don't remove stop words from slugs
 4. Install and activate affiliate wp
 	a. 
 	
 	
