<?php
/**
 * Description: Default Footer
 *
 * @package    WordPress
 */
?>

	</div> <!-- end container -->

<footer>
<div class="container">
    <p>&copy; <?php bloginfo( 'name' ); ?> <?php echo esc_attr( date( 'Y' ) ); ?> <?php if(!CC_PRODUCTION_MODE){echo '| '.$wpdb->num_queries.' queries ' .timer_stop(1).' seconds';} ?></p>

    <?php if ( function_exists( 'dynamic_sidebar' ) ) :
    	dynamic_sidebar( "footer-content" );
    endif; ?>
</div>
</footer>

<?php wp_footer(); ?>

<?php if(CC_PRODUCTION_MODE){?>
<script type="text/javascript">

// tweet button
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');

// g+ button js
(function() {
  var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
  po.src = 'https://apis.google.com/js/platform.js';
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();


</script>

<?php } //if Dev ?>

	</body>
</html>