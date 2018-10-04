<?php
/**
 * Template Name: Full Width
 * Template Post Type: post, page
 *
 * @package Latest
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php while ( have_posts() ) : the_post();

				// Page content template
				get_template_part( 'template-parts/content-page' );

				// Comments template
				comments_template();

			endwhile; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_footer(); ?>
