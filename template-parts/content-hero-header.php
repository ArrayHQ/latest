<?php
/**
 * The template displays the hero header
 *
 * @package Latest
 */
?>

<?php
	// Get the featured category
	$hero_category = get_theme_mod( 'latest_hero_header' );

	// If there is no featured category, don't return markup
	if ( is_home() && $hero_category && $hero_category != '0' ) {
		$hero_id = $hero_category;

		$hero_posts_args = array(
			'posts_per_page'      => 4,
			'ignore_sticky_posts' => true
		);

		if ( $hero_id && '-1' != $hero_id ) {
			$hero_posts_args['cat'] = absint( $hero_id );
		}

		$hero_posts = new WP_Query( $hero_posts_args );

		// Count the number of hero posts
		$hero_count = $hero_posts->found_posts;

		if ( $hero_posts -> have_posts() ) :

		$image_class = has_post_thumbnail() ? 'with-featured-image hero-post' : 'without-featured-image hero-post';
	?>
		<div class="hero-wrapper">

			<div class="hero-posts">
				<?php while( $hero_posts->have_posts() ) : $hero_posts->the_post(); ?>

					<article id="post-<?php the_ID(); ?>-carousel" <?php post_class( $image_class ); ?>>
						<?php
						// Get the hero post template (template-parts/content-hero-item.php)
						get_template_part( 'template-parts/content-hero-item' ); ?>
					</article><!-- .post -->

					<?php endwhile;
				?>
			</div><!-- .hero-posts -->

			<?php
			// If we have more than one post, load the carousel pager
			if ( $hero_count > 1 ) { ?>
			<div class="hero-pager-wrap clear">
				<div class="container">
					<div class="pager-navs"></div>
					<ul id="hero-pager">
						<?php while ( $hero_posts->have_posts() ) : $hero_posts->the_post(); ?>
							<li>
								<a>
									<?php if ( has_post_thumbnail() ) { ?>
										<div class="paging-thumb">
											<?php the_post_thumbnail( 'latest-hero-thumb' ); ?>
										</div>
									<?php } ?>

									<div class="paging-text">
										<div class="paging-date">
											<?php echo get_the_date(); ?>
										</div>

										<div class="entry-title">
											<span><?php the_title(); ?></span>
										</div>
									</div>
								</a>
							</li>
						<?php endwhile; ?>
					</ul><!-- .hero-pager -->
				</div><!-- .container -->
			</div><!-- .hero-posts -->
			<?php } ?>
		</div><!-- .hero-wrapper -->
		<?php
			endif;
			wp_reset_query();
		?>
<?php } ?>

<?php if ( is_customize_preview() && is_home() ) { ?>
	<div class="placeholder-section container" id="hero-header">
		<h2><?php esc_html_e( 'Setup Hero Header', 'latest' ); ?></h2>
		<p><?php esc_html_e( 'This is only visible while setting up your site in the Customizer.', 'latest' ); ?></p>
	</div>
<?php } ?>
