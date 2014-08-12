<?php
/**
 * Template Name: CC Blog
 * Description: Displays blog posts with pagination and featured image.
 *
 * @package    WordPress
 */
locate_template( array( 'header.php'), true );

?>

<div class="container" id="thecontent">

	<div class="row">
		<div class="col-md-12">
		<ol class="breadcrumb">
			<li><a href="/">Home</a></li>
			<li>Blog</li>
		</ol>
		</div>
	</div>

	<div class="row content">
	<div class="col-md-8">

<?php

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
query_posts(
	array(
		'post_type' => 'post',
		'category__not_in' => '31',
		'paged' => $paged
	)
);

if ( have_posts() ) : while ( have_posts() ) : the_post();

?>

	<div <?php post_class(); ?>>
	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
		<h3><?php the_title(); ?></h3>
	</a>
	<p class="meta">
		<?php echo cc_posted_on(); ?>
	</p>

	<div class="row">
		<?php // Post thumbnail conditional display.
		if (cc_autoset_featured_img() !== false) : ?>
		<div class="col-md-3">
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute( 'echo=0' ); ?>">
				<?php echo cc_autoset_featured_img(); ?>
			</a>
		</div>
		<div class="col-md-9">
			<?php else : ?>
			<div class="col-md-12">
				<?php endif; ?>
				<?php the_excerpt(); ?>
			</div>
		</div>
		<!-- /.row -->

		<hr />
	</div><!-- /.post_class -->

<?php // end of blog post loop.

endwhile;
endif;

?>

<?php cc_content_nav( 'nav-below' );

	wp_reset_query();
?>

	</div>

<?php locate_template( array( 'sidebar.php'), true ); ?>
	</div>

<?php locate_template( array( 'footer.php'), true ); ?>