<?php
/**
 * Latest Theme Customizer
 *
 * Customizer color options can be found in inc/wporg.php.
 *
 * @package Latest
 */

add_action( 'customize_register', 'latest_customizer_register' );

if ( is_admin() && defined( 'DOING_AJAX' ) && DOING_AJAX && ! is_customize_preview() ) {
	return;
}

if ( is_customize_preview() ) :

/**
 * Hero category select
 */
class Latest_Customize_Category_Control extends WP_Customize_Control {
    private $cats = false;

    public function __construct( $manager, $id, $args = array(), $options = array() ) {
        $this->cats = get_categories( $options );

        parent::__construct( $manager, $id, $args );
    }

    /**
     * Render the content of the category dropdown
     *
     * @return HTML
     */
    public function render_content() {

        if( !empty( $this->cats ) ) {
        ?>

            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <span class="description customize-control-description"><?php echo esc_html__( 'Select a category to populate the hero header.', 'latest' ); ?></span>
                <select <?php $this->link(); ?>>
                    <?php
                        // Add an empty default option
                        printf( '<option value="0">' . esc_html( 'Disable Featured Header', 'latest' ) . '</option>' );
                        printf( '<option value="0">--</option>' );

                        foreach ( $this->cats as $cat ) {
                            printf( '<option value="%s" %s>%s</option>', $cat->term_id, selected( $this->value(), $cat->term_id, false ), $cat->name );
                        }
                    ?>
            </select>
            </label>

        <?php }
    }
}
endif;


/**
 * Sanitizes the hero category select
 */
function latest_sanitize_integer( $input ) {
    if( is_numeric( $input ) ) {
        return intval( $input );
    }
}


/**
 * Sanitize range slider
 */
function latest_sanitize_range( $input ) {
	filter_var( $input, FILTER_FLAG_ALLOW_FRACTION );
	return ( $input );
}


/**
 * Sanitize text
 */
function latest_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}


/**
 * Sanitize textarea output
 */
function latest_sanitize_textarea( $text ) {
    return esc_textarea( $text );
}


/**
 * Sanitize checkbox
 */
function latest_sanitize_checkbox( $input ) {
	return ( 1 == $input ) ? 1 : '';
}


/**
 * Sanitize page dropdown
 */
function latest_sanitize_dropdown_pages( $page_id, $setting ) {
    $page_id = absint( $page_id );
    return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}


/**
 * Show the excerpt if the one column option is selected
 */
function latest_one_column_excerpt_callback( $control ) {
    $excerpt_setting = $control->manager->get_setting('latest_layout_style')->value();
    $control_id = $control->id;

    if ( $excerpt_setting == 'one-column' ) return true;

    return false;
}


/**
 * Show the excerpt if the one column option is selected
 */
function latest_one_column_excerpt_length_callback( $control ) {
    $excerpt_setting        = $control->manager->get_setting('latest_one_column_excerpt')->value();
    $excerpt_layout_setting = $control->manager->get_setting('latest_layout_style')->value();
    $control_id = $control->id;

    if ( $excerpt_setting == 'show-excerpt' && $excerpt_layout_setting == 'one-column' ) return true;

    return false;
}


/**
 * Show the excerpt if the multi column option is selected
 */
function latest_multi_column_excerpt_length_callback( $control ) {
    $excerpt_setting = $control->manager->get_setting('latest_layout_style')->value();
    $control_id = $control->id;

    if ( $excerpt_setting != 'one-column' ) return true;

    return false;
}


/**
 * @param WP_Customize_Manager $wp_customize
 */
function latest_customizer_register( $wp_customize ) {

    /**
	 * Inlcude the Alpha Color Picker
	 */
	require_once( get_template_directory() . '/inc/admin/alpha-color-picker/alpha-color-picker.php' );

    /**
	 * Theme Options Panel
	 */
	$wp_customize->add_panel( 'latest_customizer_settings_panel', array(
		'priority'   => 1,
		'capability' => 'edit_theme_options',
		'title'      => esc_html__( 'Theme Options', 'latest' ),
	) );


	/**
	 * General Settings Panel
	 */
	$wp_customize->add_section( 'latest_general_settings', array(
		'title'    => esc_html__( 'General Settings', 'latest' ),
		'priority' => 1,
		'panel'    => 'latest_customizer_settings_panel',
	) );


	/**
	* Main Accent Color
	*/
	$wp_customize->add_setting( 'latest_accent_color', array(
	   'default'           => '#05a9f4',
	   'transport'         => 'postMessage',
	   'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'latest_accent_color', array(
	   'label'       => esc_html__( 'Main Accent Color', 'latest' ),
       'description' => esc_html__( 'Change the main accent color found throughout the site.', 'latest' ),
	   'section'     => 'latest_general_settings',
	   'settings'    => 'latest_accent_color',
	   'priority'    => 10,
	) ) );


	/**
	 * Post Layout
	 */
	$wp_customize->add_setting( 'latest_layout_style', array(
		'default'           => 'one-column',
        'type'              => 'option',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'latest_sanitize_text',
	));

	$wp_customize->add_control( 'latest_layout_style_select', array(
		'settings'        => 'latest_layout_style',
		'label'           => esc_html__( 'Post Layout', 'latest' ),
		'description'     => esc_html__( 'Choose a layout for posts on your homepage and archive pages.', 'latest' ),
		'section'         => 'latest_general_settings',
		'type'            => 'select',
		'choices'  => array(
			'one-column'           => esc_html__( '1 column + sidebar', 'latest' ),
			'two-column'           => esc_html__( '2 column grid + sidebar', 'latest' ),
			'two-column-masonry'   => esc_html__( '2 column masonry + sidebar', 'latest' ),
			'three-column'         => esc_html__( '3 column grid no sidebar', 'latest' ),
			'three-column-masonry' => esc_html__( '3 column masonry no sidebar', 'latest' ),
		),
		'priority' => 20
	) );

    $wp_customize->selective_refresh->add_partial( 'latest_layout_style', array(
        'selector' => '.blog .grid-wrapper .post:first-child',
        'container_inclusive' => false,
        'render_callback' => function() {
			return get_option( 'latest_layout_style' );
        },
    ) );


    /**
	 * One Column Post Excerpt
	 */
	$wp_customize->add_setting( 'latest_one_column_excerpt', array(
		'default'           => 'show-full',
        'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'latest_sanitize_text',
	));

	$wp_customize->add_control( 'latest_one_column_excerpt_select', array(
		'settings'        => 'latest_one_column_excerpt',
		'label'           => esc_html__( 'Index Post Excerpt', 'latest' ),
		'description'     => esc_html__( 'Show the full post on the one-column blog homepage, or show an excerpt instead.', 'latest' ),
		'section'         => 'latest_general_settings',
		'type'            => 'select',
        'active_callback' => 'latest_one_column_excerpt_callback',
		'choices'  => array(
			'show-full'    => esc_html__( 'Show Full Post', 'latest' ),
			'show-excerpt' => esc_html__( 'Show Excerpt', 'latest' ),
		),
		'priority' => 21
	) );


    /**
	 * Excerpt length for one column layout
	 */
	$wp_customize->add_setting( 'latest_one_column_excerpt_length', array(
		'sanitize_callback' => 'latest_sanitize_integer',
        'default'           => '40',
	) );

	$wp_customize->add_control( 'latest_one_column_excerpt_length', array(
			'label'           => esc_html__( 'Excerpt Length', 'latest' ),
            'description'     => esc_html__( 'Modify the excerpt length on the one-column blog homepage.', 'latest' ),
			'section'         => 'latest_general_settings',
			'settings'        => 'latest_one_column_excerpt_length',
			'type'            => 'text',
            'active_callback' => 'latest_one_column_excerpt_length_callback',
			'priority'        => 22,
		)
	);


    /**
	 * Excerpt length for one column layout
	 */
	$wp_customize->add_setting( 'latest_multi_column_excerpt_length', array(
		'sanitize_callback' => 'latest_sanitize_integer',
        'default'           => '25',
	) );

	$wp_customize->add_control( 'latest_multi_column_excerpt_length', array(
			'label'           => esc_html__( 'Excerpt Length', 'latest' ),
            'description'     => esc_html__( 'Modify the excerpt length on the multi-column blog homepage.', 'latest' ),
			'section'         => 'latest_general_settings',
			'settings'        => 'latest_multi_column_excerpt_length',
			'type'            => 'text',
            'active_callback' => 'latest_multi_column_excerpt_length_callback',
			'priority'        => 22,
		)
	);


	/**
	 * Header search field
	 */
	$wp_customize->add_setting( 'latest_header_search', array(
		'default'           => 'enabled',
        'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'latest_sanitize_text',
	));

	$wp_customize->add_control( 'latest_header_search_select', array(
		'settings'    => 'latest_header_search',
		'label'       => esc_html__( 'Header Search', 'latest' ),
		'description' => esc_html__( 'Show a search box in the header.', 'latest' ),
		'section'     => 'latest_general_settings',
		'type'        => 'select',
		'choices'  => array(
			'enabled'  => esc_html__( 'Enabled', 'latest' ),
			'disabled' => esc_html__( 'Disabled', 'latest' ),
		),
		'priority' => 23
	) );

    $wp_customize->selective_refresh->add_partial( 'latest_header_search', array(
        'selector' => '.header-search-container',
        'container_inclusive' => false,
        'render_callback' => function() {
			return get_option( 'latest_header_search' );
        },
    ) );


	/**
	 * Sticky Header
	 */
	$wp_customize->add_setting( 'latest_sticky_header', array(
		'default'           => 'enabled',
        'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'latest_sanitize_text',
	));

	$wp_customize->add_control( 'latest_sticky_header_select', array(
		'settings' => 'latest_sticky_header',
		'label'    => esc_html__( 'Sticky Menu', 'latest' ),
		'description' => esc_html__( 'Make the Primary menu sticky while scrolling the page.', 'latest' ),
		'section'  => 'latest_general_settings',
		'type'     => 'select',
		'choices'  => array(
			'enabled'  => esc_html__( 'Enabled', 'latest' ),
			'disabled' => esc_html__( 'Disabled', 'latest' ),
		),
		'priority' => 25
	) );


	/**
	 * Featured Page One
	 */
    $wp_customize->add_setting( 'latest_featured_page_one', array(
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'latest_sanitize_dropdown_pages',
    ) );

    $wp_customize->add_control( 'latest_featured_page_one', array(
        'type'        => 'dropdown-pages',
        'section'     => 'latest_general_settings',
        'label'       => esc_html__( 'Featured Page One', 'latest' ),
        'description' => esc_html__( 'Select a page to featured in the Featured Pages section above the post loop.', 'latest' ),
        'priority'    => 30
    ) );

    $wp_customize->selective_refresh->add_partial( 'latest_featured_page_one', array(
        'selector' => '#featured-pages h2, .featured-blog-wrapper .featured-pages .post:first-child',
        'container_inclusive' => false,
        'render_callback' => function() {
			return get_theme_mod( 'latest_featured_page_one' );
        },
    ) );

    /**
	 * Featured Page Two
	 */
    $wp_customize->add_setting( 'latest_featured_page_two', array(
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'latest_sanitize_dropdown_pages',
    ) );

    $wp_customize->add_control( 'latest_featured_page_two', array(
        'type'        => 'dropdown-pages',
        'section'     => 'latest_general_settings',
        'label'       => esc_html__( 'Featured Page Two', 'latest' ),
        'description' => esc_html__( 'Select a page to featured in the Featured Pages section above the post loop.', 'latest' ),
        'priority'    => 40
    ) );

    $wp_customize->selective_refresh->add_partial( 'latest_featured_page_two', array(
        'selector' => '.featured-blog-wrapper .featured-pages .post:nth-child(2)',
        'container_inclusive' => false,
        'render_callback' => function() {
			return get_theme_mod( 'latest_featured_page_two' );
        },
    ) );

    /**
	 * Featured Page Three
	 */
    $wp_customize->add_setting( 'latest_featured_page_three', array(
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'latest_sanitize_dropdown_pages',
    ) );

    $wp_customize->add_control( 'latest_featured_page_three', array(
        'type'        => 'dropdown-pages',
        'section'     => 'latest_general_settings',
        'label'       => esc_html__( 'Featured Page Three', 'latest' ),
        'description' => esc_html__( 'Select a page to featured in the Featured Pages section above the post loop.', 'latest' ),
        'priority'    => 50
    ) );

    $wp_customize->selective_refresh->add_partial( 'latest_featured_page_three', array(
        'selector' => '.featured-blog-wrapper .featured-pages .post:nth-child(3)',
        'container_inclusive' => false,
        'render_callback' => function() {
			return get_theme_mod( 'latest_featured_page_three' );
        },
    ) );


    /**
	 * Header headline text
	 */
	$wp_customize->add_setting( 'latest_headline_text', array(
		'sanitize_callback' => 'latest_sanitize_text',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'latest_headline_text', array(
			'label'    => esc_html__( 'Headline Text', 'latest' ),
            'description' => esc_html__( 'Add custom text to the top left side of your Top Navigation menu bar.', 'latest' ),
			'section'  => 'latest_general_settings',
			'settings' => 'latest_headline_text',
			'type'     => 'text',
			'priority' => 60
		)
	);

    $wp_customize->selective_refresh->add_partial( 'latest_headline_text', array(
        'selector' => '.headline-text',
        'container_inclusive' => false,
        'render_callback' => function() {
			return get_theme_mod( 'latest_headline_text' );
        },
    ) );


    /**
	 * Footer tagline
	 */
	$wp_customize->add_setting( 'latest_footer_text', array(
		'sanitize_callback' => 'latest_sanitize_text',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'latest_footer_text', array(
			'label'    => esc_html__( 'Footer Tagline', 'latest' ),
            'description' => esc_html__( 'Add custom text to the footer of your site.', 'latest' ),
			'section'  => 'latest_general_settings',
			'settings' => 'latest_footer_text',
			'type'     => 'text',
			'priority' => 70
		)
	);

    $wp_customize->selective_refresh->add_partial( 'latest_footer_text', array(
        'selector' => '.footer-tagline',
        'container_inclusive' => false,
        'render_callback' => function() {
			return get_theme_mod( 'latest_footer_text' );
        },
    ) );


	/**
	 * Homepage Hero Settings Panel
	 */
	$wp_customize->add_section( 'latest_hero_settings', array(
		'title'    => esc_html__( 'Featured Posts Header', 'latest' ),
		'priority' => 3,
		'panel'    => 'latest_customizer_settings_panel',
	) );


	/**
	 * Homepage Hero Header
	 */
	$wp_customize->add_setting( 'latest_hero_header', array(
		'sanitize_callback' => 'latest_sanitize_integer',
        'type'              => 'theme_mod',
	) );

	$wp_customize->add_control( new Latest_Customize_Category_Control( $wp_customize, 'latest_hero_header_select', array(
		'label'           => esc_html__( 'Featured Post Category', 'latest' ),
		'section'         => 'latest_hero_settings',
		'settings'        => 'latest_hero_header',
		'priority'        => 5,
	) ) );

    $wp_customize->selective_refresh->add_partial( 'latest_hero_header', array(
        'selector' => '.post-hero .hero-title',
        'container_inclusive' => false,
        'render_callback' => function() {
			return get_theme_mod( 'latest_hero_header' );
        },
    ) );

    // Add edit link to placeholder
    $wp_customize->selective_refresh->add_partial( 'latest_hero_header', array(
        'selector' => '#hero-header h2',
        'container_inclusive' => false,
        'render_callback' => function() {
			return get_theme_mod( 'latest_hero_header' );
        },
    ) );


    $wp_customize->add_setting( 'latest_hero_header_exclude', array(
		'default'           => 0,
		'sanitize_callback' => 'latest_sanitize_checkbox',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'latest_hero_header_exclude', array(
		'label'    => esc_html__( 'Exclude Featured Posts', 'latest' ),
		'description' => esc_html__( 'Check this box if you want to exclude carousel posts from the main post loop.', 'latest' ),
		'section'  => 'latest_hero_settings',
		'settings' => 'latest_hero_header_exclude',
		'priority' => 10,
		'type'     => 'checkbox',
	) ) );


    /**
	 * Hero alignment style
	 */
	$wp_customize->add_setting( 'latest_hero_alignment', array(
		'default'           => 'center',
		'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'latest_sanitize_text',
	));

	$wp_customize->add_control( 'latest_hero_alignment_select', array(
		'settings'    => 'latest_hero_alignment',
		'label'       => esc_html__( 'Text Alignment', 'latest' ),
		'section'     => 'latest_hero_settings',
		'type'        => 'select',
		'choices'     => array(
			'center' => esc_html__( 'Center', 'latest' ),
			'left'   => esc_html__( 'Left', 'latest' ),
            'right'  => esc_html__( 'Right', 'latest' ),
		),
		'priority' => 15
	) );


    /**
	* Hero Header Background Image Opacity
	*/
	$wp_customize->add_setting( 'latest_hero_background_opacity', array(
	   'default'           => '1',
	   'type'              => 'theme_mod',
	   'capability'        => 'edit_theme_options',
	   'transport'         => 'postMessage',
	   'sanitize_callback' => 'latest_sanitize_range',
	) );

	$wp_customize->add_control( 'latest_hero_background_opacity', array(
	   'type'        => 'range',
	   'priority'    => 20,
	   'section'     => 'latest_hero_settings',
	   'label'       => esc_html__( 'Header Image Opacity', 'latest' ),
       'description' => esc_html__( 'Adjust the opacity of the images in the hero header.', 'latest' ),
	   'input_attrs' => array(
		   'min'   => 0,
		   'max'   => 1,
		   'step'  => .025,
		   'style' => 'width: 100%',
	   ),
	) );


	/**
	 * Hero Height
	 */
	$wp_customize->add_setting( 'latest_hero_height', array(
		'default'           => '10',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'latest_sanitize_range',
	) );

	$wp_customize->add_control( 'latest_hero_height', array(
		'type'        => 'range',
		'priority'    => 25,
		'section'     => 'latest_hero_settings',
		'label'       => esc_html__( 'Header Height', 'latest' ),
		'description' => esc_html__( 'Adjust the height of the hero header.', 'latest' ),
		'input_attrs' => array(
			'min'   => 2,
			'max'   => 20,
			'step'  => .5,
			'style' => 'width: 100%',
		),
	) );


	/**
	* Hero Header Background Color
	*/
	$wp_customize->add_setting( 'latest_hero_background_color', array(
	   'default'           => '#f2f2f2',
	   'transport'         => 'postMessage',
	   'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'latest_hero_background_color', array(
	   'label'       => esc_html__( 'Header Background Color', 'latest' ),
       'description' => esc_html__( 'Change the background color of the hero header.', 'latest' ),
	   'section'     => 'latest_hero_settings',
	   'settings'    => 'latest_hero_background_color',
	   'priority'    => 20,
	) ) );


    /**
	 * Hero text background color
	 */
	$wp_customize->add_setting( 'latest_hero_text_bg_color', array(
			'default'           => 'rgba(30,30,30,0.9)',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'latest_sanitize_text',
		)
	);

	$wp_customize->add_control(
		new Customize_Alpha_Color_Control( $wp_customize, 'latest_hero_text_bg_color', array(
				'label'        => esc_html__( 'Text Background Color', 'latest' ),
				'section'      => 'latest_hero_settings',
				'settings'     => 'latest_hero_text_bg_color',
				'show_opacity' => true,
				'priority'     => 35,
				'description'  => esc_html__( 'Change the background color of the text in the hero header.', 'latest' ),
				'palette'      => array(
                    'rgba(255,255,255,.9)',
                    'rgba(30,30,30,0.9)',
					'rgba(0,178,116,0.9)',
					'rgba(160,108,209,0.9)',
                    'rgba(37,145,198,0.9)',
                    'rgba(221,60,42,0.9)',
				)
			)
		)
	);


    /**
	 * Hero text color
	 */
	$wp_customize->add_setting( 'latest_hero_text_color_custom', array(
			'default'           => 'rgba(255,255,255,1)',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'latest_sanitize_text',
		)
	);

	$wp_customize->add_control(
		new Customize_Alpha_Color_Control( $wp_customize, 'latest_hero_text_color_custom', array(
				'label'        => esc_html__( 'Text Color', 'latest' ),
				'section'      => 'latest_hero_settings',
				'settings'     => 'latest_hero_text_color_custom',
				'show_opacity' => true,
				'priority'     => 40,
				'description'  => esc_html__( 'Change the text color in the hero header.', 'latest' ),
				'palette'      => array(
					'rgba(255,255,255,1)',
					'rgba(43,49,55,1)',
                    '#005bc4',
					'#32a522',
				)
			)
		)
	);
}


/**
 * Add Customizer CSS To Header
 */
function latest_custom_css() {
    $accent_color               = get_theme_mod( 'latest_accent_color', '#05a9f4' );
    $css_hero_height            = get_theme_mod( 'latest_hero_height' );
    $hero_background_opacity    = get_theme_mod( 'latest_hero_background_opacity', 1 );
    $hero_background_color      = get_theme_mod( 'latest_hero_background_color', '#f2f2f2' );
    $hero_text_background_color = get_theme_mod( 'latest_hero_text_bg_color', 'rgba(30,30,30,0.9)' );
    $hero_text_color_custom     = get_theme_mod( 'latest_hero_text_color_custom', 'rgba(255,255,255,1)' );

	if ( $css_hero_height || $hero_background_opacity || $hero_background_color || $hero_text_background_color || $hero_text_color_custom || $accent_color ) {
	?>
	<style type="text/css">
        <?php if ( $accent_color ) { ?>
			.grid-thumb .entry-title a:hover {
				border-bottom-color: <?php echo esc_attr( $accent_color ); ?>;
			}

			#hero-pager .rslides_here {
                border-top-color: <?php echo esc_attr( $accent_color ); ?>;
            }

            .entry-cats a,
			.hero-cats a {
                background: <?php echo esc_attr( $accent_color ); ?>;
            }

			.post-content a:not([class*="button"]):hover {
				border-bottom-color: <?php echo esc_attr( $accent_color ); ?>;
    			color: <?php echo esc_attr( $accent_color ); ?>;
			}
		<?php } ?>

        <?php if ( $css_hero_height ) { ?>
			.post-hero {
				padding: <?php echo esc_attr( $css_hero_height ); ?>% 0;
			}
		<?php } ?>

        <?php if ( $hero_background_opacity ) { ?>
			.post-hero .site-header-bg.background-effect {
				opacity: <?php echo esc_attr( $hero_background_opacity ); ?>;
			}
		<?php } ?>

        <?php if ( $hero_background_color ) { ?>
			.post-hero .hero-posts {
				background-color: <?php echo esc_attr( $hero_background_color ); ?>;
			}
		<?php } ?>

        <?php if( $hero_text_background_color ) { ?>
            .post-hero .hero-title .entry-title span,
            .post-hero .hero-title .hero-excerpt p {
                background-color: <?php echo esc_attr( $hero_text_background_color ); ?>;
            	box-shadow: 10px 0 0 <?php echo esc_attr( $hero_text_background_color ); ?>, -10px 0 0 <?php echo esc_attr( $hero_text_background_color ); ?>;


            }
            .hero-date {
                background: <?php echo esc_attr( $hero_text_background_color ); ?>;
            }
        <?php } ?>

        <?php if( $hero_text_color_custom ) { ?>
            .post-hero .post-title .entry-title a,
            .post-hero .hero-excerpt span,
            .post-hero .hero-date,
            .post-hero .hero-date a {
                color: <?php echo esc_attr( $hero_text_color_custom ); ?>;
            }
        <?php } ?>
	</style>
<?php
} }
add_action( 'wp_head', 'latest_custom_css' );


/**
 * Replaces the footer tagline text
 */
function latest_filter_footer_text() {

	// Get the footer copyright text
	$footer_copy_text = get_theme_mod( 'latest_footer_text' );

	if ( $footer_copy_text ) {
		// If we have footer text, use it
		$footer_text = $footer_copy_text;
	} else {
		// Otherwise show the fallback theme text
		$footer_text = '&copy; ' . date("Y") . sprintf( esc_html__( ' %1$s Theme by %2$s.', 'latest' ), 'Latest', '<a href="https://arraythemes.com/" rel="nofollow">Array</a>' );
	}

	return $footer_text;

}
add_filter( 'latest_footer_text', 'latest_filter_footer_text' );


/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function latest_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

    $wp_customize->selective_refresh->add_partial( 'header_site_title', array(
        'selector' => '.site-title a',
        'settings' => array( 'blogname' ),
        'render_callback' => function() {
            return get_bloginfo( 'name', 'display' );
        },
    ) );
}
add_action( 'customize_register', 'latest_customize_register' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function latest_customize_preview_js() {
	wp_enqueue_script( 'latest_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), rand(1, 100), true );
}
add_action( 'customize_preview_init', 'latest_customize_preview_js' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function latest_customize_control_js() {
	wp_enqueue_script( 'latest_customizer', get_template_directory_uri() . '/js/customizer-controls.js', array( 'customize-controls' ), rand(1, 100), true );
}
add_action( 'customize_controls_enqueue_scripts', 'latest_customize_control_js' );
