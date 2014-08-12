<?php
/**
 * Template Name: CC Single Blog Post
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
			<li><a href="/blog/" title="<?php bloginfo('name');?> Blog">Blog</a></li>
			<li class="active"><?php the_title(); ?></li>
		</ol>
		</div>
	</div><!--/.row -->

	<div class="row content">
	<div class="col-md-8">

<?php
//query_posts();
if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<div <?php post_class(); ?>>
	<h1 class="entry-title"><?php the_title(); ?></h1>


	<blockquote>
	<?php include('parts/share-buttons.php');?>
	</blockquote>

		<?php the_content(); ?>

	<hr />
</div>

<?php // end of blog post loop.
endwhile;
endif;
?>


<?php cc_content_nav( 'nav-below' ); ?>
	</div>

<?php include('sidebar.php'); ?>
	</div>

<?php locate_template( array( 'footer.php'), true ); ?>