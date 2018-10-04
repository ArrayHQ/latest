<?php
/**
 * WooCommerce related functions
 *
 * @package latest
 */

 /**
  * Customizer theme options
  */
 require get_template_directory() . '/woocommerce/woo-customizer.php';


 /**
 * Sets up WooCommerce menus
 */
 register_nav_menus( array(
 	'woo-category' => esc_html__( 'Featured Product Category Menu', 'latest' ),
 ) );


if ( ! function_exists( 'latest_woo_gallery' ) ) {
	function latest_woo_gallery() {
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}
	latest_woo_gallery();
}


/**
 * Enqueue scripts and styles
 */
function latest_woo_scripts() {
	/**
	 * Load Woo stylesheet
	 */
	wp_enqueue_style( 'latest-woocommerce-style', get_template_directory_uri() . "/woocommerce/woocommerce-style.css", array(), '1.0.0', 'screen' );

	/**
	 * Load Woo javascript
	 */
	wp_enqueue_script( 'latest-woocommerce-js', get_template_directory_uri() . '/woocommerce/js/latest-woo.js', array(), '1.0.0', true );

	/**
	 * Localize scripts
	 */
	wp_localize_script( 'latest-woocommerce-js', 'latest_woo_js_vars', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'latest_woo_scripts' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function latest_customize_woo_preview_js() {
	wp_enqueue_script( 'latest-woocommerce-customizer-js', get_template_directory_uri() . '/woocommerce/js/woo-customizer.js', array( 'customize-preview' ),  rand(1, 100), true );
}
add_action( 'customize_preview_init', 'latest_customize_woo_preview_js' );


/**
 * Register widget area
 */
function latest_woo_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'WooCommerce Shop Archive Sidebar', 'latest' ),
		'id'            => 'shop',
		'description'   => esc_html__( 'Widgets added here will appear on the sidebar of WooCommerce shop page.', 'latest' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

    register_sidebar( array(
		'name'          => esc_html__( 'WooCommerce Product Page Sidebar', 'latest' ),
		'id'            => 'product-page',
		'description'   => esc_html__( 'Widgets added here will appear on the sidebar of WooCommerce product pages.', 'latest' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'latest_woo_widgets_init' );


/**
 * Add a sidebar to the single product page
 */
function latest_single_product_sidebar () {
	if ( is_active_sidebar( 'product-page' ) ) {
		echo '<div id="secondary" class="widget-area">';
			do_action( 'latest_above_product_sidebar' );
			dynamic_sidebar( 'product-page' );
			do_action( 'latest_below_product_sidebar' );
		echo '</div>';
	}
}
add_action( 'woocommerce_after_single_product_summary', 'latest_single_product_sidebar', 10 );


/**
 * Add hero header to Woo shop page
 */
function latest_woo_hero_header () {
	get_template_part( 'woocommerce/woo-hero-header' );
	get_template_part( 'woocommerce/woo-featured-pages' );
}
add_action( 'latest_before_page', 'latest_woo_hero_header', 1 );


/**
 * Add layout style class to body
 */
function latest_woo_class( $classes ) {

	// Add a sidebar class
	$classes[] = ( is_active_sidebar( 'shop' ) ) ? 'has-shop-sidebar' : 'no-shop-sidebar';
	$classes[] = ( is_active_sidebar( 'product-page' ) ) ? 'has-product-sidebar' : 'no-product-sidebar';

	if ( has_nav_menu( 'woo-category' ) && is_shop() ) {
		$classes[] = 'has-shop-category-menu';
	}

	if ( is_page_template( 'woocommerce/woo-shop-homepage.php' ) ) {
		$classes[] = 'woocommerce';
	}

	return $classes;
}
add_filter( 'body_class', 'latest_woo_class' );


/**
 * Change the default product thumbnail
 */
function latest_product_thumbnail() {
	add_filter( 'woocommerce_placeholder_img_src', 'custom_woocommerce_placeholder_img_src' );

	function custom_woocommerce_placeholder_img_src( $src ) {
		$src = get_template_directory_uri() . '/images/product-thumb.jpg';
		return $src;
	}
}
add_action( 'init', 'latest_product_thumbnail' );


/**
 * Change the number of related products
 */
if ( ! function_exists( 'latest_woo_related_products_limit' ) ) {
	function latest_woo_related_products_limit() {
	  global $product;

		$args['posts_per_page'] = 3;
		return $args;
	}
}

if ( ! function_exists( 'latest_related_products_args' ) ) {
	function latest_related_products_args( $args ) {
		$args['posts_per_page'] = 3; // 4 related products
		//$args['columns'] = 1; // arranged in 1 column
		return $args;
	}
	add_filter( 'woocommerce_output_related_products_args', 'latest_related_products_args' );
}


/**
 * Change the number of upsells
 */
if ( ! function_exists( 'latest_woocommerce_output_upsells' ) ) {
	function latest_woocommerce_output_upsells() {
		woocommerce_upsell_display( 3,1 ); // Display 3 products in rows of 1
	}
}
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_single_product_summary', 'latest_woocommerce_output_upsells', 15 );


/**
 * Change the number of products per row
 */
if ( !function_exists( 'latest_loop_columns' ) ) {
	function latest_loop_columns() {
		$product_columns = get_theme_mod( 'latest_woo_columns', '4' );
		return $product_columns;
	}
}
add_filter( 'loop_shop_columns', 'latest_loop_columns' );


/**
 * Remove the first and last product class in favor of our own styles
 */
function prefix_post_class( $classes ) {
	if ( 'product' == get_post_type() ) {
		$classes = array_diff( $classes, array( 'first', 'last' ) );
	}
	return $classes;
}
add_filter( 'post_class', 'prefix_post_class', 21 );


/**
 * Change the number of products per page
 */
if ( !function_exists( 'latest_loop_shop_per_page' ) ) {
	function latest_loop_shop_per_page( $cols ) {
		$product_columns = get_theme_mod( 'latest_woo_columns', '4' );

		if ( $product_columns == '2' ) {
			$cols = 10;
		} elseif ( $product_columns == '3' ) {
			$cols = 9;
		} else {
			$cols = 12;
		}

		return $cols;
	}
	add_filter( 'loop_shop_per_page', 'latest_loop_shop_per_page', 20 );
}


/**
 * Fetches the posts for the mega menu posts
 */
function latest_menu_woo_category_query() {

	$term_html = '';
	$output    = '';
	$id        = ( ! empty( $_REQUEST['id' ] ) ) ? $_REQUEST['id'] : '';

	$taxonomy = 'product_cat';

	if ( ! empty( $id ) ) {
		$term = get_term( (int) $id, $taxonomy );
	}

	if ( ! empty( $term ) && ! is_wp_error( $term ) ) {

		$args = apply_filters( 'latest_mega_menu_query_args', array(
			'posts_per_page' => '4',
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'tax_query'      => array(
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'term_id',
					'terms'    => (int) $id
				)
			)
		) );

		$posts = new WP_Query( $args );

		if ( $posts->have_posts() ) {
			ob_start();
			while( $posts->have_posts() ) {
				$posts->the_post();
				wc_get_template_part( 'content', 'product' );
			}
			$output = ob_get_clean();

			// Get category title and link
			$term_html = sprintf( esc_html__( 'Category: %s', 'latest' ), $term->name ) . sprintf( wp_kses( __( '<a class="view-all" href="%s">View All</a>', 'latest' ), array( 'a' => array( 'href' => array(), 'class' => 'view-all' ) ) ), esc_url( get_term_link( $term->term_id, $taxonomy ) ) );
		} else {
			$term_html = esc_html__( 'No articles were found.', 'latest' );
		}
	}

	wp_send_json( array(
		'html'      => $output,
		'term_html' => $term_html
	) );

}
add_action( 'wp_ajax_latest_woo_category', 'latest_menu_woo_category_query' );
add_action( 'wp_ajax_nopriv_latest_woo_category', 'latest_menu_woo_category_query' );


/**
 * Output the featured category menu
 */
if ( !function_exists( 'latest_woo_category_menu' ) ) {
    function latest_woo_category_menu() { ?>
		<?php if( is_shop() && has_nav_menu( 'woo-category' ) ) { ?>
			<div id="product-browse" class="featured-posts-wrap clear">
				<div class="featured-posts clear container product-column-4">

					<nav id="woo-category-navigation" class="category-navigation woo-category-navigation" role="navigation">
						<?php
						if( is_shop() ) {

						wp_nav_menu( array(
							'theme_location' => 'woo-category'
						) ); } ?>
					</nav><!-- .category-navigation -->

					<ul class="products product-container"></ul>
				</div>
			</div>
		<?php }  // If mega menu enabled ?>
    <?php }
}
add_action( 'latest_below_category_menu', 'latest_woo_category_menu' );


/**
 * Add cart link to top nav
 */
if ( ! function_exists( 'latest_cart_menu_item' ) ) {
	function latest_cart_menu_item ( ) {
		if ( has_nav_menu( 'primary' ) ) { ?>
		    <ul class="nav-cart-wrap">
				<li class="nav-cart">
					<a class="cart-customlocation" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'latest' ); ?>">
					<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> <span class="count"><?php echo wp_kses_data( sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'latest' ), WC()->cart->get_cart_contents_count() ) );?></span>
					</a>
				</li>
			</ul>
		<?php }
	}
}
add_action( 'latest_after_primary_menu', 'latest_cart_menu_item', 10, 2 );


/**
 * Add cart link to top nav
 */
function latest_woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;

	ob_start();

	?>
	<a class="cart-customlocation" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'latest' ); ?>">
	<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> <span class="count"><?php echo wp_kses_data( sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'latest' ), WC()->cart->get_cart_contents_count() ) );?></span>
	</a>
	<?php

	$fragments['a.cart-customlocation'] = ob_get_clean();

	return $fragments;

}
add_filter( 'woocommerce_add_to_cart_fragments', 'latest_woocommerce_header_add_to_cart_fragment' );


/**
 * Add sharing icons to single product
 */
function latest_woocommerce_share_product() {
	// Load the sharing icons if enabled
	if ( function_exists( 'array_load_sharing_icons' ) ) {
		array_load_sharing_icons();
	}
}
add_filter( 'woocommerce_share', 'latest_woocommerce_share_product' );


/**
 * Rearrange ordering and results text
 */
if ( ! function_exists( 'latest_woocommerce_ordering' ) ) {
	function latest_woocommerce_ordering() {
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		add_action( 'woocommerce_archive_description', 'woocommerce_result_count', 30 );
	}
	//latest_woocommerce_ordering();
}


/**
 * Move the description to the header title
 */
if ( ! function_exists( 'latest_woocommerce_move_desc' ) ) {
	function latest_woocommerce_move_desc() {
		add_filter( 'woocommerce_show_page_title', '__return_false' );
		remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );
		remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
	}
	latest_woocommerce_move_desc();
}


/**
 * Add wrapper markup to product archive page
 */
if ( ! function_exists( 'latest_before_content' ) ) {
	/**
	 * Before Content
	 * Wraps all WooCommerce content in wrappers which match the theme markup
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	function latest_before_content() {
		$product_columns = get_theme_mod( 'latest_woo_columns', '3' );
		?>
		<div id="primary" class="content-area product-content-area">
			<main id="main" class="site-main" role="main">
				
		<?php
		echo '<div class="product-column-' . $product_columns . '">';
	}
}

if ( ! function_exists( 'latest_after_content' ) ) {
	/**
	 * After Content
	 * Closes the wrapping divs
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	function latest_after_content() {
		?>		</div><!-- .product-column -->
			</main><!-- #main -->
		</div><!-- #primary -->

		<?php do_action( 'woocommerce_sidebar' );
	}
}
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper',       10 );
remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end',   10 );
add_action( 'woocommerce_before_main_content',    'latest_before_content',                10 );
add_action( 'woocommerce_after_main_content',     'latest_after_content',                 10 );