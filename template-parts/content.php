<?php
/**
 * @package Latest
 */

// Check the featured image orientation
$img_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );

if ( $img_url ) {
	list( $width, $height ) = getimagesize( $img_url );
	if ( $width > $height ) {
		// Landscape
		$image_style = ' landscape-image';
	} else {
		// Portrait or Square
		$image_style = ' portrait-image';
	}
} else {
	$image_style = ' standard-image';
}

if ( get_post_meta( $post->ID, 'array-video', true ) ) {
	$has_video = ' has-video';
} else {
	$has_video = ' no-video';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post full-post' . $image_style . $has_video ); ?>>

	<div class="entry-content">
		<!-- Grab the video -->
		<?php if ( get_post_meta( $post->ID, 'array-video', true ) ) { ?>
			<div class="featured-video">
				<?php echo get_post_meta( $post->ID, 'array-video', true ) ?>
			</div>
		<?php } else if ( has_post_thumbnail() ) { ?>
			<div class="featured-image">
				<?php the_post_thumbnail( 'latest-single' );
				if ( $image_style == ' portrait-image' ) {
					echo "<i class='fa fa-expand'></i>";
				}
				?>
			</div>
		<?php } ?>

		<header class="entry-header">
			<?php if ( has_category() ) { ?>
				<div class="entry-cats">
					<?php
						// Limit the number of categories output on the grid to 5 to prevent overflow
						$i = 0;
						foreach( ( get_the_category() ) as $cat ) {
							echo '<a href="' . esc_url( get_category_link( $cat->cat_ID ) ) . '">' . esc_html( $cat->cat_name ) . '</a>';
							if ( ++$i == 5 ) {
								break;
							}
						}
					?>
				</div>
			<?php }

			if ( is_single() ) { ?>
				<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php } else { ?>
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<?php } ?>

			<div class="byline">
				<span class="author-icon"><i class="fa fa-align-left"></i></span>
				<?php the_author_posts_link();

				esc_html_e( ' on ', 'latest' );

				echo get_the_date(); ?>
			</div><!-- .byline -->
		</header><!-- .entry-header -->

		<div class="post-content">
			<?php
				// Get the excerpt style for the blog index
				$excerpt_style  = get_theme_mod( 'latest_one_column_excerpt' );
				$excerpt_length = get_theme_mod( 'latest_one_column_excerpt_length', '40' );

				if ( 'show-full' === $excerpt_style || is_single() ) {
					// Show the full content by default
					the_content( esc_html__( 'Read More', 'latest' ) );
				} else {
					// Show the excerpt and a read more link if selected in the Customizer
					echo wp_trim_words( get_the_excerpt(), $excerpt_length, '...' );
					echo '<a class="more-link" href="'. get_permalink( $post->ID ) . '">' . esc_html__( 'Read More', 'latest' ) . '</a>';
				}

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'latest' ),
					'after'  => '</div>',
				) );

				get_template_part( 'template-parts/content-meta' );

				// Load the share icons on mobile
				if ( function_exists( 'array_load_sharing_icons' ) ) {
					$detect = new Mobile_Detect;

					if ( $detect->isMobile() || $detect->isTablet() ) {
						array_load_sharing_icons();
					}
				}
			?>
		</div><!-- .post-content -->
	</div><!-- .entry-content -->

</article><!-- #post-## -->
