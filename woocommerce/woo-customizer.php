<?php
/**
 * WooCommerce related customizer settings
 *
 * @package latest
 */

 /**
 * @param WP_Customize_Manager $wp_customize
 */

 add_action( 'customize_register', 'latest_woo_customizer_register' );

 if ( is_admin() && defined( 'DOING_AJAX' ) && DOING_AJAX && ! is_customize_preview() ) {
	return;
 }

 if ( is_customize_preview() ) :

 /**
 * WooCommerce category select
 */
 function latest_woo_cats_select() {

	$results = array(
		false => esc_html__( '', 'latest' )
	);

	$woo_cats = get_terms( 'product_cat', array( 'hide_empty' => false ) );

	if ( ! empty( $woo_cats ) && ! is_wp_error( $woo_cats ) ) {
		foreach( $woo_cats as $key => $value ) {
			$results[$value->slug] = $value->name;
		}
	}
	return $results;
 }

 function latest_woo_customizer_register( $wp_customize ) {
	/**
	 * WooCommerce Settings Panel
	 */
	$wp_customize->add_section( 'latest_woo_general_settings', array(
		'title'    => esc_html__( 'WooCommerce - General', 'latest' ),
		'priority' => 5,
		'panel'    => 'latest_customizer_settings_panel',
	) );

	/**
	 * WooCommerce Header Settings Panel
	 */
	$wp_customize->add_section( 'latest_woo_hero_settings', array(
		'title'    => esc_html__( 'WooCommerce - Header Banner', 'latest' ),
		'priority' => 10,
		'panel'    => 'latest_customizer_settings_panel',
	) );


	/**
	 * Woo Header Background Image
	 */
	$wp_customize->add_setting( 'latest_woo_hero_image', array(
		'sanitize_callback' => 'latest_sanitize_text'
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'latest_woo_hero_image', array(
		'label'       => esc_html__( 'Header Background Image', 'latest' ),
		'description' => esc_html__( 'Choose an image to feature in the background of your header.', 'latest' ),
		'section'     => 'latest_woo_hero_settings',
		'settings'    => 'latest_woo_hero_image',
		'priority'    => 5
	) ) );

	$wp_customize->selective_refresh->add_partial( 'latest_woo_hero_image', array(
        'selector' => '#woo-hero-header h2',
        'container_inclusive' => false,
        'render_callback' => function() {
			return get_theme_mod( 'latest_woo_hero_image' );
        },
    ) );


	/**
	* Woo Header Background Image Opacity
	*/
	$wp_customize->add_setting( 'latest_woo_hero_background_opacity', array(
	   'default'           => '1',
	   'type'              => 'theme_mod',
	   'capability'        => 'edit_theme_options',
	   'transport'         => 'postMessage',
	   'sanitize_callback' => 'latest_sanitize_range',
	) );

	$wp_customize->add_control( 'latest_woo_hero_background_opacity', array(
	   'type'        => 'range',
	   'priority'    => 9,
	   'section'     => 'latest_woo_hero_settings',
	   'label'       => esc_html__( 'Header Image Opacity', 'latest' ),
	   'description' => esc_html__( 'Change the opacity of the image in your header.', 'latest' ),
	   'input_attrs' => array(
		   'min'   => 0,
		   'max'   => 1,
		   'step'  => .1,
		   'style' => 'width: 100%',
	   ),
	) );


	/**
	* Woo Header Background Color
	*/
	$wp_customize->add_setting( 'latest_woo_hero_background_color', array(
	   'default'           => '#fff',
	   'transport'         => 'postMessage',
	   'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'latest_woo_hero_background_color', array(
	   'label'       => esc_html__( 'Header Background Color', 'latest' ),
	   'section'     => 'latest_woo_hero_settings',
	   'settings'    => 'latest_woo_hero_background_color',
	   'priority'    => 10
	) ) );


	/**
	 * Hero Height
	 */
	$wp_customize->add_setting( 'latest_woo_hero_height', array(
		'default'           => '10',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'latest_sanitize_range',
	) );

	$wp_customize->add_control( 'latest_woo_hero_height', array(
		'type'        => 'range',
		'priority'    => 10,
		'section'     => 'latest_woo_hero_settings',
		'label'       => esc_html__( 'Header Height', 'latest' ),
		'description' => esc_html__( 'Adjust the height of the header.', 'latest' ),
		'input_attrs' => array(
			'min'   => 2,
			'max'   => 20,
			'step'  => .5,
			'style' => 'width: 100%',
		),
	) );


	/**
	 * Hero text background color
	 */
	$wp_customize->add_setting( 'latest_woo_hero_text_bg_color', array(
			'default'           => 'rgba(255,255,255,0.9)',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'latest_sanitize_text',
		)
	);

	$wp_customize->add_control(
		new Customize_Alpha_Color_Control( $wp_customize, 'latest_woo_hero_text_bg_color', array(
				'label'        => esc_html__( 'Header Text Background Color', 'latest' ),
				'section'      => 'latest_woo_hero_settings',
				'settings'     => 'latest_woo_hero_text_bg_color',
				'show_opacity' => true,
				'priority'     => 35,
				'description'  => esc_html__( 'Change the background color of the text in the header.', 'latest' ),
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
	$wp_customize->add_setting( 'latest_woo_hero_text_color_custom', array(
			'default'           => 'rgba(43,49,55,1)',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'latest_sanitize_text',
		)
	);

	$wp_customize->add_control(
		new Customize_Alpha_Color_Control( $wp_customize, 'latest_woo_hero_text_color_custom', array(
				'label'        => esc_html__( 'Header Text Color', 'latest' ),
				'section'      => 'latest_woo_hero_settings',
				'settings'     => 'latest_woo_hero_text_color_custom',
				'show_opacity' => true,
				'priority'     => 40,
				'description'  => esc_html__( 'Change the text color in the header.', 'latest' ),
				'palette'      => array(
					'rgba(255,255,255,1)',
					'rgba(43,49,55,1)',
                    '#005bc4',
					'#32a522',
				)
			)
		)
	);


    /**
	* Hero alignment style
	*/
	$wp_customize->add_setting( 'latest_woo_hero_alignment', array(
		'transport'         => 'postMessage',
		'capability'        => 'edit_theme_options',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'latest_sanitize_text',
	));

	$wp_customize->add_control( 'latest_woo_hero_alignment_select', array(
		'settings'    => 'latest_woo_hero_alignment',
		'label'       => esc_html__( 'Header Text Alignment', 'latest' ),
		'description' => esc_html__( 'Change the alignment of the text in your header.', 'latest' ),
		'section'     => 'latest_woo_hero_settings',
		'type'        => 'select',
		'choices'     => array(
			'center' => esc_html__( 'Center', 'latest' ),
			'left'   => esc_html__( 'Left', 'latest' ),
			'right'  => esc_html__( 'Right', 'latest' ),
		),
		'priority' => 15
	) );


	/**
	 * Woo Header Title
	 */
	$wp_customize->add_setting( 'latest_woo_hero_title', array(
		'sanitize_callback' => 'latest_sanitize_text',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'latest_woo_hero_title', array(
			'label'       => esc_html__( 'Header Title', 'latest' ),
			'description' => esc_html__( 'Add a large title to the header.', 'latest' ),
			'section'     => 'latest_woo_hero_settings',
			'settings'    => 'latest_woo_hero_title',
			'type'        => 'text',
			'priority'    => 20
		)
	);

	$wp_customize->selective_refresh->add_partial( 'latest_woo_hero_title', array(
        'selector' => '.woocommerce .post-title .entry-title',
        'container_inclusive' => false,
        'render_callback' => function() {
			return get_theme_mod( 'latest_woo_hero_title' );
        },
    ) );


	/**
	 * Woo Header Text
	 */
	$wp_customize->add_setting( 'latest_woo_hero_text', array(
		'sanitize_callback' => 'latest_sanitize_text',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'latest_woo_hero_text', array(
			'label'    => esc_html__( 'Header Text', 'latest' ),
			'description' => esc_html__( 'Add paragraph text below the title in the header.', 'latest' ),
			'section'  => 'latest_woo_hero_settings',
			'settings' => 'latest_woo_hero_text',
			'type'     => 'textarea',
			'priority' => 30
		)
	);

	$wp_customize->selective_refresh->add_partial( 'latest_woo_hero_text', array(
        'selector' => '.woocommerce .hero-excerpt',
        'container_inclusive' => false,
        'render_callback' => function() {
			return get_theme_mod( 'latest_woo_hero_text' );
        },
    ) );


	/**
	 * Woo Header Button Text
	 */
	$wp_customize->add_setting( 'latest_woo_hero_button_text', array(
		'sanitize_callback' => 'latest_sanitize_text',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'latest_woo_hero_button_text', array(
			'label'       => esc_html__( 'Header Button Text', 'latest' ),
			'description' => esc_html__( 'Change the text of the button in the header.', 'latest' ),
			'section'     => 'latest_woo_hero_settings',
			'settings'    => 'latest_woo_hero_button_text',
			'type'        => 'text',
			'priority'    => 50
		)
	);

	$wp_customize->selective_refresh->add_partial( 'latest_woo_hero_button_text', array(
        'selector' => '.woocommerce .hero-container a.button',
        'container_inclusive' => false,
        'render_callback' => function() {
			return get_theme_mod( 'latest_woo_hero_button_text' );
        },
    ) );

	/**
	 * Woo Header Button URL
	 */
	$wp_customize->add_setting( 'latest_woo_hero_button_url', array(
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'latest_woo_hero_button_url', array(
			'label'    => esc_html__( 'Header Button URL', 'latest' ),
			'description' => esc_html__( 'Add a link to the button in the header. (http://yoursite.com/shop)', 'latest' ),
			'section'  => 'latest_woo_hero_settings',
			'settings' => 'latest_woo_hero_button_url',
			'type'     => 'text',
			'priority' => 60
		)
	);

	/**
	 * Woo Header Button Backgroud Color
	 */
	$wp_customize->add_setting( 'latest_woo_hero_button_color', array(
		'default'           => '#0697ca',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new Customize_Alpha_Color_Control( $wp_customize, 'latest_woo_hero_button_color', array(
		'label'       => esc_html__( 'Header Button Background Color', 'latest' ),
		'description' => esc_html__( 'Change the background color of the header button.', 'latest' ),
		'section'     => 'latest_woo_hero_settings',
		'settings'    => 'latest_woo_hero_button_color',
		'priority'    => 70
	) ) );

	/**
	 * Woo Header Button Text Color
	 */
	$wp_customize->add_setting( 'latest_woo_hero_button_text_color', array(
		'default'           => '#fff',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'latest_sanitize_text',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'latest_woo_hero_button_text_color', array(
		'label'       => esc_html__( 'Header Button Text Color', 'latest' ),
		'description' => esc_html__( 'Change the text color of the header button.', 'latest' ),
		'section'     => 'latest_woo_hero_settings',
		'settings'    => 'latest_woo_hero_button_text_color',
		'priority'    => 80
	) ) );

	/**
	* Hero text color
	*/
	$wp_customize->add_setting( 'latest_woo_hero_button_style', array(
		'default'           => '0px',
		'transport'         => 'postMessage',
		'capability'        => 'edit_theme_options',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'latest_sanitize_text',
	));

	$wp_customize->add_control( 'latest_woo_hero_button_style_select', array(
		'settings' => 'latest_woo_hero_button_style',
		'label'    => esc_html__( 'Header Button Style', 'latest' ),
		'description' => esc_html__( 'Change the shape of the header button.', 'latest' ),
		'section'  => 'latest_woo_hero_settings',
		'type'     => 'select',
		'choices'  => array(
			'0px'  => esc_html__( 'Square', 'latest' ),
			'5px'  => esc_html__( 'Rounded Square', 'latest' ),
			'40px' => esc_html__( 'Round', 'latest' ),
		),
		'priority' => 90
	) );


	/**
	 * Featured Category One
	 */
    $wp_customize->add_setting( 'latest_featured_woo_one', array(
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'latest_sanitize_text',
    ) );

    $wp_customize->add_control( 'latest_featured_woo_one', array(
        'section'     => 'latest_woo_general_settings',
        'label'       => esc_html__( 'Featured Product Category One', 'latest' ),
        'description' => esc_html__( 'Select a product category to featured in the Featured Category section above your products.', 'latest' ),
		'type'        => 'select',
		'choices'     => latest_woo_cats_select(),
        'priority'    => 90
    ) );

	$wp_customize->selective_refresh->add_partial( 'latest_featured_woo_one', array(
        'selector' => '#woo-featured-pages h2, .featured-product-wrapper .featured-pages .post:first-child',
        'container_inclusive' => false,
        'render_callback' => function() {
			return get_theme_mod( 'latest_featured_woo_one' );
        },
    ) );


    /**
	 * Featured Category Two
	 */
    $wp_customize->add_setting( 'latest_featured_woo_two', array(
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'latest_sanitize_text',
    ) );

    $wp_customize->add_control( 'latest_featured_woo_two', array(
        'section'     => 'latest_woo_general_settings',
        'label'       => esc_html__( 'Featured Product Category Two', 'latest' ),
		'description' => esc_html__( 'Select a product category to featured in the Featured Category section above your products.', 'latest' ),
		'type'        => 'select',
		'choices'     => latest_woo_cats_select(),
        'priority'    => 100
    ) );

	$wp_customize->selective_refresh->add_partial( 'latest_featured_woo_two', array(
		'selector' => '.featured-product-wrapper .featured-pages .post:nth-child(2)',
        'container_inclusive' => false,
        'render_callback' => function() {
			return get_theme_mod( 'latest_featured_woo_two' );
        },
    ) );


    /**
	 * Featured Category Three
	 */
    $wp_customize->add_setting( 'latest_featured_woo_three', array(
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'latest_sanitize_text',
    ) );

    $wp_customize->add_control( 'latest_featured_woo_three', array(
        'section'     => 'latest_woo_general_settings',
        'label'       => esc_html__( 'Featured Product Category Three', 'latest' ),
		'description' => esc_html__( 'Select a product category to featured in the Featured Category section above your products.', 'latest' ),
		'type'        => 'select',
		'choices'     => latest_woo_cats_select(),
		'priority'    => 110
    ) );

	$wp_customize->selective_refresh->add_partial( 'latest_featured_woo_three', array(
        'selector' => '.featured-product-wrapper .featured-pages .post:nth-child(3)',
        'container_inclusive' => false,
        'render_callback' => function() {
			return get_theme_mod( 'latest_featured_woo_three' );
        },
    ) );


    /**
	* Woo Sidebar Position
	*/
	$wp_customize->add_setting( 'latest_woo_header_search', array(
		'default'           => 'product',
		'capability'        => 'edit_theme_options',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'latest_sanitize_text',
	));

	$wp_customize->add_control( 'latest_woo_header_search_select', array(
		'settings' => 'latest_woo_header_search',
		'label'    => esc_html__( 'Header Search', 'latest' ),
		'description' => esc_html__( 'Choose to show the default search form or a product search in the header.', 'latest' ),
		'section'  => 'latest_woo_general_settings',
		'type'     => 'select',
		'choices'  => array(
			'default' => esc_html__( 'Default Search', 'latest' ),
			'product' => esc_html__( 'Product Search', 'latest' ),
		),
		'priority' => 112
	) );


    /**
	* Woo Sidebar Position
	*/
	$wp_customize->add_setting( 'latest_woo_sidebar', array(
		'default'           => 'right',
		'capability'        => 'edit_theme_options',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'latest_sanitize_text',
	));

	$wp_customize->add_control( 'latest_woo_sidebar_select', array(
		'settings' => 'latest_woo_sidebar',
		'label'    => esc_html__( 'Shop Sidebar Position', 'latest' ),
		'section'  => 'latest_woo_general_settings',
		'type'     => 'select',
		'choices'  => array(
			'right' => esc_html__( 'Right', 'latest' ),
			'left'  => esc_html__( 'Left', 'latest' ),
		),
		'priority' => 115
	) );


    /**
	* Woo Column Count
	*/
	$wp_customize->add_setting( 'latest_woo_columns', array(
		'default'           => '3',
		'capability'        => 'edit_theme_options',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'latest_sanitize_integer',
	));

	$wp_customize->add_control( 'latest_woo_columns_select', array(
		'settings'    => 'latest_woo_columns',
		'label'       => esc_html__( 'Product Columns', 'latest' ),
		'description' => esc_html__( 'Change the number of product columns on the shop page.', 'latest' ),
		'section'     => 'latest_woo_general_settings',
		'type'        => 'select',
		'choices'  => array(
			'2' => esc_html__( 'Two', 'latest' ),
			'3' => esc_html__( 'Three', 'latest' ),
			'4' => esc_html__( 'Four', 'latest' ),
		),
		'priority' => 120
	) );
 }

endif;


/**
 * Add Woo Customizer CSS To Header
 */
function latest_woo_css() {
	$css_hero_height            = get_theme_mod( 'latest_woo_hero_height' );
    $hero_text_background_color = get_theme_mod( 'latest_woo_hero_text_bg_color', 'rgba(255,255,255,0.9)' );
	$hero_text_color_custom     = get_theme_mod( 'latest_woo_hero_text_color_custom', 'rgba(43,49,55,1)' );
    $hero_button_color          = get_theme_mod( 'latest_woo_hero_button_color', '#0697ca' );
    $hero_button_text_color     = get_theme_mod( 'latest_woo_hero_button_text_color', '#fff' );
	$hero_button_style          = get_theme_mod( 'latest_woo_hero_button_style', '0px' );
	$hero_text_alignment        = get_theme_mod( 'latest_woo_hero_alignment', 'center' );
	$hero_background_image      = get_theme_mod( 'latest_woo_hero_image' );
	$hero_background_opacity    = get_theme_mod( 'latest_woo_hero_background_opacity' );
	$hero_background_color      = get_theme_mod( 'latest_woo_hero_background_color' );
	$sidebar_position           = get_theme_mod( 'latest_woo_sidebar' );

	if ( $css_hero_height || $hero_text_background_color || $hero_text_color_custom || $hero_button_color || $hero_button_text_color || $hero_button_style || $hero_text_alignment || $hero_background_image || $hero_background_opacity || $hero_background_color || $product_columns || $sidebar_position ) {
	?>
	<style type="text/css">
		<?php if ( $css_hero_height ) { ?>
			.woocommerce .hero-container {
				padding: <?php echo esc_attr( $css_hero_height ); ?>% 0;
			}
		<?php } ?>

		<?php if( $hero_text_background_color ) { ?>
            .woocommerce .hero-title .entry-title span,
            .woocommerce .hero-title .hero-excerpt p {
                background-color: <?php echo esc_attr( $hero_text_background_color ); ?>;
            	box-shadow: 10px 0 0 <?php echo esc_attr( $hero_text_background_color ); ?>, -10px 0 0 <?php echo esc_attr( $hero_text_background_color ); ?>;
            }

            .woocommerce .hero-date,
            .woocommerce .hero-cats a {
                background: <?php echo esc_attr( $hero_text_background_color ); ?>;
            }
        <?php } ?>

        <?php if( $hero_text_color_custom ) { ?>
            .woocommerce .post-title .entry-title a,
			.woocommerce .hero-title .hero-excerpt p,
            .woocommerce .post-hero .hero-excerpt span,
            .woocommerce .post-hero .hero-date,
            .woocommerce .post-hero .hero-date a,
            .woocommerce .hero-cats a {
                color: <?php echo esc_attr( $hero_text_color_custom ); ?>;
            }
        <?php } ?>

		<?php if ( $hero_button_color ) { ?>
			.woocommerce .hero-container .button,
			.woocommerce .hero-container .button:hover {
				background: <?php echo esc_attr( $hero_button_color ); ?>;
			}
		<?php } ?>

		<?php if ( $hero_button_text_color ) { ?>
			.woocommerce .hero-container .button,
			.woocommerce .hero-container .button:hover {
				color: <?php echo esc_attr( $hero_button_text_color ); ?>;
			}
		<?php } ?>

		<?php if( $hero_button_style ) { ?>
			.woocommerce .hero-container .button {
				border-radius: <?php echo esc_attr( $hero_button_style ); ?>;
			}
		<?php } ?>

		<?php if( $hero_text_alignment ) { ?>
			.woocommerce .hero-container .container {
				text-align: <?php echo esc_attr( $hero_text_alignment ); ?>;
			}
		<?php } ?>

		<?php if( $hero_background_image ) { ?>
			.woocommerce .hero-container .site-header-bg.background-effect {
				background-image: url(<?php echo esc_attr( $hero_background_image ); ?>);
			}
		<?php } ?>

		<?php if( $hero_background_opacity ) { ?>
			.woocommerce .hero-container .site-header-bg.background-effect {
				opacity: <?php echo esc_attr( $hero_background_opacity ); ?>;
			}
		<?php } ?>

		<?php if( $hero_background_color ) { ?>
			.woocommerce .hero-wrapper {
				background-color: <?php echo esc_attr( $hero_background_color ); ?>;
			}
		<?php } ?>

		<?php if( $sidebar_position == 'left' ) { ?>
			@media screen and (min-width: 786px) {
				.woocommerce .site-content #secondary {
					order: 1;
					border-left: none;
					border-right: solid 1px #e6e9ec;
				}

				.woocommerce #primary.product-content-area {
					order: 2;
					padding-right: 0;
					padding-left: 4%;
				}

				.woocommerce .widget-area aside {
					padding: 14% 12% 14% 0;
				}

				.woocommerce .widget-area aside:first-child {
					padding-top: 0;
				}
			}
		<?php } ?>
	</style>
<?php
} }
add_action( 'wp_head', 'latest_woo_css' );
