<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package latest
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="entry-content">
				<p><?php esc_html_e( 'It looks like nothing was found at this location. Please use the search box or the sitemap to locate the content you were looking for.', 'latest' ); ?></p>

				<?php get_search_form(); ?>

				<div class="archive-box">
					<h4><?php esc_html_e( 'Sitemap', 'latest' ); ?></h4>
					<ul>
						<?php wp_list_pages('sort_column=menu_order&title_li='); ?>
					</ul>
				</div>
			</div><!-- .entry-content -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar();

get_footer(); ?>
