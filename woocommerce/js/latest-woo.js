(function($) {

	$(document).ready(function() {

		// Fade in the featured posts as they load
		function fade_images() {
			$('.featured-posts .product').each(function(i) {
				var row = $(this);
				setTimeout(function() {
					row.addClass('fadeInUp');
				}, 100*i)
			});
		}

		// Fade out the featured posts as they reload
		function fade_out_images() {
			$('.featured-posts .product').each(function(i) {
				var row = $(this);
				setTimeout(function() {
					row.addClass('fadeOutDown');
				}, 100*i)
			});
		}


		// Fade out the featured post container while loading
		$('.woo-category-navigation a').click(function(e) {
			fade_out_images();
		});


		// Replace category URL with hastag for the Customizer
		if ($('.in-customizer')[0]){
			$('.woo-category-navigation a').attr("href", '#');
		}


		// Fetch ajax posts for category menu
		var megaNavLink = $('#woo-category-navigation a');

		megaNavLink.click(function (event) {

			var catLink = $(this).attr('data-object-id');

			if (typeof catLink !== typeof undefined && catLink !== false) {

				event.preventDefault();

				var id = $(this).attr('data-object-id');

				console.log(id);

				var container = $('.product-container');

				var data = {
					action: 'latest_woo_category',
					id: id
				}

				$.ajax({
					data: data,
					type: "POST",
					dataType: "json",
					url: latest_woo_js_vars.ajaxurl,
					success: function(response) {
						container.html(response.html);
						$('.product-container').removeClass('post-loading');

						// Reset the post container if empty
						$('.featured-posts').removeClass('hide');
						if ($('.show .product-container').is(':empty')){
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
		$('#woo-category-navigation ul li:first-child a').click();


		// Change item quantity on click
		$(document).on('click', '.plus', function(e) {
	        $input = $(this).prev('input.qty');
	        var val = parseInt($input.val());
	        var step = $input.attr('step');
	        step = 'undefined' !== typeof(step) ? parseInt(step) : 1;
	        $input.val( val + step ).change();
	    });
	    $(document).on('click', '.minus', function(e) {
	        $input = $(this).next('input.qty');
	        var val = parseInt($input.val());
	        var step = $input.attr('step');
	        step = 'undefined' !== typeof(step) ? parseInt(step) : 1;
	        if (val > 0) {
	            $input.val( val - step ).change();
	        }
	    });

	});

})(jQuery);
