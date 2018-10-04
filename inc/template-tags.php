<?php

if ( ! function_exists( 'the_archive_title' ) ) :
/**
 * Shim for `the_archive_title()`.
 *
 * Display the archive title based on the queried object.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the title. Default empty.
 * @param string $after  Optional. Content to append to the title. Default empty.
 */
function the_archive_title( $before = '', $after = '' ) {
	if ( is_category() ) {
		$title = sprintf( esc_html__( 'Category: %s', 'latest' ), single_cat_title( '', false ) );
	} elseif ( is_tag() ) {
		$title = sprintf( esc_html__( 'Tag: %s', 'latest' ), single_tag_title( '', false ) );
	} elseif ( is_author() ) {
		$title = sprintf( esc_html__( 'Author: %s', 'latest' ), '<span class="vcard">' . get_the_author() . '</span>' );
	} elseif ( is_year() ) {
		$title = sprintf( esc_html__( 'Year: %s', 'latest' ), get_the_date( esc_html_x( 'Y', 'yearly archives date format', 'latest' ) ) );
	} elseif ( is_month() ) {
		$title = sprintf( esc_html__( 'Month: %s', 'latest' ), get_the_date( esc_html_x( 'F Y', 'monthly archives date format', 'latest' ) ) );
	} elseif ( is_day() ) {
		$title = sprintf( esc_html__( 'Day: %s', 'latest' ), get_the_date( esc_html_x( 'F j, Y', 'daily archives date format', 'latest' ) ) );
	} elseif ( is_tax( 'post_format' ) ) {
		if ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$title = esc_html_x( 'Asides', 'post format archive title', 'latest' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$title = esc_html_x( 'Galleries', 'post format archive title', 'latest' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$title = esc_html_x( 'Images', 'post format archive title', 'latest' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = esc_html_x( 'Videos', 'post format archive title', 'latest' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$title = esc_html_x( 'Quotes', 'post format archive title', 'latest' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$title = esc_html_x( 'Links', 'post format archive title', 'latest' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$title = esc_html_x( 'Statuses', 'post format archive title', 'latest' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$title = esc_html_x( 'Audio', 'post format archive title', 'latest' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$title = esc_html_x( 'Chats', 'post format archive title', 'latest' );
		}
	} elseif ( is_post_type_archive() ) {
		$title = sprintf( esc_html__( 'Archives: %s', 'latest' ), post_type_archive_title( '', false ) );
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
		$title = sprintf( esc_html__( '%1$s: %2$s', 'latest' ), $tax->labels->singular_name, single_term_title( '', false ) );
	} else {
		$title = esc_html__( 'Archives', 'latest' );
	}

	/**
	 * Filter the archive title.
	 *
	 * @param string $title Archive title to be displayed.
	 */
	$title = apply_filters( 'get_the_archive_title', $title );
	if ( ! empty( $title ) ) {
		echo $before . $title . $after;  // WPCS: XSS OK.
	}
}
endif;


if ( ! function_exists( 'the_archive_description' ) ) :
/**
 * Shim for `the_archive_description()`.
 *
 * Display category, tag, or term description.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function the_archive_description( $before = '', $after = '' ) {

	$description = apply_filters( 'get_the_archive_description', term_description() );

	if ( ! empty( $description ) ) {
		/**
		 * Filter the archive description.
		 *
		 * @see term_description()
		 *
		 * @param string $description Archive description to be displayed.
		 */
		echo $before . $description . $after;  // WPCS: XSS OK.
	}
}
endif;


/**
 * Display the author description on author archive
 */
function the_author_archive_description( $before = '', $after = '' ) {

	$author_description  = get_the_author_meta( 'description' );

	if ( ! empty( $author_description ) ) {
		/**
		 * Get the author bio
		 */
		echo $author_description;
	}
}


/**
 * Output paeg titles, subtitles and archive descriptions
 */
if ( ! function_exists( 'latest_page_titles' ) ) :
function latest_page_titles() {
	echo '<h1 class="entry-title">';
	if ( is_category() ) :
		single_cat_title();

	elseif ( is_tag() ) :
		single_tag_title();

	elseif ( is_author() ) :
		the_post();
		printf( __( 'Author: %s', 'latest' ), '' . get_the_author() . '' );
		rewind_posts();

	elseif ( is_day() ) :
		printf( __( 'Day: %s', 'latest' ), '<span>' . get_the_date() . '</span>' );

	elseif ( is_month() ) :
		printf( __( 'Month: %s', 'latest' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

	elseif ( is_year() ) :
		printf( __( 'Year: %s', 'latest' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

	elseif ( is_404() ) :
		_e( 'Page Not Found', 'latest' );

	elseif ( is_search() ) :
		printf( __( 'Search Results for: %s', 'latest' ), '<span>' . get_search_query() . '</span>' );

	// Title for portfolio archive
	elseif ( is_post_type_archive( 'jetpack-portfolio' ) ) :
		 post_type_archive_title();

	// Title for portfolio categories and tags
	elseif ( is_tax( array(
			'jetpack-portfolio', 'jetpack-portfolio-type' ) ) ) :
				single_term_title();

	elseif ( is_tax( array(
			'jetpack-portfolio', 'jetpack-portfolio-tag' ) ) ) :
				single_term_title();

	elseif ( is_home() && get_option( 'page_for_posts' ) ) :
		$blog_title = get_the_title( get_option( 'page_for_posts' ) );
		echo $blog_title;

	elseif ( is_single() ) :
		the_title();

	elseif ( class_exists( 'WooCommerce' ) && is_shop() || class_exists( 'WooCommerce' ) && is_product_category() || class_exists( 'WooCommerce' ) && is_product_tag()  ) :
		woocommerce_page_title();

	else :
		single_post_title();

	endif;
	echo '</h1>';


	// Get the page excerpt or archive description for a subtitle
	global $post;
	
	$archive_description = get_the_archive_description();

	if ( class_exists( 'WooCommerce' ) && is_shop() ) {
		$shop_page_id = get_option( 'woocommerce_shop_page_id' );
		if ( has_excerpt( $shop_page_id ) ) {
			$shop_excerpt = get_the_excerpt( $shop_page_id );
			$subtitle = $shop_excerpt;
		}
	} else if ( is_archive() && $archive_description ) {
		$subtitle = get_the_archive_description();
	} else if ( is_page() && has_excerpt() ) {
		$subtitle = '<p>' . get_the_excerpt( $post->ID ) . '</p>';
	} else {
		$subtitle = '';
	}

	// Show the subtitle
	if ( ! empty( $subtitle ) && ! is_singular( 'post' ) ) { ?>
		<div class="entry-subtitle">
			<?php echo $subtitle; ?>
		</div>
	<?php }
} endif;


if ( ! function_exists( 'latest_page_title_wrap' ) ) {
function latest_page_title_wrap() { ?>
	<div id="title-wrap" class="page-title-wrap">
		<div class="container">
			<header class="entry-header">
					<?php
						if( latest_page_titles() ) {
							latest_page_titles();
						}
					?>
				</h1>
			</header><!-- .entry-header -->
		</div>
	</div>
<?php } }
add_filter( 'latest_before_page', 'latest_page_title_wrap' );


/**
 * Site title and logo
 */
if ( ! function_exists( 'latest_title_logo' ) ) :
function latest_title_logo() { ?>
	<div class="site-title-wrap">
		<!-- Use the Site Logo feature, if supported -->
		<?php
			$custom_logo_id = get_theme_mod( 'custom_logo' );
			$logo           = wp_get_attachment_image_src( $custom_logo_id , 'latest-logo' );

			if ( has_custom_logo() ) {
				if ( is_front_page() && is_home() ) { ?>
					<h1 class="site-logo">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $logo[0] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" /></a>
					</h1>
	 			<?php } else { ?>
					<p class="site-logo">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $logo[0] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" /></a>
					</p>
	 			<?php }
			}
		?>

		<div class="titles-wrap">
			<?php if ( is_front_page() && is_home() ) { ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
 			<?php } else { ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
 			<?php } ?>

			<?php if ( get_bloginfo( 'description' ) ) { ?>
				<p class="site-description"><?php bloginfo( 'description' ); ?></p>
			<?php } ?>
		</div>
	</div><!-- .site-title-wrap -->
<?php } endif;


/**
 * Custom comment output
 */
if ( ! function_exists( 'latest_comment' ) ) :
function latest_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; ?>
<li <?php comment_class( 'clearfix' ); ?> id="li-comment-<?php comment_ID() ?>">

	<div class="comment-block" id="comment-<?php comment_ID(); ?>">

		<div class="comment-wrap">
			<?php echo get_avatar( $comment->comment_author_email, 75 ); ?>

			<div class="comment-info">
				<cite class="comment-cite">
				    <?php comment_author_link() ?>
				</cite>

				<a class="comment-time" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf( esc_html__( '%1$s at %2$s', 'latest' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( esc_html__( '(Edit)', 'latest' ), '&nbsp;', '' ); ?>
			</div>

			<div class="comment-content">
				<?php comment_text() ?>
				<p class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ) ?>
				</p>
			</div>

			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'latest' ) ?></em>
			<?php endif; ?>
		</div>
	</div>
<?php
} endif;


/**
 * Modify title reply text to add span
 */
function comment_reform ( $arg ) {
	$arg['title_reply'] = '<span>' . esc_html__( 'Leave a reply', 'latest' ) . '</span>';
	return $arg;
}
add_filter( 'comment_form_defaults', 'comment_reform' );


/**
 * Next/previous post links
 */
if ( ! function_exists( 'latest_post_navigation' ) ) :
function latest_post_navigation() { ?>
	<!-- Next and previous post links -->
	<?php $nextPost = get_next_post();

	$prevPost = get_previous_post();

	if ( $nextPost || $prevPost ) { ?>

		<nav class="post-navigation">
			<?php
				if( $prevPost ) {
					$prev_post_link_url = get_permalink( get_adjacent_post( false,'',true )->ID );

					$prevPostDate = mysql2date( get_option( 'date_format' ), $prevPost->post_date );

					echo '<div class="nav-prev nav-post">';

						echo '<div class="nav-post-text">';
							echo '<span class="nav-label">' . esc_html__( 'Next', 'latest' ) . '</span>';
							echo '<div class="nav-post-link">';
								previous_post_link( '%link', '%title' );
							echo '</div>';
						echo '</div>';
					echo '</div>';
			} ?>

			<?php
				if( $nextPost ) {
					$next_post_link_url = get_permalink( get_adjacent_post( false,'',false )->ID );

					$nextPostDate = mysql2date( get_option( 'date_format' ), $nextPost->post_date );

					echo '<div class="nav-next nav-post">';
						echo '<div class="nav-post-text">';
							echo '<span class="nav-label">' . esc_html__( 'Previous', 'latest' ) . '</span>';
							echo '<div class="nav-post-link">';
								next_post_link( '%link', '%title' );
							echo '</div>';
						echo '</div>';
					echo '</div>';
			} ?>
		</nav><!-- .post-navigation -->
	<?php }
} endif;


/**
 * Output categories for the hero header
 *
 * * @since latest 1.2.1
 */
if ( ! function_exists( 'latest_list_cats' ) ) :
function latest_list_cats( $type ='grid' ) {
	global $post;

	$categories = get_the_category( $post->ID );

	if ( $categories ) {
		// Limit the number of categories output to 3 to keep things tidy
		$i = 0;

		echo '<div class=" '. $type . '-cats">';
			foreach( ( get_the_category( $post->ID ) ) as $cat ) {
				echo '<a href="' . esc_url( get_category_link( $cat->cat_ID ) ) . '">' . esc_html( $cat->cat_name ) . '</a>';
				if ( ++$i == 3 ) {
					break;
				}
			}
		echo '</div>';
	}
} endif;


/**
 * Output categories for the grid items
 *
 * * @since latest 1.2.1
 */
if ( ! function_exists( 'latest_grid_cats' ) ) :
function latest_grid_cats() {
	global $post;

	$categories = get_the_category( $post->ID );

	if ( $categories ) {
		// Limit the number of categories output to 3 to keep things tidy
		$i = 0;

		echo '<div class="grid-cats">';
			foreach( ( get_the_category( $post->ID ) ) as $cat ) {
				echo '<a href="' . esc_url( get_category_link( $cat->cat_ID ) ) . '">' . esc_html( $cat->cat_name ) . '</a>';
				if ( ++$i == 3 ) {
					break;
				}
			}
		echo '</div>';
	}
} endif;


/**
 * Displays post pagination links
 *
 * @since latest 1.0
 */
if ( ! function_exists( 'latest_page_navs' ) ) :
function latest_page_navs( $query = false ) {

	global $wp_query;
	if( $query ) {
		$temp_query = $wp_query;
		$wp_query = $query;
	}

	// Return early if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	} ?>
	<div class="page-navigation">
		<?php
			$big = 999999999; // need an unlikely integer

			echo paginate_links( array(
				'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'    => '?paged=%#%',
				'current'   => max( 1, get_query_var('paged') ),
				'total'     => $wp_query->max_num_pages,
				'next_text' => esc_html__( '&rarr;', 'latest' ),
				'prev_text' => esc_html__( '&larr;', 'latest' )
			) );
		?>
	</div>
	<?php
	if( isset( $temp_query ) ) {
		$wp_query = $temp_query;
	}
} endif;


/**
 * Author post widget
 *
 * @since 1.0
 */
if ( ! function_exists( 'latest_author_box' ) ) :
function latest_author_box() {
	global $post, $current_user;
	$author = get_userdata( $post->post_author );
	if ( ! empty( $author->description ) ) {
	?>
	<div class="author-profile">
		<a class="author-profile-avatar" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php esc_attr_e( 'Posts by', 'latest' ); ?> <?php the_author(); ?>"><?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'latest_author_bio_avatar_size', 65 ) ); ?></a>

		<div class="author-profile-info">
			<h3 class="author-profile-title">
				<?php if ( is_archive() ) { ?>
					<?php esc_html_e( 'All posts by', 'latest' ); ?>
				<?php } else { ?>
					<?php esc_html_e( 'Posted by', 'latest' ); ?>
				<?php } ?>
				<?php echo esc_html( get_the_author() ); ?></h3>

			<?php if ( empty( $author->description ) && $post->post_author == $current_user->ID ) { ?>
				<div class="author-description">
					<p>
					<?php
						$profileString = sprintf( wp_kses( __( 'Complete your author profile info to be shown here. <a href="%1$s">Edit your profile &rarr;</a>', 'latest' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'profile.php' ) ) );
						echo $profileString;
					?>
					</p>
				</div>
			<?php } else if ( $author->description ) { ?>
				<div class="author-description">
					<p><?php the_author_meta( 'description' ); ?></p>
				</div>
			<?php } ?>

			<div class="author-profile-links">
				<a href="<?php echo get_author_posts_url( $author->ID ); ?>"><i class="fa fa-pencil-square"></i> <?php esc_html_e( 'All Posts', 'latest' ); ?></a>

				<?php if ( $author->user_url ) { ?>
					<?php printf( '<a href="%s"><i class="fa fa-external-link-square"></i> %s</a>', $author->user_url, __( 'Website', 'latest' ) ); ?>
				<?php } ?>
			</div>
		</div><!-- .author-drawer-text -->
	</div><!-- .author-profile -->
				
<?php } } endif;
