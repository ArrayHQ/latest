(function($) {

	$(document).ready(function() {

		// Initialize responsive slides
		var $slides = $('.hero-posts');
		$slides.responsiveSlides({
		    auto: false,
		    speed: 500,
		    nav: true,
		    navContainer: ".pager-navs",
		    manualControls: '#hero-pager',
		});


		// Show the pager after the slides load
		function showPager() {
			$('.hero-pager-wrap').addClass('fadeInUp');
        }


		// Add touch support to responsive slides
		$('.home .hero-wrapper .rslides').each(function() {
		    $(this).swipe({
			swipeLeft: function() {
			    $(this).parent().find('.rslides_nav.prev').click();
			},
			swipeRight: function() {
			    $(this).parent().find('.rslides_nav.next').click();
			}
		    });
		});

		function heroHover() {
			$(this).find('a').trigger('click');
        }

		$('#hero-pager li').hoverIntent({
		    over: heroHover,
			out: function() {},
		    interval: 300
		});

	});

})(jQuery);
