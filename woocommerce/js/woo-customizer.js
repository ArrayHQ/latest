/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function($){

	wp.customize('latest_woo_hero_background_color',function(value){
		value.bind(function(to){
			$('.woocommerce .hero-wrapper').css('background-color',to);
		});
	});

	wp.customize('latest_woo_hero_background_opacity',function(value){
		value.bind(function(to){
			$('.woocommerce .hero-container .site-header-bg.background-effect').css('opacity',to);
		});
	});

	wp.customize('latest_woo_hero_height',function(value){
		value.bind(function(to){
			$('.woocommerce .hero-container').css('padding',to + '% 0' );
		});
	});

	wp.customize('latest_woo_hero_button_color',function(value){
		value.bind(function(to){
			$('.woocommerce .hero-container a.button,.woocommerce .hero-container a.button:hover').css('background-color',to);
		});
	});

	wp.customize('latest_woo_hero_button_text_color',function(value){
		value.bind(function(to){
			$('.woocommerce .hero-container a.button,.woocommerce .hero-container a.button:hover').css('color',to);
		});
	});

	wp.customize('latest_woo_hero_button_style',function(value){
		value.bind(function(to){
			$('.woocommerce .hero-container a.button').css('border-radius',to);
		});
	});

	wp.customize('latest_woo_hero_alignment',function(value){
		value.bind(function(to){
			$('.woocommerce .hero-container .container').css('text-align',to);
		});
	});

	// Hero text background color custom
	wp.customize('latest_woo_hero_text_bg_color',function(value){
		value.bind(function(to){

			$(".woocommerce .hero-title .entry-title span, .woocommerce .hero-title .hero-excerpt p").css({
				"background-color": to,
				"box-shadow": "10px 0 0, -10px 0 0",
			});

			$(".woocommerce .hero-date, .woocommerce .hero-cats a").css({
				"background": to
			});

		});
	});

	// Hero text color
	wp.customize('latest_woo_hero_text_color_custom',function(value){
		value.bind(function(to){

			$(".woocommerce .hero-wrapper .entry-title a, .woocommerce .hero-excerpt span, .woocommerce .hero-date, .woocommerce .hero-date a, .woocommerce .hero-cats a").css({
				"color": to,
			});

		});
	});

})(jQuery);
