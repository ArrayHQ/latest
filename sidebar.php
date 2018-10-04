<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Latest
 */

// Get layout style
$homepage_layout = get_option( 'latest_layout_style', 'one-column' );

// Get the sidebar widgets
if ( is_active_sidebar( 'sidebar' ) ) {
	if ( $homepage_layout === 'one-column' || $homepage_layout === 'two-column' || $homepage_layout === 'two-column-masonry' || is_single() || is_page() ) {
	?>
	<div id="secondary" class="widget-area">
		<?php do_action( 'latest_above_sidebar' );

		dynamic_sidebar( 'sidebar' ); ?>

		<?php do_action( 'latest_below_sidebar' ); ?>
	</div><!-- #secondary .widget-area -->
<?php } } ?>
