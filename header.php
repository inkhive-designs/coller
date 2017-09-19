<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package coller
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'coller' ); ?></a>
	<div id="jumbosearch">
		<span class="fa fa-remove closeicon"></span>
		<div class="form">
			<?php get_search_form(); ?>
		</div>
	</div>	
	
	
	<header id="masthead" class="site-header" role="banner">
	
		
			
		<div class="layer">
			<div class="container">
				<div class="site-branding">
					<?php if ( get_theme_mod('coller_logo') != "" ) : ?>
					<div id="site-logo">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_theme_mod('coller_logo'); ?>"></a>
					</div>
					<?php endif; ?>
					<div id="text-title-desc">
					<h1 class="site-title title-font"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<!-- UN-COMMENT THIS TO ENABLE DESCRIPTION
						<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2> 
					-->
					</div>
				</div>
				
				<div class="social-icons">
					<?php get_template_part('social', 'soshion'); ?>
				</div>
					
			</div>	
			
		</div>	
	</header><!-- #masthead -->
	
	<nav id="site-navigation" class="main-navigation front" role="navigation">
		<div class="container">
			<?php
				// Get the Appropriate Walker First.
				 if (has_nav_menu(  'primary' ) && !get_theme_mod('coller_disable_nav_desc',true) ) :
						$walker = new Coller_Menu_With_Description;
					else : 
						$walker = new Coller_Menu_With_Icon;
				  endif;
				  //Display the Menu.							
				  wp_nav_menu( array( 'theme_location' => 'primary', 'walker' => $walker ) ); ?>
		</div>		  
	</nav><!-- #site-navigation -->
	
	<?php get_template_part('slider', 'nivo' ); ?>
	
	<div class="mega-container">
		<?php get_template_part('featured', 'showcase' ); ?>
		<?php get_template_part('featured', 'posts' ); ?>
		<?php get_template_part('featured', 'content2'); ?>
		<?php get_template_part('featured', 'content1'); ?>
	
		<div id="content" class="site-content container">