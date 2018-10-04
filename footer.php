<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Latest
 */
?>

	</div><!-- #content -->
</div><!-- #page -->

<?php do_action( 'latest_after_page' ); ?>

<footer id="colophon" class="site-footer">
	<div class="container">

		<?php if ( is_active_sidebar( 'footer' ) ) : ?>
			<div class="footer-widgets">
				<?php do_action( 'latest_above_footer_widgets' );
				dynamic_sidebar( 'footer' );
				do_action( 'latest_below_footer_widgets' ); ?>
			</div>
		<?php endif; ?>

		<div class="footer-bottom">
			<?php if ( has_nav_menu( 'footer' ) ) { ?>
				<nav class="footer-navigation">
					<?php wp_nav_menu( array(
						'theme_location' => 'footer',
						'depth'          => 1,
						'fallback_cb'    => false
					) );?>
				</nav><!-- .footer-navigation -->
			<?php } ?>

			<div class="footer-tagline">
				<div class="site-info">
					<?php echo latest_filter_footer_text(); ?>
				</div>
			</div><!-- .footer-tagline -->
		</div><!-- .footer-bottom -->
	</div><!-- .container -->
</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>
