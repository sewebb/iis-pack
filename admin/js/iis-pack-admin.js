(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$( document ).on( {
		// to check that ip-address is correct (lighter check)
	    'click': function () {
	    	var csscls    = 'compat-field-iis_pack_',
	    		on_off    = $( '.' + csscls + 'api_flickr input:checkbox:checked').length > 0;

	    	// Only use API if both Photo url and Fetch data from Fkickr-checkbox is on
    		if ( '' !== $( '.' + csscls + 'object_url input ').val() && on_off ) {
    			// if checkbox used before
    			$( '.flickr-status' ).remove();

    			var photo_url  = $( '.' + csscls + 'object_url input ').val(),
    				path       = photo_url.replace( '//', '' ),
    				path_array = path.split( '/' ),
    				photo_id   = 'photo_id=' + path_array[3],
    				api_key    = '&api_key=6c957bbf546dcd188615000edf2e7487', // Right now Thomas Flickr-api-key
					method     = '&method=flickr.photos.getInfo',
					call       = '&format=json&jsoncallback=?',
					flickr_api_url = 'https://api.flickr.com/services/rest/?' + photo_id + api_key + method + call;

	    		$( '.media-types.media-types-required-info' ).prepend( '<div class="flickr-status wrap"><div class="notice"><p>Vi hämtar information från Flickr<span class="spinner" style="margin:0;"></span></p></div></div>' );
	    		$( '.spinner' ).css('visibility', 'visible');

				$.getJSON( flickr_api_url, function ( data ) {
				}).done(function(data){
					var status = data.stat;
					if ( 'fail' === status ) {
						$( '.spinner' ).css('visibility', 'hidden');
						$( '.flickr-status' ).remove();
						$( '.media-types.media-types-required-info' ).prepend( '<div class="flickr-status wrap"><div class="notice error"><p>Vi kunde inte hitta info om bilden hos Flickr. Kontroller bildens url. (Det kan vara ett fel i API:et också)</p></div></div>' );

					} else {
						var photo_title         = data.photo.title._content,
							license             = data.photo.license,
							license_holder_name = data.photo.owner.realname,
							license_holder_url  = data.photo.owner.path_alias,
							this_license        = flickr_choosen_license(license);

						if ( 'undefined' == typeof license_holder_name || '' === license_holder_name ) {
							license_holder_name = data.photo.owner.username;
						}
						license_holder_url  = 'https://www.flickr.com/photos/' + license_holder_url;

						$( '.' + csscls + 'object_name input').val(photo_title);
						$( '.' + csscls + 'license_holder_name input').val(license_holder_name);
						$( '.' + csscls + 'license_holder_url input').val(license_holder_url);

						$( '.' + csscls + 'license input').val(this_license[0]);
						$( '.' + csscls + 'license_url input').val(this_license[1]);

						// this only visual feedback that something is happening
						setTimeout(function(){
							$( '.spinner' ).css('visibility', 'hidden');
							$( '.flickr-status' ).remove();
							// This is used to trigger WP to save
							$( '.' + csscls + 'api_flickr input:checkbox:checked').trigger( 'click' );
							// Easy changing
							$( '.' + csscls + 'object_name input').select();
							if ( $( '.compat-item' )[0] ) {
								$( '.compat-item' ).prepend( '<div class="flickr-status wrap"><div class="notice notice-success"><p>Information från Flickr är hämtad OCH sparad.</p></div></div>' );
							} else {
								$( '.media-types.media-types-required-info' ).prepend( '<div class="flickr-status wrap"><div class="notice notice-success"><p>Information från Flickr är hämtad. Klicka på "Uppdatera" för att spara.</p></div></div>' );
							}

						}, 200 );
					}

				});

	    	} // end if it is flickr-request
	    }
	}, '.compat-field-iis_pack_api_flickr' );

	function flickr_choosen_license( license ) {
		var license     = parseInt(license),
			license_url = '';
		switch ( license ) {
			case 0:
				license     = 'All Rights Reserved';
				license_url = '';
				var return_license =  [license, license_url];
				return return_license;
				break;

			case 1:
				license     = 'CC BY-NC-SA';//'Attribution-NonCommercial-ShareAlike License'
				license_url = 'http://creativecommons.org/licenses/by-nc-sa/2.0/';
				var return_license =  [license, license_url];
				return return_license;
				break;

			case 2:
				license     = 'CC BY-NC';//'Attribution-NonCommercial License'
				license_url = 'http://creativecommons.org/licenses/by-nc/2.0/';
				var return_license =  [license, license_url];
				return return_license;
				break;

			case 3:
				license     = 'CC BY-NC-ND';//'Attribution-NonCommercial-NoDerivs License'
				license_url = 'http://creativecommons.org/licenses/by-nc-nd/2.0/';
				var return_license =  [license, license_url];
				return return_license;
				break;

			case 4:
				license     = 'CC BY';//'Attribution License'
				license_url = 'http://creativecommons.org/licenses/by/2.0/';
				var return_license =  [license, license_url];
				return return_license;
				break;

			case 5:
				license     = 'CC BY-SA';//'Attribution-ShareAlike License'
				license_url = 'http://creativecommons.org/licenses/by-sa/2.0/';
				var return_license =  [license, license_url];
				return return_license;
				break;

			case 6:
				license     = 'CC BY-ND';//'Attribution-NoDerivs License'
				license_url = 'http://creativecommons.org/licenses/by-nd/2.0/';
				var return_license =  [license, license_url];
				return return_license;
				break;

			case 7:
				license     = 'No known copyright restrictions';
				license_url = 'http://flickr.com/commons/usage/';
				var return_license =  [license, license_url];
				return return_license;
				break;

			case 8:
				license     = 'United States Government Work';
				license_url = 'http://www.usa.gov/copyright.shtml';
				var return_license =  [license, license_url];
				return return_license;
				break;

			case 9:
				license     = 'Public Domain Dedication (CC0)';
				license_url = 'https://creativecommons.org/publicdomain/zero/1.0/';
				var return_license =  [license, license_url];
				return return_license;
				break;

			case 10:
				license     = 'Public Domain Mark';
				license_url = 'https://creativecommons.org/publicdomain/mark/1.0/';
				var return_license =  [license, license_url];
				return return_license;
				break;

			default:
				license = '';
				license_url = '';
				var return_license =  [license, license_url];
				return return_license;
				break;
		}
	}



})( jQuery );
