<?php
/**
 * Template Name: CC Page Default
 * Description: Displays blog posts with pagination and featured image.
 *
 * @package    WordPress
 */
locate_template( array( 'header.php'), true );

?>
<div class="container" id="thecontent">

	<div class="row content">
		<div class="col-md-8">

			<h1><?php the_title(); ?></h1>

			<div class="entry-content" id="content">

				<?php the_content(); ?>

			</div>

		</div>

<?php locate_template( array( 'sidebar.php'), true ); ?>
	</div>

<?php locate_template( array( 'footer.php'), true ); ?>