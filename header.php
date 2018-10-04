<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Latest
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php $detect = new Mobile_Detect; ?>

<?php do_action( 'latest_before_header' ); ?>

<header id="masthead" class="site-header">

	<?php do_action( 'latest_top_header' ); ?>

	<?php
		// Load the top nav on desktop
		$headline_text = get_theme_mod( 'latest_headline_text' );
		if ( has_nav_menu( 'top-nav' ) || has_nav_menu( 'social' ) || $headline_text ) {
	 ?>
		<div class="top-bar clear">
			<div class="container">
				<?php if ( $headline_text ) { ?>
					<div class="headline-text"><?php echo wp_kses_post( $headline_text ); ?></div>
				<?php } else { // Show today's date as a fallback ?>
					<div class="headline-text"><?php echo date( get_option( 'date_format' ) ); ?></div>
				<?php } ?>

				<?php if ( has_nav_menu( 'social' ) ) { ?>
					<nav class="social-navigation">
						<?php wp_nav_menu( array(
							'theme_location' => 'social',
							'depth'          => 1,
							'fallback_cb'    => false
						) );?>
					</nav><!-- .social-navigation -->
				<?php } ?>

				<?php if ( has_nav_menu( 'top-nav' ) ) { ?>
					<nav class="top-navigation">
						<?php wp_nav_menu( array(
							'theme_location' => 'top-nav',
							'depth'          => 1,
							'fallback_cb'    => false
						) );?>
					</nav><!-- .social-navigation -->
				<?php } ?>
			</div><!-- .container -->
		</div><!-- .top-bar -->
	<?php } ?>

	<div class="mobile-bar">
		<div class="container">
			<div class="overlay-toggle drawer-toggle drawer-menu-toggle">
				<span class="toggle-visible">
					<i class="fa fa-bars"></i>
					<?php esc_html_e( 'Menu', 'latest' ); ?>
				</span>
				<span>
					<i class="fa fa-times"></i>
					<?php esc_html_e( 'Close', 'latest' ); ?>
				</span>
			</div><!-- .overlay-toggle-->
		</div><!-- .container -->

		<div class="mobile-drawer">
			<?php
				// Get the explore drawer (template-parts/content-menu-drawer.php)
				get_template_part( 'template-parts/content-menu-drawer' );
			?>
		</div><!-- .drawer-wrap -->
	</div><!-- .mobile-bar -->

	<?php if ( has_nav_menu( 'primary' ) ) {
		$menu_status = 'has_primary_menu';
	} else {
		$menu_status = 'no_primary_menu';
	} ?>

	<div class="site-identity clear <?php echo $menu_status ?>">
		<div class="container">
			<div class="header-search-container">
				<?php do_action( 'latest_header_search_area' ); ?>
			</div><!-- .big-search-container -->

			<!-- Site title and logo -->
			<?php latest_title_logo(); ?>
		</div><!-- .container -->

		<!-- Main navigation -->
		<nav id="site-navigation" class="main-navigation">
			<div class="container">
				<?php do_action( 'latest_before_primary_menu' ); ?>

				<?php wp_nav_menu( array(
					'theme_location' => 'primary'
				) );?>

				<?php do_action( 'latest_after_primary_menu' ); ?>
			</div><!-- .container -->
		</nav><!-- .main-navigation -->
	</div><!-- .site-identity-->

	<?php do_action( 'latest_bottom_header' ); ?>
</header><!-- .site-header -->

<?php do_action( 'latest_after_header' ); ?>

<?php
	// Get the standard hero header
	get_template_part( 'template-parts/content-hero-header' );
?>

<?php
	// Get the featured pages
	get_template_part( 'template-parts/content-featured-pages' );
?>

<?php
	// Get the standard fixed bar
	get_template_part( 'template-parts/content-fixed-bar' );
?>

<?php do_action( 'latest_before_page' ); ?>

<div id="page" class="hfeed site">
	<div id="content" class="site-content">
