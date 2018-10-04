<?php
/**
 * Latest functions and definitions
 *
 * @package Latest
 */


if ( ! function_exists( 'latest_setup' ) ) :
/**
 * Sets up Latest's defaults and registers support for various WordPress features
 */
function latest_setup() {

	/**
	 * Load Getting Started page and initialize theme update class
	 */
	require_once get_template_directory() . '/inc/admin/updater/theme-updater.php';

	/**
	 * TGM activation class
	 */
	require_once get_template_directory() . '/inc/admin/tgm/tgm-activation.php';

	/**
	 * Mobile Detect
	 */
	if ( ! class_exists( 'Mobile_Detect' ) ) {
		require_once( get_template_directory() . '/inc/mobile/Mobile_Detect.php' );
	}

	/**
	 * Add styles to post editor (editor-style.css)
	 */
	add_editor_style( array( 'editor-style.css', latest_fonts_url() ) );

	/*
	 * Make theme available for translation
	 */
	load_theme_textdomain( 'latest', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Post thumbnail support and image sizes
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * Add video metabox
	 */
	add_theme_support( 'array_themes_video_support' );

	/**
	 * Enable HTML 5 support for the search
	 */
	add_theme_support( 'html5', array( 'search-form', 'gallery' ) );

	/**
	 * Enable custom background
	 */
	$defaults = array(
		'default-color' => 'eeeeee',
	);
	add_theme_support( 'custom-background', $defaults );

	/**
	 * Include WooCommerce functions and styles
	 */
	add_theme_support( 'woocommerce' );

	if ( class_exists( 'WooCommerce' ) ) {
		require_once( get_template_directory() . '/woocommerce/woo-functions.php' );
	}

	/*
	 * Add title output
	 */
	add_theme_support( 'title-tag' );

	// Enable sharing icons from Array Toolkit
	add_theme_support( 'array_themes_social_link_support' );

	// Large post image
	add_image_size( 'latest-full-width', 2000 );

	// Grid thumbnail
	add_image_size( 'latest-grid-thumb', 600, 400, true );

	// Grid thumbnail
	add_image_size( 'latest-grid-thumb-masonry', 450 );

	// Grid thumbnail
	add_image_size( 'latest-woo-thumb', 600 );

	// Post navigation thumbnail
	add_image_size( 'latest-nav-thumb', 800, 280, true );

	// Mega menu thumbnail
	add_image_size( 'latest-mega-thumb', 235, 160, true );

	// Fixed nav thumbnail
	add_image_size( 'latest-fixed-thumb', 65, 65, true );

	// Hero image
	add_image_size( 'latest-hero', 1500 );

	// Single image
	add_image_size( 'latest-single', 1300 );

	// Hero pager thumb
	add_image_size( 'latest-hero-thumb', 50, 50, true );

	// Logo size
	add_image_size( 'latest-logo', 400 );

	/**
	 * Register Navigation menu
	 */
	register_nav_menus( array(
		'primary'   => esc_html__( 'Primary Menu', 'latest' ),
		'top-nav'   => esc_html__( 'Top Bar Menu', 'latest' ),
		'social'    => esc_html__( 'Social Icon Menu', 'latest' ),
		'category'  => esc_html__( 'Featured Category Menu', 'latest' ),
		'footer'    => esc_html__( 'Footer Menu', 'latest' ),
	) );

	/**
	 * Add Site Logo feature
	 */
	add_theme_support( 'custom-logo', array(
		'header-text' => array( 'titles-wrap' ),
		'flex-height' => true,
		'flex-width'  => true,
	) );

	/**
	 * Enable HTML5 markup
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'gallery',
	) );

	add_post_type_support( 'page', 'excerpt' );
}
endif; // latest_setup
add_action( 'after_setup_theme', 'latest_setup' );


/**
 * Set the content width based on the theme's design and stylesheet
 */
function latest_content_width() {
	global $content_width;
	if ( is_page_template( 'full-width.php' ) ) {
		$content_width = 1400;
	} else {
		$content_width = 980;
	}
}
add_filter( 'template_redirect', 'latest_content_width' );


/**
 * Register widget area
 */
function latest_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'latest' ),
		'id'            => 'sidebar',
		'description'   => esc_html__( 'Widgets added here will appear on the sidebar of posts and pages.', 'latest' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'latest' ),
		'id'            => 'footer',
		'description'   => esc_html__( 'Widgets added here will appear in the footer.', 'latest' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'latest_widgets_init' );


/**
 * Return the Google font stylesheet URL
 */
if ( ! function_exists( 'latest_fonts_url' ) ) :
function latest_fonts_url() {

	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by these fonts, translate this to 'off'. Do not translate
	 * into your own language.
	 */

	$nunito_sans = esc_html_x( 'on', 'Nunito font: on or off', 'latest' );
	$muli = esc_html_x( 'on', 'Muli font: on or off', 'latest' );

	if ( 'off' !== $nunito_sans || 'off' !== $muli ) {
		$font_families = array();

		if ( 'off' !== $nunito_sans )
			$font_families[] = 'Nunito Sans:200,300,400,400i,600';

		if ( 'off' !== $muli )
			$font_families[] = 'Muli:400,600,700';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}
endif;

/**
 * Enqueue scripts and styles
 */
function latest_scripts() {

	wp_enqueue_style( 'latest-style', get_stylesheet_uri() );

	/**
	* Load Open Sans and Lato from Google
	*/
	wp_enqueue_style( 'latest-fonts', latest_fonts_url(), array(), null );

	/**
	 * FontAwesome Icons stylesheet
	 */
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . "/inc/fontawesome/css/font-awesome.css", array(), '4.4.0', 'screen' );

	/**
	 * Load Latest's javascript
	 */
	wp_enqueue_script( 'latest-js', get_template_directory_uri() . '/js/latest.js', array( 'jquery' ), '1.0', true );

	/**
	 * Load Featured Category javascript
	 */
	if ( has_nav_menu( 'category' ) ) {
		wp_enqueue_script( 'latest-featured-cat-js', get_template_directory_uri() . '/js/featured-category.js', array( 'jquery' ), '1.0', true );
	}

	/**
	 * Load Masonry
	 */
	wp_enqueue_script( 'masonry' );

	/**
	 * Localizes the latest-js file
	 */
	wp_localize_script( 'latest-js', 'latest_js_vars', array(
		'ajaxurl'    => admin_url( 'admin-ajax.php' ),
	) );

	/**
	 * Load fitvids
	 */
	wp_enqueue_script( 'fitVids', get_template_directory_uri() . '/js/jquery.fitvids.js', array(), '1.6.6', true );

	/**
	 * Load responsiveSlides javascript
	 */
	 $featured_posts = get_theme_mod( 'latest_hero_header', 0 );
	 if ( $featured_posts ) {
		 wp_enqueue_script( 'responsive-slides', get_template_directory_uri() . '/js/responsiveslides.js', array(), '1.54', true );
		 wp_enqueue_script( 'latest-featured-posts', get_template_directory_uri() . '/js/featured-posts.js', array(), '1.0', true );
		 wp_enqueue_script( 'touchSwipe', get_template_directory_uri() . '/js/jquery.touchSwipe.js', array(), '1.6.6', true );
	 }

	/**
	 * Load hoverIntent
	 */
	wp_enqueue_script( 'hoverIntent', get_template_directory_uri() . '/js/jquery.hoverIntent.js', array(), '1.9.0', true );

	/**
	 * Load the comment reply script
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'latest_scripts' );


/**
 * Custom template tags for Latest
 */
require get_template_directory() . '/inc/template-tags.php';


/**
 * Customizer theme options
 */
require get_template_directory() . '/inc/customizer.php';


/**
 * Load Jetpack compatibility file
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Redirect to Getting Started page on theme activation
 */
function latest_redirect_on_activation() {
	global $pagenow;

	if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {

		wp_redirect( admin_url( "themes.php?page=latest-license" ) );

	}
}
add_action( 'admin_init', 'latest_redirect_on_activation' );


/**
 * Add button class to next/previous post links
 */
function latest_posts_link_attributes() {
	return 'class="button"';
}
add_filter( 'next_posts_link_attributes', 'latest_posts_link_attributes' );
add_filter( 'previous_posts_link_attributes', 'latest_posts_link_attributes' );


/**
 * Add layout style class to body
 */
function latest_layout_class( $classes ) {
	$layout_style        = get_option( 'latest_layout_style', 'one-column' );

	// Add a sidebar class
	if ( 'three-column' != get_option( 'latest_layout_style', 'one-column' ) || is_single() || is_page() ) {
		$classes[] = ( is_active_sidebar( 'sidebar' ) ) ? 'has-sidebar' : 'no-sidebar';
	}

	// Add a layout class
	if ( $layout_style ) {
		if ( $layout_style == 'one-column' ) {
			$classes[] = 'one-column';
		}

		if ( $layout_style == 'two-column' ) {
			$classes[] = 'two-column';
		}

		if ( $layout_style == 'two-column-masonry' ) {
			$classes[] = 'two-column masonry-column';
		}

		if ( $layout_style == 'three-column' ) {
			$classes[] = 'three-column';
		}

		if ( $layout_style == 'three-column-masonry' ) {
			$classes[] = 'three-column masonry-column';
		}
	}

	if ( is_customize_preview() ) {
	    $classes[] = 'in-customizer';
	} else {
		$classes[] = 'not-in-customizer';
	}

	if ( has_nav_menu( 'category' ) ) {
		$classes[] = 'has-category-menu';
	}

	if ( class_exists( 'WooCommerce' ) ) {
		$classes[] = 'woocommerce-active';
	}

	return $classes;
}
add_filter( 'body_class', 'latest_layout_class' );


/**
 * Adds a data-object-id attribute to nav links for category mega menu
 *
 * @return array $atts The HTML attributes applied to the menu item's <a> element
 */
function latest_nav_menu_link_attributes( $atts, $item, $args, $depth ) {
	$atts['data-object-id'] = $item->object_id;
	return $atts;
}


/**
 * Filters the current menu item to add another class.
 * Used to restore the active state when using the mega menu.
 */
function latest_nav_menu_css_class( $item, $args, $depth ) {
	if ( in_array( 'current-menu-item', $item ) ) {
		$item[] = 'current-menu-item-original';
	}
	return $item;
}


/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function latest_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'latest_page_menu_args' );


/**
 * Fetches the posts for the mega menu posts
 */
function latest_menu_category_query() {

	$term_html = '';
	$output    = '';
	$id        = ( ! empty( $_REQUEST['id' ] ) ) ? $_REQUEST['id'] : '';

	$taxonomy = 'category';

	if ( ! empty( $id ) ) {
		$term = get_term( (int) $id, $taxonomy );
	}

	if ( ! empty( $term ) && ! is_wp_error( $term ) ) {

		$args = apply_filters( 'latest_mega_menu_query_args', array(
			'posts_per_page' => '4',
			'post_type'      => 'post',
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
				include( 'template-parts/content-grid-category-item.php' );
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
add_action( 'wp_ajax_latest_category', 'latest_menu_category_query' );
add_action( 'wp_ajax_nopriv_latest_category', 'latest_menu_category_query' );


/**
 * Adds the menu item filters when the mega menu option is enabled
 */
function latest_mega_menu_check() {

	if ( has_nav_menu( 'category' ) || has_nav_menu( 'woo-category' ) ) {
		add_filter( 'nav_menu_css_class', 'latest_nav_menu_css_class', 10, 3 );
		add_filter( 'nav_menu_link_attributes', 'latest_nav_menu_link_attributes', 10, 4 );
	}
}
add_action( 'template_redirect', 'latest_mega_menu_check' );


if ( !function_exists( 'latest_featured_category_menu' ) ) {
function latest_featured_category_menu() { ?>

	<?php do_action( 'latest_above_category_menu' ); ?>

	<?php
	if ( has_nav_menu( 'category' ) ) {
		if( is_home() || is_singular( 'post' ) ) {
		global $post;
		?>
		<div id="post-browse" class="featured-posts-wrap clear">
			<div class="featured-posts clear container">
				<!-- Main navigation -->
				<nav id="category-navigation" class="category-navigation">
					<?php
					if( is_home() ) {

					wp_nav_menu( array(
						'theme_location' => 'category'
					) ); } else {

						// Build a related post category menu on post pages
						?>

						<ul id="menu-category" class="menu related-menu">
							<li class="more-in"><?php esc_html_e( 'Browse more in:', 'latest' ); ?></li>

							<?php
							$post_categories = wp_get_post_categories( $post->ID  );

							$category_base = get_option( 'category_base' );

							if ( '' == $category_base ) {
								$category_base = 'category';
							}

							foreach( $post_categories as $category ){
								$cat = get_category( $category );

								if ( $cat->slug != "cat" ) { ?>
								   <li id="cat-item-<?php echo esc_attr( $cat->slug ); ?>" class="cat-item cat-item-<?php echo esc_attr( $cat->slug ); ?>"><a href="<?php echo esc_url( home_url( '/' . $category_base . '/' . $cat->slug ) ); ?>" data-object-id="<?php echo esc_attr( $cat->term_id ); ?>"><?php echo esc_attr( $cat->name ); ?></a></li>
								<?php }
							}
							?>
						</ul>
					<?php } ?>
				</nav><!-- .category-navigation -->

				<div class="post-container clear"></div>
			</div>
		</div>
	<?php } } // If mega menu enabled ?>

	<?php do_action( 'latest_below_category_menu' ); ?>

<?php } }
add_action( 'latest_after_page', 'latest_featured_category_menu' );


/**
 * Auto generate excerpt on single column layout
 */
function latest_auto_excerpt( $content = false ) {

	global $post;
	$content = $post->post_excerpt;

	// If an excerpt is set in the Excerpt box
	if( $content ) {

		$content = apply_filters( 'the_excerpt', $content );

	} else {
		// No excerpt, get the first 55 words from post content
		$content = wpautop( wp_trim_words( $post->post_content, 55 ) );

	}

	// Read more link
	return $content . '<a class="more-link" href="' . get_permalink() . '">' . esc_html__( 'Read More', 'latest' ) . '</a>';

}

/**
 * Auto generate excerpt if option is selected
 */
function latest_excerpt_check() {
	// If is the home page, an archive, or search results
	if ( 'enabled' === get_theme_mod( 'latest_auto_excerpt', 'disabled' ) && ( is_home() || is_archive() || is_search() ) ) {
		add_filter( 'the_content', 'latest_auto_excerpt' );
	}
}
add_action( 'template_redirect', 'latest_excerpt_check' );


/**
 * Exclude featured posts from main loop
 */
 function latest_exclude_featured_posts( $query ) {

     if( ! ( $query->is_home() && $query->is_main_query() ) ) {
         return;
     }

     $hero_category = get_theme_mod( 'latest_hero_header' );
     $args          = array( 'posts_per_page' => 4, 'category' => $hero_category );
     $myposts       = get_posts( $args );
     $post_ids      = wp_list_pluck( $myposts, 'ID' );

     if ( 1 === get_theme_mod( 'latest_hero_header_exclude', 0 ) ) {
         $query->set( 'post__not_in', $post_ids );
     }

 }
 add_action( 'pre_get_posts', 'latest_exclude_featured_posts' );


/**
 * Add a js class
 */
function latest_html_js_class () {
    echo '<script>document.documentElement.className = document.documentElement.className.replace("no-js","js");</script>'. "\n";
}
add_action( 'wp_head', 'latest_html_js_class', 1 );


/**
 * Output main navigation for the sticky menu, if enabled
 */
if ( ! function_exists( 'latest_sticky_navigation' ) ) {
	function latest_sticky_navigation() { ?>
		<!-- Main navigation -->
		<nav class="main-navigation main-navigation-sticky">
			<div class="container">
				<?php do_action( 'latest_before_primary_menu' ); ?>

				<a href="#masthead" class="back-to-top" title="<?php esc_html__( 'Back to Top', 'latest' ) ?>"><i class="fa fa-angle-up"></i></a>

				<?php wp_nav_menu( array(
					'theme_location' => 'primary'
				) );?>

				<?php do_action( 'latest_after_primary_menu' ); ?>
			</div><!-- .container -->
		</nav><!-- .main-navigation -->
	<?php }

	if ( 'enabled' === get_theme_mod( 'latest_sticky_header', 'enabled' ) ) {
		add_action( 'latest_top_header', 'latest_sticky_navigation' );
	}
}


/**
 * Output sticky nav on single pages
 */
if ( ! function_exists( 'latest_sticky_bar_single' ) ) {
	function latest_sticky_bar_single() {
		if( is_single() ) {
			$detect = new Mobile_Detect; ?>

			<nav class="home-nav single-nav">
				<div class="container">
					<a href="#masthead" class="back-to-top" title="<?php esc_html__( 'Back to Top', 'latest' ) ?>"><i class="fa fa-angle-up"></i></a>

					<h2 class="sticky-title"><?php the_title(); ?></h2>

					<?php
						// Load the sharing icons if enabled
						if ( function_exists( 'array_load_sharing_icons' ) ) {
							if ( !$detect->isMobile() ) {
								array_load_sharing_icons();
							}
						}
					?>
				</div>
			</nav>
	<?php } }
}
add_action( 'latest_after_header', 'latest_sticky_bar_single' );


/**
 * Output search box into header
 */
if ( ! function_exists( 'latest_header_search' ) ) {
	function latest_header_search() {
		$header_search = get_theme_mod( 'latest_header_search', 'enabled' );

		if ( 'enabled' === $header_search ) {
			if ( class_exists( 'WooCommerce' ) ) {
				$header_search_option = get_theme_mod( 'latest_woo_header_search', 'product' );
				if ( $header_search_option == 'product' ) {
					get_product_search_form();
				} else {
					get_search_form();
				}
			} else {
				get_search_form();
			}
		}
	}
}
add_action( 'latest_header_search_area', 'latest_header_search' );


/**
 * Filter the excerpt length for featured page blocks
 */
if ( ! function_exists( 'latest_excerpt_featured_page' ) ) {
	function latest_excerpt_featured_page() {
		return '40';
	}
}


/**
 * Filter the excerpt length for posts in the featured category menu
 */
if ( ! function_exists( 'latest_excerpt_category_menu' ) ) {
	function latest_excerpt_category_menu() {
		return '25';
	}
}
