<?php
/**
 * The Sidebar containing the shop widget areas.
 *
 * @package Latest
 */
?>
<?php if ( ! is_active_sidebar( 'sidebar-shop' ) && ! is_product() ) { ?>
	<div id="secondary" class="widget-area">
		<?php do_action( 'latest_above_shop_sidebar' ); ?>

		<?php dynamic_sidebar( 'shop' ); ?>

		<?php do_action( 'latest_below_shop_sidebar' ); ?>
	</div><!-- #secondary .widget-area -->

<?php } ?>
