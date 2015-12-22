(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
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

	$(function() {
		// START Avsnitt för Google analytics
		var analyticsFileTypes = ['jpg','jpeg','gif','png','pdf','mp3','wav','zip','pps','ppt','xls','doc', 'pptx', 'xlsx', 'docx'];

		$('a').each(function() {
			var a = $(this);
			var href = a.attr('href');

			// Check if the a tag has a href, if not, stop for the current link
			if ( href == undefined || href =="")
				return;

			var url = href.replace('http://','').replace('https://','');
			var hrefArray = href.split('.').reverse();
			var extension = hrefArray[0].toLowerCase();
			var hrefArray = href.split('/').reverse();
			var domain = hrefArray[2];
			var downloadTracked = false;

			if (typeof analyticsFileTypes != "undefined") {
				// If the link is a download
				if ($.inArray(extension,analyticsFileTypes) != -1) {
					// Mark the link as already tracked
					downloadTracked = true;

					// Add the tracking code
					a.click(function() {
						ga('send', 'event', 'Downloads', extension.toUpperCase(), href);
						// console.log(extension.toUpperCase());
					});
				}
			}
			// If the link is external
		 	if ( ( href.match(/^http/) ) && ( !href.match(document.domain) ) && ( downloadTracked == false ) ) {
		    	// Add the tracking code
				a.click(function() {
					ga('send', 'event', 'Outbound Traffic', href.match(/:\/\/(.[^/]+)/)[1], href);
				});
			}
		});
		// SLUT Google analytics
	});

})( jQuery );
