(function($) {

	$(document).ready(function() {

		// Mobile menu drawer
		$('.drawer-menu-toggle').click(function(e) {
			// Reset the toggle button
			$('.drawer-open-toggle').removeClass('drawer-toggle-switch');

			// Show the explore drawer
			$('.drawer').toggleClass('show-drawer');

			// Add a class to the body
			$(document.body).toggleClass('drawer-open');

			// Toggle the button state
			$('.drawer-menu-toggle').toggleClass('drawer-toggle-switch');

			return false;
		});


		// When drawer is open, allow click on body to close
		$('html').click(function() {
			$('.drawer-open .drawer').slideUp(200);
			$('body.drawer-open').removeClass('drawer-open');
			$('.drawer').removeClass('show-drawer');
			$('.drawer-toggle').removeClass('drawer-toggle-switch');
		});


		// Allow clicking in the drawer when it's open
		$('.drawer').click(function(event){
		    event.stopPropagation();
		});


		// Remove underline from linked images
		$('.entry-content img').each(function() {
			$(this).parent().addClass('no-underline');
		});


		// Standardize drop menu types
		$('.main-navigation .children, .drawer-navigation .children').addClass('sub-menu');
		$('.main-navigation .page_item_has_children, .drawer-navigation .page_item_has_children').addClass('menu-item-has-children');

		/**
		 * Mobile menu functionality
		 */

		// Append a clickable icon to mobile drop menus
		var item = $('<button class="toggle-sub" aria-expanded="false"><i class="fa fa-plus"></i></button>');

		// Append clickable icon for mobile drop menu
		if ($('.drawer .menu-item-has-children .toggle-sub').length == 0) {
			$('.drawer .menu-item-has-children,.drawer .page_item_has_children').append(item);
		}

		// Show sub menu when toggle is clicked
		$('.drawer .menu-item-has-children .toggle-sub').click(function(e) {
			$(this).each(function() {
				e.preventDefault();

				// Change aria expanded value
				$(this).attr('aria-expanded', ($(this).attr('aria-expanded')=='false') ? 'true':'false');

				// Open the drop menu
				$(this).closest('.menu-item-has-children').toggleClass('drop-open');
				$(this).prev('.sub-menu').toggleClass('drop-active');

				// Change the toggle icon
				$(this).find('i').toggleClass('fa-plus').toggleClass('fa-minus');
			});
		});


		// Expand featured images that are too tall
		$('.portrait-image').each(function() {
			$(this).find('.featured-image i').click(function(e) {
				$(this).closest('.featured-image').toggleClass('expand-image');
			});
		});


		// Create the sticky nav bar if we're on the single page
		if ($('.single .entry-header h1')[0]){
			var section_single = $('.single .entry-header').offset().top;

			// Show the nav bar when we get to the post title
			$(window).scroll(function() {
				if($(window).scrollTop() > section_single) {
					$('.home-nav').addClass('show-nav');
				} else {
					$('.home-nav').removeClass('show-nav');
				}
			});

			// Show the nav bar when we get to the post title
			$(window).scroll(function() {
				if($(window).scrollTop() > section_single) {
					$('.main-navigation-sticky').addClass('hide-sticky-nav');
				} else {
					$('.main-navigation-sticky').removeClass('hide-sticky-nav');
				}
			});
		}


		// Create the sticky nav bar
		if ($('.main-navigation ul li')[0]){
			var main_nav = $('.main-navigation:not(.main-navigation-sticky)').offset().top ;

			// Show the nav bar when we get past the static menu
			$(window).scroll(function() {
				if($(window).scrollTop() > main_nav) {
					$('.main-navigation-sticky').addClass('show-nav');
				} else {
					$('.main-navigation-sticky').removeClass('show-nav');
				}
			});
		}


		// Scroll back to top
		$('.back-to-top, .sticky-title').click(function(e) {
			e.preventDefault();

			$('html,body').animate({
			    scrollTop: 0
			}, 700);

			return false;
		} );


		// Load fitvids
        function fitVids() {
            // Fitvids
	        $('.post iframe').not('.fitvid iframe').wrap('<div class="fitvid"/>');
			$('.fitvid').fitVids();
        }
        fitVids();


		// Load infinite scroll
		$(document.body).on("post-load", function() {
			var $container = $('.grid-wrapper');
			var $newItems = $('.new-infinite-posts').not('.is--replaced');
			var $elements = $newItems.find('.post');

			// Remove the empty elements that break the grid
			$('.new-infinite-posts,.infinite-loader').remove();

			// Append IS posts
			$container.append($elements);

			$container.imagesLoaded( function() {
				$container.masonry('appended', $elements, true ).masonry('reloadItems').masonry('layout');
				fitVids();
				equalHeight();
			});
		});


		// Run masonry
		$(window).on("load", function() {
			var current_width = $(window).width();

		    if (current_width > 600) {

				function runMasonry() {
					// Masonry blocks
					var $blocks = $('.masonry-column .grid-wrapper');

					$blocks.imagesLoaded( function() {
						$blocks.masonry({
							itemSelector: '.post',
							transitionDuration: 0
						});
					});
				}
				runMasonry();

				// Resize masonry blocks on window resize
				$(window).resize(function() {
					runMasonry();
				});
			}
		});

	});

})(jQuery);
