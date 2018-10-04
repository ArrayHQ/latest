/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

	( function( api ) {
	    'use strict';

	    api.bind( 'ready', function() {


			// Toggle the background color if opacity is reduced 
	        api( 'latest_hero_background_opacity', function(setting) {
	            var linkSettingValueToControlActiveState;

	            /**
	             * Update a control's active state according to the latest_hero_background_opacity setting's value.
	             *
	             * @param {api.Control} control Boxed body control.
	             */
	            linkSettingValueToControlActiveState = function( control ) {
	                var visibility = function() {
	                    if ( 1 > setting.get() ) {
	                        control.container.slideDown( 180 );
	                    } else {
	                        control.container.slideUp( 180 );
	                    }
	                };

	                // Set initial active state.
	                visibility();
	                //Update activate state whenever the setting is changed.
	                setting.bind( visibility );
	            };

	            // Call linkSettingValueToControlActiveState controls when they exist.
	            api.control( 'latest_hero_background_color', linkSettingValueToControlActiveState );
	        });


			// Toggle the background color if opacity is reduced
			api( 'latest_woo_hero_background_opacity', function(setting) {
	            var linkSettingValueToControlActiveState;

	            /**
	             * Update a control's active state according to the latest_woo_hero_background_opacity setting's value.
	             *
	             * @param {api.Control} control Boxed body control.
	             */
	            linkSettingValueToControlActiveState = function( control ) {
	                var visibility = function() {
	                    if ( 1 > setting.get() ) {
	                        control.container.slideDown( 180 );
	                    } else {
	                        control.container.slideUp( 180 );
	                    }
	                };

	                // Set initial active state.
	                visibility();
	                //Update activate state whenever the setting is changed.
	                setting.bind( visibility );
	            };

	            // Call linkSettingValueToControlActiveState controls when they exist.
				api.control( 'latest_woo_hero_background_color', linkSettingValueToControlActiveState );
	        });


	    });

	}( wp.customize ) );
