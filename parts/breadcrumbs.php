<?php
/**
 * Description: The partial for displaying a template's breadcrumbs.
 *
 * @package    WordPress
 */
if ( function_exists( 'cc_breadcrumbs' ) && ! is_home() || ! is_front_page() ) : ?>

	<div class="row">
		<div class="col-md-12">
			<?php cc_breadcrumbs(); ?>
		</div>
	</div>

<?php endif; // end breadcrumbs ?>