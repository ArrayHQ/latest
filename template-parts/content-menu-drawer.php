<?php
/**
 * This template adds the menu drawer
 *
 * @package Latest
 * @since Latest 1.0
 */

$detect = new Mobile_Detect;
$headline_text = get_theme_mod( 'latest_headline_text' );
?>

<div class="drawer drawer-menu-explore">
	<div class="container">
		<?php if ( $headline_text ) { ?>
			<div class="headline-text"><?php echo wp_kses_post( $headline_text ); ?></div>
		<?php } ?>

		<?php if ( class_exists( 'WooCommerce' ) ) { ?>
			<nav class="drawer-navigation drawer-cart-navigation">
				<?php do_action( 'latest_after_primary_menu' ); ?>
			</nav>
		<?php } ?>

		<?php
		// Load the top nav on mobile and tablet
		if ( has_nav_menu( 'top-nav' ) ) { ?>
			<nav class="top-navigation drawer-navigation">
				<?php wp_nav_menu( array(
					'theme_location' => 'top-nav',
					'depth'          => 1,
					'fallback_cb'    => false
				) );?>
			</nav><!-- .social-navigation -->
		<?php } ?>

		<nav id="drawer-navigation" class="drawer-navigation">
			<?php wp_nav_menu( array(
				'theme_location' => 'primary'
			) );?>
		</nav><!-- #site-navigation -->

		<?php get_search_form(); ?>

		<?php if ( has_nav_menu( 'social' ) ) { ?>
			<nav class="social-navigation">
				<?php wp_nav_menu( array(
					'theme_location' => 'social',
					'depth'          => 1,
					'fallback_cb'    => false
				) );?>
			</nav><!-- .footer-navigation -->
		<?php } ?>
	</div><!-- .container -->
</div><!-- .drawer -->
