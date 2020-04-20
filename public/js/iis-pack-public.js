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
		// förhindra javascripfel om vi inte har analytics (är inloggade t.ex)
	    if (typeof ga === 'function') {
			var analyticsFileTypes = ['jpg','jpeg','gif','png','pdf','mp3','wav','zip','pps','ppt','xls','doc', 'pptx', 'xlsx', 'docx'];

			$( document ).on( 'click', 'a', function() {
				var a = $(this),
					href = a.attr('href');

				// Check if the a tag has a href, if not, stop for the current link
				if ( href == undefined || href =="")
					return;

				var url = href.replace('http://','').replace('https://',''),
					hrefArray = href.split('.').reverse(),
					extension = hrefArray[0].toLowerCase(),
					hrefArray = href.split('/').reverse(),
					domain = hrefArray[2],
					downloadTracked = false;

				if (typeof analyticsFileTypes != "undefined") {
					// If the link is a download
					if ($.inArray(extension,analyticsFileTypes) != -1) {
						// Mark the link as already tracked
						downloadTracked = true;

						// Add the tracking code
						ga('send', 'event', 'Downloads', extension.toUpperCase(), href);
					}
				}

				// If the link is external
			 	if ( ( href.match(/^http/) ) && ( href.indexOf(document.domain) === -1 ) && ( downloadTracked == false ) ) {
			    	// Add the tracking code
					ga('send', 'event', 'Outbound Traffic', href.match(/:\/\/(.[^/]+)/)[1], href);
				}
			});
		}
		// SLUT Google analytics

		// Om det är mac eller windows
		if (navigator.userAgent.indexOf('Mac OS X') != -1) {
		  $("body").addClass("mac");
		} else {
		  $("body").addClass("pc");
		}
		// Edge browsers, InternetMuseum for now
		if (navigator.userAgent.indexOf('Chrome') != -1 || navigator.userAgent.indexOf('Safari') != -1) {
			$("body").addClass("chrome-safari");
		} else {
			$("body").addClass("not-cr-saf");
		}

		// START avsnitt for Fast Social Share
	    socialclick(this);
	    function socialclick() {
	        var that = this, // needed in click handler below
	            facebookclick = '.fss-share-facebook',
	            twitterclick = '.fss-share-twitter',
	            linkedinclick = '.fss-share-linkedin',
	            pinterestclick = '.fss-share-pinterest',
	            pagedescription = $('meta[property="og:description"]').attr("content"),
	            sitelang = $('html').attr('lang'),
	            twitterlang = sitelang,
	            pagetitle = $('meta[property="og:title"]').attr("content"),
	            pageurl = $(location).attr('href'),
	            facebook_appid = $(".fast-social-share").data("fbappid"), //$('meta[property="fb:app_id"]').attr("content"),
	            protocol = location.protocol,
	            domain = window.location.host,
	            facebookpicture = "",
	            facebookurl = "",
	            selectedimageexists = false,
	            selectedimage = getShareImage(),
	            hashtags = $(".fast-social-share").data("hashtags");


	        //special social meta propertys could be lacking
	        if ("" === pagetitle || undefined === pagetitle ) {
	            pagetitle = document.title;
	        }
	        // modify variables to suite our needs
	        if ("" === pagedescription || undefined === pagedescription) {
	            pagedescription = $('meta[name="description"]').attr("content");
	        }
	        if ("" === pagedescription || undefined === pagedescription) {
	            pagedescription = "-";
	        } else {
	            pagedescription = encodeURIComponent(pagedescription);
	        }

	        pagetitle = encodeURIComponent(pagetitle);
	        pageurl = pageurl.replace('vvv.', '');
	        pageurl = pageurl.replace('stage.', '');
	        pageurl = encodeURIComponent(pageurl);
	        //"Dubbelencodad" för spaces hos twitter
	        var replacespace = /%20/g;
			var twitterDoubleEncoded = pageurl.replace(replacespace, function clearRes(x){return '%2520';});

	         if ("" === twitterlang || undefined === twitterlang) {
	            twitterlang = "sv";
	            sitelang = "sv";
	        } else {
	            twitterlang = twitterlang.substr(0, 2);
	        }

	        function getShareImage() {
				var ogImage = $('meta[property="og:image"]').attr('content');
				if (undefined === ogImage || "" === ogImage) {
					return '';
				} else {
					return ogImage;
				}
			}

	        // check to see if we have an featured image or og:image
	        // ska inte inträffa på sajter med IIS Pack aktiverat eftersom og:image alltid läggs till
	        if ("" !== selectedimage && undefined !== selectedimage) {
	            facebookpicture = "&picture=" + selectedimage;
	            selectedimageexists = true;
	        } else {
	             facebookpicture = "";
	        }

	        function sendToAnanlytics(network,target) {
	        	if (typeof ga === 'function') {
		        	ga('send', 'social', {
						'socialNetwork': network,
						'socialAction': 'share',
						'socialTarget': pageurl
					})
		        }
	        }
	        // $(facebookclick).click(function (e) {
	        $(document).on('click', facebookclick, function(e) {
	            //if we don't have facebook_appid belonging to this site, we share without the app
	            if ("" !== facebook_appid && undefined !== facebook_appid) {
	                var redirect = iispackDefs.pluginsUrl + "assets/close-popup.html";
	                facebookurl = protocol + "//www.facebook.com/dialog/feed?app_id=" + facebook_appid + "&link=" + pageurl + "&name=" + pagetitle + "&description=" + pagedescription + "&display=popup&redirect_uri=" + redirect + facebookpicture;
	            } else {
	                facebookurl = protocol + "//www.facebook.com/sharer.php?u=" + pageurl;
	            }
	            popupwindow(facebookurl, 'Facebook', '580', '400');
	            sendToAnanlytics('facebook',pageurl);
	            return false;
	        });

	        // $(twitterclick).click(function (e) {
	        $(document).on('click', twitterclick, function(e) {
	           var twitterurl = protocol + "//twitter.com/intent/tweet?lang=" + twitterlang + "&text=" + pagetitle + "&url=" + twitterDoubleEncoded + "&hashtags=" + hashtags;
	            popupwindow(twitterurl, 'Twitter', '550', '260');
	            sendToAnanlytics('twitter',pageurl);
	            return false;
	        });

	        // $(linkedinclick).click(function (e) {
	        $(document).on('click', linkedinclick, function(e) {
	            var linkedinurl = protocol + "//www.linkedin.com/shareArticle?mini=true&url=" + pageurl +"&title=" + pagetitle;
	            popupwindow(linkedinurl, 'LinkedIn', '600', '600');
	            sendToAnanlytics('linkedin',pageurl);
	            return false;
	        });

	        //in case we don't have an image for Pinterest, it does not work. Then hide button
	        if (selectedimageexists) {
	            var pinteresturl = protocol + "//pinterest.com/pin/create/button/?url=" + pageurl + "&media=" + selectedimage + "&description=" + pagedescription;
	            // $(pinterestclick).on('click', function (e) {
	            $(document).on('click', pinterestclick, function(e) {
	                popupwindow(pinteresturl, 'Pinterest', '750', '600');
	                sendToAnanlytics('pinterest',pageurl);
	            });
	        } else {
	              $(pinterestclick).css("display", "none");
	        }
	        function popupwindow(url, title, w, h) {
	          var left = (screen.width/2)-(w/2) + FindLeftWindowBoundry(),
	                top = (screen.height/2)-(h/2) + FindTopWindowBoundry();
	          return window.open(url, title, 'scrollbars=yes, resizable=yes, width='+w+', height='+h+', top='+top+', left='+left+'');
	        }
	        // Find Left Boundry of current Window
	        function FindLeftWindowBoundry() {
	            // In Internet Explorer window.screenLeft is the window's left boundry
	            if (window.screenLeft) {
	                return window.screenLeft;
	            }
	            // In Firefox window.screenX is the window's left boundry
	            if (window.screenX)
	                return window.screenX;

	            return 0;
	        }
	        // Find Left Boundry of current Window
	        function FindTopWindowBoundry() {
	            // In Internet Explorer window.screenLeft is the window's left boundry
	            if (window.screenTop) {
	                return window.screenTop;
	            }

	            // In Firefox window.screenY is the window's left boundry
	            if (window.screenY)
	                return window.screenY;
	            return 0;
	        }
	    }
	    // Funktion för att kunna hantera ajaxhämtade sidor samt #hashurls (kunskapsportalen t.ex.)
	    function hashHandler(){
		    this.oldHash = window.location.hash;
		    this.oldHref = window.location.href;
		    this.Check;

		    var that = this;
		    var detect = function(){
		        if ( that.oldHash != window.location.hash || that.oldHref != window.location.href ){

		            that.oldHash = window.location.hash;
		            that.oldHref = window.location.href;
		            socialclick(this);
		        }
		    };
		    this.Check = setInterval(function(){ detect() }, 100);
		}

		var hashDetection = new hashHandler();
		// SLUT Fast Social Share

	});



})( jQuery );



var supportsES6 = function () {
	try {
		new Function('(a = 0) => a');
		return true;
	} catch (err) {
		return false;
	}
};

window.browserTest = window.browserTest || supportsES6;

function addBrowserWarning() {
	if (!window.browserTest()) {
		var warningMessage = '<div>Vi vill göra dig uppmärksam på att <strong>din webbläsarversion</strong> <strong>är föråldrad</strong>. <a href="https://internetstiftelsen.se/uppdatera-din-webblasare/" target="_blank">Uppdatera din webbläsare</a> för bättre säkerhet och en roligare webb.</div>';
		var warning = document.createElement('div');

		warning.innerHTML = warningMessage;
		warning.className = 'buorg';

		document.body.insertBefore(warning, document.body.firstChild);
	}
}

try {document.addEventListener("DOMContentLoaded", addBrowserWarning,false)}
catch(e){window.attachEvent("onload", addBrowserWarning)}

