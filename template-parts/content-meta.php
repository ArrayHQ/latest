<?php
/**
 * The template part for displaying the post meta information
 *
 * @package Latest
 */

// Get the post tags
$post_tags = get_the_tags();
$download_tags = '';
$download_cats = '';
?>

	<?php if ( is_single() && ( ! empty( $post_tags ) ) ) { ?>
		<div class="entry-meta">
			<ul class="meta-list">

				<!-- Tags -->
				<?php if ( $post_tags ) { ?>

					<li class="meta-tag">
						<span><?php _e( 'Tagged in:', 'latest' ); ?></span>

						<?php
							// Get the standard post tags
							the_tags( '' );
						?>
					</li>

				<?php } ?>

			</ul><!-- .meta-list -->
		</div><!-- .entry-meta -->
	<?php } ?>
