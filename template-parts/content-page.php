<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Latest
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
	<!-- Grab the featured image -->
	<?php if ( has_post_thumbnail() ) { ?>
		<div class="featured-image"><?php the_post_thumbnail( 'latest-full-width' ); ?></div>
	<?php } ?>

	<div class="entry-content">
		<div class="post-content">
			<?php the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'latest' ),
				'after'  => '</div>',
			) ); ?>
		</div><!-- .post-content -->
	</div><!-- .entry-content -->
</article><!-- #post-## -->
