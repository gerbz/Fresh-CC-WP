<?php
/**
 * The template for displaying Author Archive pages.
 *
 * @package WordPress
 */
locate_template( array( 'header.php'), true );
?>
<div class="container" id="thecontent">

<?php if (have_posts()) :
    // Queue the first post.
    the_post(); ?>

		<div class="row">
            <div class="col-md-12">
                <?php if (function_exists('cc_breadcrumbs')) {
                cc_breadcrumbs();
            } ?>
            </div>
        </div><!--/.row -->

		<div class="row content">
			<div class="col-md-8">
                <header class="subhead" id="overview">
                    <h1 class="page-title author"><?php printf(
                        __('Author Archives: %s', 'cc'),
                        '<span class="vcard"><a class="url fn n" href="' . get_author_posts_url(
                            get_the_author_meta("ID")
                        ) . '" title="' . esc_attr(get_the_author()) . '" rel="me">' . get_the_author() . '</a></span>'
                    ); ?></h1>
                </header>
                <?php
                // Rewind the loop back
                    rewind_posts();
                ?>

                <?php while (have_posts()) : the_post(); ?>
                    <div <?php post_class(); ?>>
                        <a href="<?php the_permalink(); ?>" title="<?php the_title();?>"><h3><?php the_title();?></h3></a>

                        <p class="meta"><?php echo cc_posted_on();?></p>

                        <div class="row">
                            <?php // Post thumbnail conditional display.
                            if ( cc_autoset_featured_img() !== false ) : ?>
                                <div class="col-md-2">
                                    <a href="<?php the_permalink(); ?>" title="<?php  the_title_attribute( 'echo=0' ); ?>">
                                        <?php echo cc_autoset_featured_img(); ?>
                                    </a>
                                </div>
                                <div class="col-md-6">
                            <?php else : ?>
                                <div class="col-md-8">
                            <?php endif; ?>
                                    <?php the_excerpt(); ?>
                                </div>
                        </div><!-- /.row -->

                        <hr/>
                    </div><!-- /.post_class -->
                   <?php endwhile; ?>

                   <?php cc_content_nav('nav-below');?>

               <?php endif; ?>
			  </div>

    <?php get_sidebar(''); ?>

    	</div>
    <?php locate_template( array( 'footer.php'), true ); ?>