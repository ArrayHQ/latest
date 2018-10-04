(function($) {

	$(document).ready(function() {

		// Fade in the featured posts as they load
		function fade_images() {
			$('.featured-posts .post,.featured-posts .product').each(function(i) {
				var row = $(this);
				setTimeout(function() {
					row.addClass('fadeInUp');
				}, 100*i)
			});
		}


		// Fade in the featured posts as they load
		function fade_out_images() {
			$('.featured-posts .post').each(function(i) {
				var row = $(this);
				setTimeout(function() {
					row.addClass('fadeOutDown');
				}, 100*i)
			});
		}


		// Fade out the featured post container while loading
		$('.category-navigation a').click(function(e) {
			fade_out_images();
		});


		// Make entire slide clickable
		// $('.hero-posts .post').click(function(e) {
		//
		// 	$(this).find('.hero-title .entry-title a').trigger('click');
		// });

		// Show sub menu when toggle is clicked
		$('.hero-posts .post').click(function(e) {
			// Open the drop menu
			e.stopPropagation();
			$(this).find('.entry-title a').get(0).click();
		});


		// Replace category URL with hastag for the Customizer
		if ($('.in-customizer')[0]){
			$('.category-navigation a').attr("href", '#');
		}


		// Fetch ajax posts for category menu
		var megaNavLink = $('#category-navigation a');

		megaNavLink.click(function (event) {

			var catLink = $(this).attr('data-object-id');

			if (typeof catLink !== typeof undefined && catLink !== false) {

				event.preventDefault();

				var id = $(this).attr('data-object-id');

				var container = $('.post-container');

				var data = {
					action: 'latest_category',
					id: id
				}

				$.ajax({
					data: data,
					type: "POST",
					dataType: "json",
					url: latest_js_vars.ajaxurl,
					success: function(response) {
						container.html(response.html);
						$('.post-container').removeClass('post-loading');

						// Reset the post container if empty
						$('.featured-posts').removeClass('hide');
						if ($('.show .post-container').is(':empty')){
							$('.featured-posts').addClass('hide');
						}

						fade_images();
					},
					error: function(response) {
						container.html(response.html);
					}
				});

				$(this).parent().siblings().removeClass('current-menu-item');
				$(this).parent().addClass('current-menu-item');

				// Show the featured posts
				$('.featured-posts').addClass('show');

				container.show();
			}
		});


		// Click the first category link to use as a placeholder
		$('#category-navigation ul li:first-child a, .related-menu li:nth-child(2) a').click();

	});

})(jQuery);
