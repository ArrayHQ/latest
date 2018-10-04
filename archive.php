<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Latest
 */

get_header();

$post_layout = get_option( 'latest_layout_style', 'one-column' );
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main blocks-page">
			<?php if ( have_posts() ) : ?>

				<div id="post-wrapper">
					<div class="grid-wrapper <?php echo $post_layout . '-wrapper'; ?>">
					<?php
						// Get the post content
						while ( have_posts() ) : the_post();

							if ( 'one-column' === $post_layout ) {
								get_template_part( 'template-parts/content' );
							} else {
								get_template_part( 'template-parts/content-grid-item' );
							}

						endwhile;
					?>
					</div><!-- .grid-wrapper -->

					<?php latest_page_navs(); ?>
				</div><!-- #post-wrapper -->

				<?php else :

				get_template_part( 'template-parts/content-none' );

			endif; ?>
		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
