/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function($){

	// Site title and description
	wp.customize('blogname',function(value){
		value.bind(function(to){
			$('.site-title').text(to);
		});
	});


	wp.customize('blogdescription',function(value){
		value.bind(function(to){
			$('.site-description').text(to);
		});
	});


	wp.customize('latest_accent_color',function(value){
		value.bind(function(to){
			$('.entry-content a').css('border-color',to);

			$('.hero-cats a,.page-numbers.current,.page-numbers:hover,.drawer .tax-widget a:hover,#page #infinite-handle button:hover').css('background-color',to);
		});
	});


	wp.customize('latest_button_color',function(value){
		value.bind(function(to){
			$('button,input[type="button"],input[type="reset"],input[type="submit"],.button,.comment-navigation a').css('background-color',to);
		});
	});


	// Footer text
	wp.customize('latest_footer_text',function(value){
		value.bind(function(to){
			$('.site-info').text(to);
		});
	});

	// Hero background color
	wp.customize('latest_hero_background_color',function(value){
		value.bind(function(to){
			$('.hero-wrapper').css('background-color',to);
		});
	});

	// Hero image opacity
	wp.customize('latest_hero_background_opacity',function(value){
		value.bind(function(to){
			$('.hero-posts .site-header-bg.background-effect').css('opacity',to);
		});
	});


	// Hero height
	wp.customize('latest_hero_height', function( value ) {
		value.bind( function( to ) {
			$( '.hero-container' ).css( 'padding', to + '% 0' );
		} );
	} );


	// Hero height
	wp.customize('latest_hero_alignment',function(value){
		value.bind(function(to){
			$('.post-hero .container').css('text-align',to);
		});
	});


	// Hero text background color
	wp.customize('latest_hero_text_color',function(value){
		value.bind(function(to){

			$(".post-hero .hero-title .entry-title span, .post-hero .hero-title .hero-excerpt p").css({
				"background-color": "rgba(255,255,255,.9)",
                "box-shadow": "10px 0 0 rgba(255,255,255,.9), -10px 0 0 rgba(255,255,255,.9)",
			});

		});
	});


	// Hero text background color custom
	wp.customize('latest_hero_text_bg_color',function(value){
		value.bind(function(to){

			$(".post-hero .hero-title .entry-title span, .post-hero .hero-title .hero-excerpt p").css({
				"background-color": to,
				"color": to,
				"box-shadow": "10px 0 0, -10px 0 0",
			});

			$(".hero-date, .hero-cats a").css({
				"background": to
			});

		});
	});


	// Hero text color
	wp.customize('latest_hero_text_color_custom',function(value){
		value.bind(function(to){

			$(".post-title .entry-title a, .hero-excerpt span, .hero-date, .hero-date a").css({
				"color": to,
			});

		});
	});



})(jQuery);
