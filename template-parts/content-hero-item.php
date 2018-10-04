<?php
/**
 * The template used for displaying hero posts in the header
 *
 * @package Latest
 */

 // Get the hero text alignment
 $hero_alignment = get_theme_mod( 'latest_hero_alignment', 'center' );
?>

	<div class="hero-container post-hero">
		<!-- Get the hero background image -->
		<?php
		$hero_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "latest-hero" );

		if ( ! empty( $hero_src ) && ! is_single() ) { ?>

			<div class="site-header-bg-wrap">
				<div class="site-header-bg background-effect" style="background-image: url(<?php echo esc_url( $hero_src[0] ); ?>);"></div>
			</div><!-- .site-header-bg-wrap -->

		<?php } ?>

		<div class="container <?php echo $hero_alignment; ?>">
			<?php echo latest_list_cats( 'hero' ); ?>

			<!-- Hero title -->
			<div class="post-title hero-title">
				<?php if ( is_single() ) { ?>
					<h1 class="entry-title"><span><?php the_title(); ?></span></h1>
				<?php } else { ?>
					<h2 class="entry-title"><span><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></span></h2>
				<?php } ?>

				<?php
				// Get the page excerpt as a section description
				$page_excerpt = get_the_excerpt( $post->ID );

				if ( $page_excerpt ) {
					echo '<div class="hero-excerpt"><p><span>' . $page_excerpt . '</span></p></div>';
				} ?>

				<div class="hero-date clear">
					<?php
						// Get the post author outside the loop
						global $post;
						$author_id = $post->post_author;
					?>
					<span class="author-icon"><i class="fa fa-align-left"></i></span>
					<!-- Create an author post link -->
					<a href="<?php echo get_author_posts_url( $author_id ); ?>">
						<?php echo esc_html( get_the_author_meta( 'display_name', $author_id ) ); ?>
					</a>
					<span class="hero-on-span"><?php esc_html_e( ' on ', 'latest' ); ?></span>
					<span class="hero-date-span"><?php echo get_the_date(); ?></span>
				</div><!-- .hero-date -->
			</div><!-- .hero-text -->
		</div><!-- .container -->
	</div><!-- .hero-container -->
