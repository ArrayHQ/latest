<?php
/**
 * The template displays the hero header
 *
 * @package Latest
 */
?>

<?php
	$featured_page_one   = get_theme_mod( 'latest_featured_page_one', 0 );
	$featured_page_two   = get_theme_mod( 'latest_featured_page_two', 0 );
	$featured_page_three = get_theme_mod( 'latest_featured_page_three', 0 );

	if ( is_home() ) {

	$featured_pages = array( $featured_page_one, $featured_page_two, $featured_page_three );
	if ( $featured_page_one || $featured_page_two || $featured_page_three ) {
	?>
		<div class="featured-page-wrapper featured-blog-wrapper clear">
			<div class="featured-pages container clear">
					<?php
						// Query the featured pages
						$featured_page_query = new WP_Query(
							array(
								'post_type' => 'page',
								'orderby'   => 'menu_order',
								'post__in'  => $featured_pages
							)
						);

						if ( $featured_page_query->have_posts() ) : while( $featured_page_query->have_posts() ) : $featured_page_query->the_post();
					?>

					<article <?php post_class( 'grid-thumb post' ); ?>>
						<?php if ( has_post_thumbnail() ) { ?>
							<a class="grid-thumb-image" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
								<!-- Grab the image -->
								<?php
									$post_layout = get_option( 'latest_layout_style' );
									if ( $post_layout == 'two-column-masonry' || $post_layout == 'three-column-masonry' ) {
										the_post_thumbnail( 'latest-grid-thumb-masonry' );
									} else {
										the_post_thumbnail( 'latest-grid-thumb' );
									}
								?>
							</a>
						<?php } ?>

						<!-- Post title and categories -->
						<div class="grid-text">
							<?php echo latest_list_cats( 'grid' ); ?>

							<h3 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>

							<?php
								$excerpt_length = latest_excerpt_featured_page();
								if ( $excerpt_length > 0 ) {
							?>
								<p><?php echo wp_trim_words( get_the_excerpt(), $excerpt_length, '...' ); ?></p>
							<?php } ?>

							<div class="grid-date">
								<?php the_author_posts_link(); ?> <span>/</span>
								<span class="date"><?php echo get_the_date(); ?></span>
							</div>
						</div><!-- .grid-text -->
					</article><!-- .post -->

					<?php endwhile; endif; ?>

			</div><!-- .featured-pages -->
		</div><!-- .featured-page-wrapper -->
		<?php } ?>
		<?php wp_reset_query(); ?>
<?php } ?>

<?php if ( is_customize_preview() && is_home() ) {
	if ( ! $featured_page_one && ! $featured_page_two && ! $featured_page_three ) {
	?>
	<div class="placeholder-section container" id="featured-pages">
		<h2><?php esc_html_e( 'Setup Featured Pages', 'latest' ); ?></h2>
		<p><?php esc_html_e( 'This is only visible while setting up your site in the Customizer.', 'latest' ); ?></p>
	</div>
<?php } } ?>
