<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Latest
 */


/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function latest_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container'      => 'post-wrapper',
		'footer'         => 'page',
		'footer_widgets' => array( 'footer' ),
		'render'         => 'latest_render_infinite_posts',
		'wrapper'        => 'new-infinite-posts',
	) );
}
add_action( 'after_setup_theme', 'latest_jetpack_setup' );


/* Render infinite posts by using template parts */
function latest_render_infinite_posts() {
	while ( have_posts() ) {
		the_post();

		if ( 'one-column' === get_option( 'latest_layout_style', 'one-column' ) ) {
			get_template_part( 'template-parts/content' );
		} else {
			get_template_part( 'template-parts/content-grid-item' );
		}
	}
}


/**
 * Changes the text of the "Older posts" button in infinite scroll
 */
function latest_infinite_scroll_button_text( $js_settings ) {

	$js_settings['text'] = esc_html__( 'Load more', 'latest' );

	return $js_settings;
}
add_filter( 'infinite_scroll_js_settings', 'latest_infinite_scroll_button_text' );


/**
 * Move Related Posts
 */
function latest_remove_rp() {
    if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
        $jprp = Jetpack_RelatedPosts::init();
        $callback = array( $jprp, 'filter_add_target_to_dom' );
        remove_filter( 'post_flair', $callback, 40 );
        remove_filter( 'the_content', $callback, 40 );
    }
}
add_filter( 'wp', 'latest_remove_rp', 20 );


/**
 * Remove auto output of Sharing and Likes
 */
function latest_remove_sharing() {
	if ( function_exists( 'sharing_display' ) ) {
		remove_filter( 'the_content', 'sharing_display', 19 );
		remove_filter( 'the_excerpt', 'sharing_display', 19 );
	}

	if ( class_exists( 'Jetpack_Likes' ) ) {
		remove_filter( 'the_content', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
		remove_filter( 'the_excerpt', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
	}
}
