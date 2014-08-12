<?php
/**
 * Template Name: CC Homepage
 * Description: Displays blog posts with pagination and featured image.
 *
 * @package    WordPress
 */
locate_template( array( 'header.php'), true );
?>

<div class="container" id="thecontent">

	<div class="row">
	<div class="col-md-12">
<?php while ( have_posts() ) : the_post(); ?>

	<h1><?php the_content(); ?></h1>
	</div>
	</div>


<div class="row">
<?php // reset the loop
endwhile;
wp_reset_query(); ?>

<?php // Blog post query
$cc_posts_count = 1;
$paged = max(1, get_query_var('page'));
//query_posts( array( 'post_type' => 'post', 'paged' => $paged, 'showposts' => 0, 'category__not_in' => array( 10 ) ) );

query_posts(
	array(
		'post_type' => 'post',
		'posts_per_page' => 15,
		'order' => 'ASC',
		'paged' => $paged,
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


if ( have_posts() ) : while ( have_posts() ) :
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
// Start a new row if there are 3 posts
if($cc_posts_count % 3 == 0){
    //echo '</div><div class="row">';
}
$cc_posts_count++;
endwhile;
endif;

?>
</div>

<?php cc_content_nav( 'nav-below' ); ?>

<?php locate_template( array( 'footer.php'), true ); ?>