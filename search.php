<?php
/**
 * Search Results Template
 *
 * @package WordPress
 */
locate_template( array( 'header.php'), true );

// Track the query using GA
// I think i dont need this because I implemented this: http://www.lunametrics.com/blog/2013/07/01/google-analytics-site-search-seo-friendly-urls/comment-page-1/#comment-1932332
/*
if (get_search_query() != '' && strpos(current_url_path(),'/page/') === false) {
	echo"
<script type=\"text/javascript\">
	jQuery(window).load(function(){
		cc_ga_event_tracking('','Search','".get_search_query()."','".current_url_path()."');
		console.log('Search = ".get_search_query()."');
	});
</script>
	";
}
*/
?>

<div class="container" id="thecontent">

    <div class="row">
        <div class="col-md-12">
            <?php if (function_exists('cc_breadcrumbs')) {
                cc_breadcrumbs();
            } ?>
        </div>
    </div><!--/.row -->

	<div class="row content">
        <div class="col-md-8">
            <?php if (have_posts()) : ?>
                 <header class="post-title">
                     <h2><?php printf( __('Search Results for: %s', 'cc'),'<span>' . get_search_query() . '</span>'); ?></h2>
                 </header>

    		  <?php while (have_posts()) : the_post(); ?>

			  <div class="col-md-4 col-sm-6 col-xs-12">
			  <div class="product">
			      	<a href="<?php my_permalink(); ?>" title="<?php the_title(); ?>">
			      		<?php the_post_thumbnail('full', array( 'class' => 'img-responsive')); ?>
			      	</a>

			      <a href="<?php my_permalink(); ?>" title="<?php the_title(); ?>">
			      	<h3><?php the_title(); ?></h3>
			      </a>
			  </div>
			  </div>

            <?php endwhile; ?>

            <?php else : ?>

			<script type="text/javascript">
				jQuery(window).load(function(){
					cc_ga_event_tracking('Errors','Empty Search Results','<?php echo get_search_query();?>');
				});
			</script>

				<header class="post-title">
				    <h1>Crap, we don't have that...</h1>
				</header>
				<p class="lead">
				    But maybe we can help you find it?  Drop us an email and we'll work our magic! Here's some other stuff in the mean time:
				</p>

<?php
// show popular stuff
global $post;

// First try posts with the same tags
query_posts(
	array(
		'tag__in'=> 15,
		'posts_per_page' => 3,
		'tax_query' => array(
			array(
  				'taxonomy' => 'post_format',
  				'field' => 'slug',
  				'terms' => array('post-format-aside','post-format-image','post-format-gallery','post-format-link','post-format-quote','post-format-status','post-format-video','post-format-audio','post-format-chat'),
  				'operator' => 'NOT IN'
			)
    	)
    )
);
if ( have_posts() ){
	while ( have_posts() ){
		the_post();
?>

			  <div class="col-md-4 col-sm-6 col-xs-12">
			  <div class="product">
			      	<a href="<?php my_permalink(); ?>" title="<?php the_title(); ?>">
			      		<?php the_post_thumbnail('full', array( 'class' => 'img-responsive')); ?>
			      	</a>

			      <a href="<?php my_permalink(); ?>" title="<?php the_title(); ?>">
			      	<h3><?php the_title(); ?></h3>
			      </a>
			  </div>
			  </div>

<?php
	}//end while
	wp_reset_query();
}
?>

             <?php endif;?>
        </div>
        <div class="col-md-4">
			<?php the_widget('WP_Widget_Recent_Posts'); ?>
			<h2>More Pages</h2>
			<?php wp_page_menu(); ?>
        </div>
	</div>

	<div class="row">
		<div class="col-md-8">
		<?php cc_content_nav('nav-below'); ?>
		</div>
	</div>


    <?php locate_template( array( 'footer.php'), true ); ?>