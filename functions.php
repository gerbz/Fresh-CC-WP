<?php
/**
 * Theme Functions
 * @package WordPress
 */

/**
 * Include files.
 */

require get_template_directory() . '/assets/php/constants.php';
require get_template_directory() . '/includes/class-cc_walker_nav_menu.php';
//require get_template_directory() . '/includes/gravity-forms-extras.php';

/**
 * Setup Theme Functions
 *
 */
add_action( 'after_setup_theme', 'cc_theme_setup' );
function cc_theme_setup() {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'post-formats', array( 'aside', 'image', 'gallery', 'link') );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

	register_nav_menus(
		array(
			'main-menu' => __( 'Main Menu' ),
		) );

	set_post_thumbnail_size( 165, 165 );

}

/**
 * Set post thumbnail as first image from post, if not already defined.
 *
 */
function cc_autoset_featured_img() {
	global $post;

	$post_thumbnail = has_post_thumbnail();
	if ( $post_thumbnail == true ) {

		return get_the_post_thumbnail($post->ID);
		//return '<img src="'.wp_get_attachment_url(get_post_thumbnail_id($post->ID)).'">';
	}
	$image_args      = array(
		'post_type'      => 'attachment',
		'numberposts'    => 1,
		'post_mime_type' => 'image',
		'post_parent'    => $post->ID,
		'order'          => 'desc'
	);
	$attached_images = get_children( $image_args, ARRAY_A );
	$first_image     = reset( $attached_images );
	if ( ! $first_image ) {
		return false;
	}

	return get_the_post_thumbnail( $post->ID, $first_image['ID'] );

}

// Strip out the width and height of post thumbnails
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10, 3 );
function remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}

/**
 * Shortcodes
 *
 */

// http://css-tricks.com/snippets/wordpress/bloginfo-shortcode/
function cc_bloginfo_shortcode( $atts ) {
   extract(shortcode_atts(array(
       'key' => '',
   ), $atts));
   return get_bloginfo($key);
}
add_shortcode('bloginfo', 'cc_bloginfo_shortcode');

// Disable auto breaks in editor
//http://wp.smashingmagazine.com/2013/06/21/five-wordpress-functions-blogging-easier/
remove_filter ('the_content', 'wpautop');

/**
 * Load styles
 *
 */
add_action( 'wp_enqueue_scripts', 'cc_styles_loader' );
function cc_styles_loader() {
	wp_enqueue_style( 'bootstrap-css', '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css' );
	wp_enqueue_style( 'google-font', 'http://fonts.googleapis.com/css?family=PT+Sans:400,700|Asap:700' );
	if(CC_PRODUCTION_MODE){
		wp_enqueue_style( 'cc-css', get_template_directory_uri() . '/assets/css/main.min.css?v=0');
	}else{
		wp_enqueue_style( 'cc-css', get_template_directory_uri() . '/assets/css/main.css?v=0');
	}
}

/**
 * Load scripts
 *
 */
add_action( 'wp_enqueue_scripts', 'cc_scripts_loader' );
function cc_scripts_loader() {
	wp_enqueue_script( 'bootstrap-js', '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js', array( 'jquery' ), false, true );

	if(CC_PRODUCTION_MODE){
		wp_enqueue_script( 'cc-js', get_template_directory_uri() . '/assets/js/main.min.js', array( 'jquery' ), '0', true );
	}else{
		wp_enqueue_script( 'cc-js', get_template_directory_uri() . '/assets/js/main.js', array( 'jquery' ), '0', true );
	}
}

// Add ability to create custom templates for each post
// If its in the blog category return single.php
// http://wordpress.org/ideas/topic/template-files-for-single-post-id

//add_filter( 'single_template', 'cc_single_template_by_post_id' );
function cc_single_template_by_post_id( $located_template ) {

	foreach((get_the_category()) as $category) {
	    if($category->cat_ID != 10){
	    	return locate_template( array( sprintf( "single-%d.php", absint( get_the_ID() ) ), $located_template ) );
	    }else{
	    	return locate_template( "single.php" );
	    }
	}

}


/**
 * Define theme's widget areas.
 *
 */
add_action( 'init', 'cc_widgets_init' );
function cc_widgets_init() {

	register_sidebar(
		array(
			'name'          => __( 'Page Sidebar', 'cc' ),
			'id'            => 'sidebar-page',
			'before_widget' => '<div id="%1$s" class="panel panel-default %2$s">',
			'after_widget'  => "</div>",
			'before_title'  => '<div class="panel-heading"><h3 class="panel-title">',
			'after_title'   => '</h3></div>',
		)
	);
}

/**
 * Display page next/previous navigation links.
 *
 */
if ( ! function_exists( 'cc_content_nav' ) ) :
	function cc_content_nav( $nav_id = 'nav-below' ) {

		global $wp_query, $post;

		if ( $wp_query->max_num_pages > 1 ) : ?>

			<nav id="<?php echo $nav_id; ?>" class="navigation" role="navigation">
				<ul class="pager">
					<li class="previous">
						<?php previous_posts_link( '<span class="meta-nav">&larr;</span> Back' ); ?>
					</li>
					<li class="next">
						<?php next_posts_link( 'More <span class="meta-nav">&rarr;</span>' ); ?>
					</li>
				</ul>
			</nav>

		<?php elseif ( is_single() ) : ?>

			<nav id="<?php echo $nav_id; ?>" class="navigation" role="navigation">
				<ul class="pager">
					<li class="previous">
						<?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous', 'cc' ) ); ?>
					</li>
					<li class="next">
						<?php next_post_link( '%link', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next', 'cc' ) ); ?>
					</li>
				</ul>
			</nav>

		<?php endif;
	}
endif;

if ( ! function_exists( 'cc_post_nav' ) ) :
	function cc_post_nav() {
		global $post;

		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
		?>
		<nav class="navigation post-navigation" role="navigation">
			<ul class="pager">

				<?php previous_post_link( '%link', _x( '<li class="previous">&larr;</li> %title', 'Previous post link', 'cc' ) ); ?>
				<?php next_post_link( '%link', _x( '<li class="next">&rarr;</li> %title', 'Next post link', 'cc' ) ); ?>

			</ul>
		</nav>
	<?php
	}
endif;

/**
 * Display template for post meta information.
 *
 */
if ( ! function_exists( 'cc_posted_on' ) ) :
	function cc_posted_on() {
		printf( __( 'Posted on <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date date updated" datetime="%3$s">%4$s</time></a>', 'cc' ),
			esc_url( get_permalink()),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'cc' ), get_the_author() ) ),
			esc_html( get_the_author() )
		);
	}
endif;

/**
 * Add post ID attribute to image attachment pages prev/next navigation.
 *
 */
add_filter( 'attachment_link', 'cc_enhanced_image_navigation' );
function cc_enhanced_image_navigation( $url ) {
	global $post;
	if ( wp_attachment_is_image( $post->ID ) ) {
		$url = $url . '#main';
	}
	return $url;
}

/**
 * Display template for breadcrumbs.
 *
 */
function cc_breadcrumbs() {
	$home   = 'Home'; // text for the 'Home' link
	$before = '<li class="active">'; // tag before the current crumb
	$after  = '</li>'; // tag after the current crumb

	// return early for home.
	if ( is_home() && is_front_page() ) {
		return;
	}

	echo '<ol class="breadcrumb">';

	global $post, $wp_query;

	$homeLink = esc_url( home_url() );

	echo '<li><a href="' . $homeLink . '">' . $home . '</a></li> ';

	if ( is_category() ) {
		$cat_obj   = $wp_query->get_queried_object();
		$thisCat   = $cat_obj->term_id;
		$thisCat   = get_category( $thisCat );
		$parentCat = get_category( $thisCat->parent );
		if ( $thisCat->parent != 0 ) {
			echo get_category_parents( $parentCat, true );
		}
		echo $before . 'Posts / Category / ' . single_cat_title( '', false ) . $after;
	}
	elseif ( is_day() ) {
		echo '<li><a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time(
				'Y'
			) . '</a></li> ';
		echo '<li><a href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '">' . get_the_time(
				'F'
			) . '</a></li> ';
		echo $before . get_the_time( 'd' ) . $after;
	}
	elseif ( is_month() ) {
		echo '<li><a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time(
				'Y'
			) . '</a></li> ';
		echo $before . get_the_time( 'F' ) . $after;
	}
	elseif ( is_year() ) {
		echo $before . get_the_time( 'Y' ) . $after;
	}
	elseif ( is_single() && ! is_attachment() ) {
		if ( get_post_type() != 'post' ) {
			$post_type = get_post_type_object( get_post_type() );
			$slug      = $post_type->rewrite;
			echo '<li><a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a></li> ';
			echo $before . get_the_title() . $after;
		}
		else {
			$cat = get_the_category();
			$cat = $cat[0];
			echo '<li>' . get_category_parents( $cat, true, '' ) . '</li>';
			echo $before . get_the_title() . $after;
		}
	}
	elseif ( ! is_single() && ! is_page() && ! is_search() && get_post_type() != 'post' && ! is_404() ) {
		$post_type = get_post_type_object( get_post_type() );
		echo $before . $post_type->labels->singular_name . $after,'';
	}
	elseif ( is_attachment() ) {
		$parent = get_post( $post->post_parent );
		$cat    = get_the_category( $parent->ID );
		$cat    = $cat[0];
		echo get_category_parents( $cat, true, '' );
		echo '<li><a href="' . get_permalink(
				$parent
			) . '">' . $parent->post_title . '</a></li> ';
		echo $before . get_the_title() . $after;

	}
	elseif ( is_page() && ! $post->post_parent ) {
		echo $before . get_the_title() . $after;
	}
	elseif ( is_page() && $post->post_parent ) {
		$parent_id   = $post->post_parent;
		$breadcrumbs = array();
		while ( $parent_id ) {
			$page          = get_page( $parent_id );
			$breadcrumbs[] = '<li><a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a></li>';
			$parent_id     = $page->post_parent;
		}
		$breadcrumbs = array_reverse( $breadcrumbs );
		foreach ( $breadcrumbs as $crumb ) {
			echo $crumb;
		}
		echo $before . get_the_title() . $after;
	}
	elseif ( is_search() ) {
		echo '<li>Search</li>'. $before .'<a href="'.current_url_path().'">'. get_search_query() .'</a>'. $after;
	}
	elseif ( is_tag() ) {
		echo $before . '<li>Posts</li><li>Tag</li>' . single_tag_title( '', false ) . $after;
	}
	elseif ( is_author() ) {
		global $author;
		$userdata = get_userdata( $author );
		echo $before . '<li>Posts</li><li>Author</li>' . $userdata->display_name . $after;
	}
	elseif ( is_404() ) {
		echo $before . 'Error =(' . $after;
	}

	echo '</ol>';
}


/**
 * My stuff
 *
 */

// Pretty search! /search/query+term/
function search_url_rewrite_rule() {
        if ( is_search() && !empty($_GET['s'])) {
                wp_redirect(home_url("/search/") . urlencode(get_query_var('s')) . '/');
                exit();
        }
}
add_action('template_redirect', 'search_url_rewrite_rule');

// Remove the stupid inline .recentcomments style
function twentyten_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'twentyten_remove_recent_comments_style' );

// Modify og:type on the yoast SEO plugin
function yoast_change_opengraph_type( $type ) {
	if(is_page()){
		return 'website';
	}else{
    	return 'article';
	}
}
add_filter( 'wpseo_opengraph_type', 'yoast_change_opengraph_type', 10, 1 );

// Path after domain
function current_url_path(){
	$path = explode("?",$_SERVER['REQUEST_URI']);
	return $path[0];
}

// Use this inside the loop to get the permalink without the domain name
function my_permalink() {
	echo substr(get_permalink(), strlen(get_option('home')));
}

/**
 * Check whether something is in the get or cookie and return the value
 *
 */

function get_and_cookie($i){
	if($_GET[$i] != ''){
		$a = $_GET[$i];
	}else{
		$a = $_COOKIE[$i];
	}
	return $a;
}

/**
 * Set a referrer
 * called when a discount is checked to set the source (so cookies will write)
 * also called to set the referrer in the payment modal
 */

function cc_set_source(){

	// If its already set in a a cookie, use that
	if($_COOKIE['og_source'] != ''){
		return $_COOKIE['og_source'];
	}else{

		// If its a campaign, use those parms
		if($_GET['utm_campaign'] != ''){
			$parms = 'Campaign: '.$_GET['utm_campaign'].' | Source:'.$_GET['utm_name'].' | Medium:'.$_GET['utm_medium'].' | Content:'.$_GET['utm_content'];
			setcookie('og_source', $parms, time()+60*60*24,'/', '.'.CC_DOMAIN); // 1 day
			return $parms;
		}else{
			// If its not a campaign

			// Check the referring domain
			$url = parse_url($_SERVER['HTTP_REFERER']);

			// If theres a host, set it
			// Otherwise, its a direct hit
			if($url['host'] != '' && $url['host'] != CC_DOMAIN){
				setcookie('og_source', $url['host'], time()+60*60*24,'/', '.'.CC_DOMAIN); // 1 day
				return $url['host'];
			}else{
				setcookie('og_source', '(direct)', time()+60*60*24,'/', '.'.CC_DOMAIN); // 1 day
				return '(direct)';
			}
		}
	}
}