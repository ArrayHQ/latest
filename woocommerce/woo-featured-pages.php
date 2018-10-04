<?php
/**
 * The template displays the hero header
 *
 * @package Latest
 */

// Get the featured categories
$featured_cat_one   = get_theme_mod( 'latest_featured_woo_one', false );
$featured_cat_two   = get_theme_mod( 'latest_featured_woo_two', false );
$featured_cat_three = get_theme_mod( 'latest_featured_woo_three', false );

$featured_pages = array( $featured_cat_one, $featured_cat_two, $featured_cat_three );

if ( $featured_cat_one || $featured_cat_two || $featured_cat_three ) {

	if ( is_page_template( 'woocommerce/woo-shop-homepage.php' ) ) {
	?>
		<div class="featured-page-wrapper featured-product-wrapper clear">
			<div class="featured-pages container clear">
				<?php
					foreach ( $featured_pages as $featured_page ) {
						if( $featured_page ) {

						// Get the category info
						$featured_cats          = get_term_by( 'slug', $featured_page, 'product_cat' );
						$featured_category_link = get_term_link( $featured_cats->term_id, 'product_cat' );
						$featured_category_desc = $featured_cats->description;

						$thumbnail_id = get_woocommerce_term_meta( $featured_cats->term_id, 'thumbnail_id', true );
						$image        = wp_get_attachment_image_src( $thumbnail_id, 'latest-woo-thumb' )[0];

						if ( $image ) {
							$featured_image_class = 'has-post-thumbnail';
						} else {
							$featured_image_class = 'no-post-thumbnail';
						}

						//var_dump($featured_cats->description);
			   ?>

				<article <?php post_class( 'grid-thumb post ' . $featured_image_class ); ?>>
					<?php if ( $image ) { ?>
						<a class="grid-thumb-image" href="<?php echo esc_url( $featured_category_link ); ?>" title="<?php echo esc_attr( $featured_cats->name ); ?>">
							<!-- Grab the category image -->
							<?php echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $featured_cats->name ) . '" />'; ?>
						</a>
					<?php } ?>

					<!-- Category title and description -->
					<div class="grid-text">
						<h3 class="entry-title"><a href="<?php echo esc_url( $featured_category_link ); ?>" rel="bookmark"><?php echo esc_html( $featured_cats->name ); ?></a></h3>

						<?php if( $featured_category_desc ) { ?>
							<?php echo $featured_category_desc; ?>
						<?php } ?>
					</div><!-- .grid-text -->
				</article><!-- .post -->

			<?php } } ?>
			</div><!-- .featured-pages -->
		</div><!-- .featured-page-wrapper -->
		<?php wp_reset_query(); ?>
<?php } } ?>

<?php if ( is_customize_preview() && is_page_template( 'woocommerce/woo-shop-homepage.php' ) ) {
	if ( ! $featured_cat_one && ! $featured_cat_two && ! $featured_cat_three ) {
	?>
	<div class="placeholder-section container" id="woo-featured-pages">
		<h2><?php esc_html_e( 'Setup Featured Product Categories', 'latest' ); ?></h2>
		<p><?php esc_html_e( 'This is only visible while setting up your site in the Customizer.', 'latest' ); ?></p>
	</div>
<?php } } ?>
