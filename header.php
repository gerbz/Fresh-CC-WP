<?php
/**
 * Product Page Header
 *
 * @package    WordPress
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/ico/favicon.png" />
<?php
wp_head();
include('parts/google-analytics.php');
?>
</head>
<body <?php body_class(); ?>>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    	<div class="container">
			<div class="navbar-header">

				<a class="navbar-brand" style="padding:10px" href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
    			<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" width="140" alt="<?php bloginfo('name');?> Logo">
				</a>

				<div class="navbar-header" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
				    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"  onClick="jQuery('#support-modal').modal('show');">
				    	<span class="icon-bar"></span>
				    	<span class="icon-bar"></span>
				    	<span class="icon-bar"></span>
				    </button>
				</div>

    		<?php
    			wp_nav_menu(
    				array(
    					'menu'            => 'main-menu',
    					'container_class' => 'collapse navbar-collapse',
    					'menu_class'      => 'nav navbar-nav',
    					'fallback_cb'     => '',
    					'menu_id'         => 'main-menu',
    					'walker'          => new CC_Walker_Nav_Menu()
    				)
    			);
    		?>

			</div>
			<div class="collapse navbar-collapse">

				<form class="navbar-form navbar-left" id="search-form" role="search" method="get" action="/">
					<div class="input-group navbar-search">
						<input type="text" class="form-control" placeholder="<?php if(get_search_query() == ''){echo 'Search';}else{echo get_search_query();};?>" name="s">
						<span class="input-group-btn">
							<button class="btn btn-default" type="submit">
								<span class="glyphicon glyphicon-search"></span>
							</button>
						</span>
					</div>
				</form>

				<ul class="nav navbar-nav navbar-right">
					<li><button type="button" class="btn btn-default navbar-btn">Support</button></li>
				</ul>
			</div><!--navbar collapse-->
		</div><!--navbar container-->
	</div><!--navbar-->

