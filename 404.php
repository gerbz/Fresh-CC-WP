<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 */
locate_template( array( 'header.php'), true );


echo"
<script type=\"text/javascript\">
	jQuery(window).load(function(){
		cc_ga_event_tracking('Errors','404','".current_url_path()."');
	});
</script>
	";

?>
<div class="container" id="thecontent">

    <div class="row">
        <div class="col-md-12">
            <?php if (function_exists('cc_breadcrumbs')) {
            cc_breadcrumbs();
        } ?>
        </div>
    </div>

   <div class="row content">
       <div class="col-md-8">

            <header class="page-title">
                <h1>This is Embarrassing</h1>
            </header>

            <p class="lead"><?php _e(
                'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching, or one of the links below, can help.',
                'coincrack'
            ); ?></p>

           <div class="row">
               <div class="col-md-4">
                   <h2>All Pages</h2>
                   <?php wp_page_menu(); ?>
               </div>
               <!--/.col-md-4 -->
               <div class="col-md-4">
                   <?php the_widget('WP_Widget_Recent_Posts'); ?>

               </div>
               <!--/.col-md-4 -->
           </div>
           <!--/.row -->
       </div>

	   <?php locate_template( array( 'sidebar.php'), true ); ?>

    </div>


<?php locate_template( array( 'footer.php'), true ); ?>
