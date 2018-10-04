<?php
/**
 * The template displays the WooCommerce hero header
 *
 * @package Latest
 */

if( is_page_template( 'woocommerce/woo-shop-homepage.php' ) ) {

// Get the hero settings
$hero_alignment        = get_theme_mod( 'latest_woo_hero_alignment', false );
$hero_title            = get_theme_mod( 'latest_woo_hero_title', false );
$hero_text             = get_theme_mod( 'latest_woo_hero_text', false );
$hero_button_text      = get_theme_mod( 'latest_woo_hero_button_text', false );
$hero_button_url       = get_theme_mod( 'latest_woo_hero_button_url', false );
$hero_background_image = get_theme_mod( 'latest_woo_hero_image', false );

if ( $hero_alignment || $hero_title || $hero_text || $hero_button_text || $hero_button_url || $hero_background_image ) { ?>

	<div class="hero-wrapper hero-product-wrapper">
		<div class="hero-posts">
			<article>
				<div class="hero-container">
					<!-- Get the hero background image -->
					<?php if ( ! empty( $hero_background_image ) ) { ?>

						<div class="site-header-bg-wrap">
							<div class="site-header-bg background-effect"></div>
						</div><!-- .site-header-bg-wrap -->

					<?php } ?>

					<div class="container <?php echo $hero_alignment; ?>">
						<!-- Hero title -->
						<div class="post-title hero-title">
							<?php if( $hero_title ) { ?>
								<h2 class="entry-title"><span><a href="<?php if( $hero_button_url ) { echo esc_url( $hero_button_url ); } ?>" rel="bookmark"><?php echo esc_html( $hero_title ); ?></a></span></h2>
							<?php } ?>

							<?php if( $hero_text ) { ?>
								<div class="hero-excerpt"><p><span><?php echo $hero_text; ?></span></p></div>
							<?php } ?>

							<?php if( $hero_button_text ) { ?>
								<a class="button" href="<?php if( $hero_button_url ) { echo esc_url( $hero_button_url ); } ?>" title="<?php esc_attr( $hero_button_text ); ?>"><?php echo esc_html( $hero_button_text ); ?></a>
							<?php } ?>

						</div><!-- .hero-text -->
					</div><!-- .container -->
				</div><!-- .hero-container -->
			</article><!-- .post -->
		</div><!-- .hero-posts -->
	</div><!-- .hero-wrapper -->
<?php } } ?>

<?php if ( is_customize_preview() && is_page_template( 'woocommerce/woo-shop-homepage.php' ) ) { ?>
	<div class="placeholder-section container" id="woo-hero-header">
		<h2><?php esc_html_e( 'Setup Shop Hero Header', 'latest' ); ?></h2>
		<p><?php esc_html_e( 'This is only visible while setting up your site in the Customizer.', 'latest' ); ?></p>
	</div>
<?php } ?>
