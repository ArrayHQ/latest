<?php
/**
 * The template used for displaying posts in a grid
 *
 * @package Latest
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'grid-thumb post' ); ?>>
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
				$excerpt_length = get_theme_mod( 'latest_multi_column_excerpt_length', '25' );
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
