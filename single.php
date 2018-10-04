<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Latest
 */

get_header();

$comment_style = get_option( 'latest_comment_style', 'click' );

if ( comments_open() ) {
	$comments_status = 'open';
} else {
	$comments_status = 'closed';
}
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php while ( have_posts() ) : the_post();

			// Move Jetpack share links below author box
			if ( function_exists( 'sharing_display' ) && ! function_exists( 'dsq_comment' ) ) {
				remove_filter( 'the_content', 'sharing_display', 19 );
				remove_filter( 'the_excerpt', 'sharing_display', 19 );
			}

			// Post content template
			get_template_part( 'template-parts/content' );

			if ( function_exists( 'sharing_display' ) ) { ?>
				<div class="share-icons <?php echo esc_attr( $comments_status ); ?>">
					<?php echo sharing_display(); ?>
				</div>
			<?php }

			// Author profile box
			latest_author_box();

			// Related Posts
			if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
				echo do_shortcode( '[jetpack-related-posts]' );
			} ?>

			<?php
				// Get the post navigations for single posts
				if ( is_single() ) {
					latest_post_navigation();
				}
			?>

			<?php
			// Comments template
			comments_template();

		endwhile; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_sidebar();

get_footer(); ?>
