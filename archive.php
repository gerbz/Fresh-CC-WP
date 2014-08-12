<?php
/**
 * The template for displaying Archive pages.
 *
 * @package WordPress
 * @subpackage CoinCrack
 */
locate_template( array( 'header.php'), true );

?>
<div class="container" id="thecontent">

    <?php if (have_posts()) :
    // Queue the first post.
    the_post(); ?>

	<div class="row">
	<div class="col-md-12">

                <header class="page-title">
                    <h1><?php
                        if (is_day()) {
                            printf(__('Daily: %s', 'bootstrapwp'), '<span>' . get_the_date() . '</span>');
                        } elseif (is_month()) {
                            printf(
                                __('Monthly: %s', 'bootstrapwp'),
                                '<span>' . get_the_date(_x('F Y', 'monthly archives date format', 'bootstrapwp')) . '</span>'
                            );
                        } elseif (is_year()) {
                            printf(
                                __('Yearly: %s', 'bootstrapwp'),
                                '<span>' . get_the_date(_x('Y', 'yearly archives date format', 'bootstrapwp')) . '</span>'
                            );
                        } elseif (is_tag()) {
                            printf(__('Tagged: %s', 'bootstrapwp'), '<span>' . single_tag_title('', false) . '</span>');
                            // Show an optional tag description
                            $cat_tag_description = tag_description();

                        } elseif (is_category()) {
                            printf(
                                __('%s Products', 'bootstrapwp'),
                                '<span>' . single_cat_title('', false) . '</span>'
                            );
                            // Show an optional category description
                            $cat_tag_description = category_description();

                        } else {
                            _e('Articles', 'bootstrapwp');
                        }
                        ?>
                   </h1>
                   <p class="category-archive-meta"><?php echo $cat_tag_description;?></p>

                </header>
     </div>

     </div>
<?php
// Rewind the loop back
    rewind_posts();
?>

<div class="row">

<?php
if ( have_posts() : while ( have_posts() ) : the_post();
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

</div>
<?php endif; ?>
<?php cc_content_nav( 'nav-below' ); ?>

<?php locate_template( array( 'footer.php'), true ); ?>
