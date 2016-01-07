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
			 	if ( ( href.match(/^http/) ) && ( href.indexOf(document.domain) === -1 ) && ( downloadTracked == false ) ) {
			    	// Add the tracking code
					a.click(function() {
						ga('send', 'event', 'Outbound Traffic', href.match(/:\/\/(.[^/]+)/)[1], href);
					});
				}
			});
		}
		// SLUT Google analytics

	});

})( jQuery );

//*** Funktion för att visa browser-warning om man har gammal webbläsare
// se exempel på versioner https://browser-update.org/#install om vi vill ändra dessa
// https://browser-update.org/customize.html har mer alternativ

function $buo_f(){
	var $buoop = {
		vs:{i:9,f:39,o:12.1,s:7,n:12,c:44}, // lägsta-nivå för webbläsare Behöver kanske uppdateras då och då
		// reminder:0, // hur ofta meddelandet ska visas. 0 visar det alltid. (24 betyder vänta 24 timmar & är standard)
		// reminderClosed:0, // standard 1 (168 h) vecka, visas först efter en vecka om man stängt meddelandet
		// test:false, // använd [ test:true ] om du vill se hur det ser ut fast du har en ny webbläsare
		// newwindow:true,
	};
	var $buo = function(op, test) {
	    var jsv = 18;
	    var n = window.navigator,
	        b;
	    this.op = op || {};
	    var langset = "sv";
	    // this.op.l = op.l || (n.languages ? n.languages[0] : null) || n.language || n.browserLanguage || n.userLanguage || document.documentElement.getAttribute("lang") || "en";
	    // this.op.l = this.op.l.replace("_", "-").toLowerCase();
	    var ll = "sv";
	    this.op.vsakt = {
	        i: 12,
	        f: 43,
	        o: 30,
	        s: 9,
	        n: 20,
	        c: 47
	    };
	    this.op.vsdefault = {
	        i: 9,
	        f: 39,
	        o: 12.1,
	        s: 6.1,
	        n: 12,
	        c: 44
	    };
	    this.op.vsmin = {
	        i: 8,
	        f: 5,
	        o: 12,
	        s: 5.1,
	        n: 12
	    };
	    // var myvs = op.vs || {};
	    this.op.vs = op.vs || this.op.vsdefault;
	    for (b in this.op.vsakt) {
	        if (this.op.vs[b] >= this.op.vsakt[b]) this.op.vs[b] = this.op.vsakt[b] - 0.2;
	        if (!this.op.vs[b]) this.op.vs[b] = this.op.vsdefault[b];
	        if (this.op.vs[b] < this.op.vsmin[b]) this.op.vs[b] = this.op.vsmin[b];
	    }
	    if (op.reminder < 0.1 || op.reminder === 0) this.op.reminder = 0;
	    else this.op.reminder = op.reminder || 24;
	    this.op.reminderClosed = op.reminderClosed || (24 * 7);

	    if (langset) this.op.url = op.url || "//browser-update.org/" + ll + "/update-browser.html#" + jsv + ":" + (location.hostname || "x");
	    else this.op.url = op.url || "//browser-update.org/update-browser.html#" + jsv + ":" + (location.hostname || "x");
	    // this.op.pageurl = op.pageurl || window.location.hostname || "unknown";
	    this.op.newwindow = (op.newwindow !== false);
	    this.op.test = test || op.test || false;
	    if (window.location.hash == "#test-bu") this.op.test = true;

	    function getBrowser(ua_str) {
	        var n, v, t, ua = ua_str || navigator.userAgent;
	        var names = {
	            i: 'Internet Explorer',
	            f: 'Firefox',
	            o: 'Opera',
	            s: 'Apple Safari',
	            n: 'Netscape Navigator',
	            c: "Chrome",
	            x: "Okänd webbläsare"
	        };
	        if (/bot|googlebot|facebook|slurp|wii|silk|blackberry|maxthon|maxton|mediapartners|dolfin|dolphin|adsbot|silk|android|phone|bingbot|google web preview|like firefox|chromeframe|seamonkey|opera mini|min|meego|netfront|moblin|maemo|arora|camino|flot|k-meleon|fennec|kazehakase|galeon|android|mobile|iphone|ipod|ipad|epiphany|konqueror|rekonq|symbian|webos|coolnovo|blackberry|bb10|RIM|PlayBook|PaleMoon|QupZilla|YaBrowser|Otter|Midori|qutebrowser/i.test(ua)) n = "x";
	        else if (/Trident.*rv:(\d+\.\d+)/i.test(ua)) n = "i";
	        else if (/Trident.(\d+\.\d+)/i.test(ua)) n = "io";
	        else if (/MSIE.(\d+\.\d+)/i.test(ua)) n = "i";
	        else if (/Edge.(\d+)/i.test(ua)) n = "i";
	        else if (/OPR.(\d+\.\d+)/i.test(ua)) n = "o";
	        else if (/Chrome.(\d+\.\d+)/i.test(ua)) n = "c";
	        else if (/Firefox.(\d+\.\d+)/i.test(ua)) n = "f";
	        else if (/Version.(\d+.\d+).{0,10}Safari/i.test(ua)) n = "s";
	        else if (/Safari.(\d+)/i.test(ua)) n = "so";
	        else if (/Opera.*Version.(\d+\.\d+)/i.test(ua)) n = "o";
	        else if (/Opera.(\d+\.?\d+)/i.test(ua)) n = "o";
	        else if (/Netscape.(\d+)/i.test(ua)) n = "n";
	        else return {
	            n: "x",
	            v: 0,
	            t: names[n]
	        };
	        var v = parseFloat(RegExp.$1);
	        var donotnotify = false;
	        if (/windows.nt.5.0|windows.nt.4.0|windows.98|os x 10.4|os x 10.5|os x 10.3|os x 10.2/.test(ua)) donotnotify = "oldOS";
	        if (n == "f" && (Math.round(v) == 24 || Math.round(v) == 31 || Math.round(v) == 38)) donotnotify = "ESR";
	        if (/linux|x11|unix|bsd/.test(ua) && n == "o" && v > 12) donotnotify = "Opera12Linux";
	        if (n == "x") return {
	            n: "x",
	            v: v || 0,
	            t: names[n],
	            donotnotify: donotnotify
	        };
	        if (n == "so") {
	            v = ((v < 100) && 1.0) || ((v < 130) && 1.2) || ((v < 320) && 1.3) || ((v < 520) && 2.0) || ((v < 524) && 3.0) || ((v < 526) && 3.2) || 4.0;
	            n = "s";
	        }
	        if (n == "i" && v == 7 && window.XDomainRequest) v = 8;
	        if (n == "io") {
	            n = "i";
	            if (v > 6) v = 11;
	            else if (v > 5) v = 10;
	            else if (v > 4) v = 9;
	            else if (v > 3.1) v = 8;
	            else if (v > 3) v = 7;
	            else v = 9;
	        }
	        return {
	            n: n,
	            v: v,
	            t: names[n] + " " + v,
	            donotnotify: donotnotify
	        };
	    }
	    this.op.browser = getBrowser();
	    var statbrowser = this.op.browser.t;
	    // förhindra javascripfel om vi inte har analytics (är inloggade t.ex)
	    if (typeof ga === 'function') {
		    this.op.onshow = op.onshow || function(stat) {ga('send', 'event', 'Outdated Browser', statbrowser, location.hostname);};
		    this.op.onclick = op.onclick || function(stat) {ga('send', 'event', 'Outdated Browser', statbrowser + ' - going for update', location.hostname);};
		    this.op.onclose = op.onclose || function(stat) {ga('send', 'event', 'Outdated Browser', statbrowser + ' - closing message', location.hostname);};
		} else {
			this.op.onshow = op.onshow || function(stat) {};
		    this.op.onclick = op.onclick || function(stat) {};
		    this.op.onclose = op.onclose || function(stat) {};
		}

	    if (!this.op.test && (!this.op.browser || !this.op.browser.n || this.op.browser.n == "x" || this.op.browser.donotnotify !== false || (document.cookie.indexOf("browserupdateorg=pause") > -1 && this.op.reminder > 0) || this.op.browser.v > this.op.vs[this.op.browser.n])) return;
	    // if (!this.op.test && Math.round(Math.random() * 5000) < 1) {
	    //     var i = new Image();
	    //     i.src = "//browser-update.org/viewcount.php?n=" + this.op.browser.n + "&v=" + this.op.browser.v + "&p=" + escape(this.op.pageurl) + "&jsv=" + jsv + "&inv=" + this.op.v + "&vs=" + myvs.i + "," + myvs.f + "," + myvs.o + "," + myvs.s;
	    // }

	    function setCookie(hours) {
	        var d = new Date(new Date().getTime() + 1000 * 3600 * hours);
	        document.cookie = 'browserupdateorg=pause; expires=' + d.toGMTString() + '; path=/';
	    }
	    if (this.op.reminder > 0) setCookie(this.op.reminder);
	    var languages = "xx,sv";
	    if (languages.indexOf(ll) > 0) this.op.url = "//browser-update.org/update.html#" + jsv + "@" + (location.hostname || "x");
	    var tar = "";
	    if (this.op.newwindow) tar = ' target="_blank"';

	    function busprintf() {
	        var args = arguments;
	        var data = args[0];
	        for (var k = 1; k < args.length; ++k) data = data.replace(/%s/, args[k]);
	        return data;
	    }
	    var t = 'This website would like to remind you: Your browser (%s) is <strong>out of date</strong>.         <a%s>Update your browser</a> for more security, comfort and the best experience on this site.';
	    if (ll == "sv") t = 'Vi vill göra dig uppmärksam på att <strong>din webbläsarversion</strong> (%s) <strong>är föråldrad</strong>. <a%s>Uppdatera din webbläsare</a> för bättre säkerhet och en roligare webb.';

	    if (op.text) t = op.text;
	    if (op["text_" + ll]) t = op["text_" + ll];
	    this.op.text = busprintf(t, this.op.browser.t, ' href="' + this.op.url + '"' + tar);
	    var div = document.createElement("div");
	    this.op.div = div;
	    div.id = "buorg";
	    div.className = "buorg";
	    div.innerHTML = '<div>' + this.op.text + '<div id="buorgclose">&times;</div></div>';
	    var sheet = document.createElement("style");
	    var style = ".buorg {position:absolute;z-index:111111;width:100%; top:0; left:0; background:#fff399 no-repeat 13px center url(//browser-update.org/img/small/" + this.op.browser.n + ".png);text-align:left; cursor:pointer; color:#000; font-size: 11px;}.buorg div { padding:5px 36px 5px 40px; } .buorg a,.buorg a:visited  {color: #3284bf; text-decoration: underline;}#buorgclose { position: absolute; right: 6px; top:0; height: 20px; width: 12px; font-weight: bold;font-size:18px; padding:0; }";
	    document.body.insertBefore(div, document.body.firstChild);
	    document.getElementsByTagName("head")[0].appendChild(sheet);
	    try {
	        sheet.innerText = style;
	        sheet.innerHTML = style;
	    } catch (e) {
	        try {
	            sheet.styleSheet.cssText = style;
	        } catch (e) {
	            return;
	        }
	    }
	    var me = this;
	    div.onclick = function() {
	        if (me.op.newwindow) window.open(me.op.url, "_blank");
	        else window.location.href = me.op.url;
	        setCookie(me.op.reminderClosed);
	        me.op.onclick(me.op);
	        return false;
	    };
	    try {
	        div.getElementsByTagName("a")[0].onclick = function(e) {
	            var e = e || window.event;
	            if (e.stopPropagation) e.stopPropagation();
	            else e.cancelBubble = true;
	            me.op.onclick(me.op);
	            return true;
	        };
	    } catch (e) {}
	    var hm = document.getElementsByTagName("html")[0] || document.body;
	    this.op.bodymt = hm.style.marginTop;
	    hm.style.marginTop = (div.clientHeight) + "px";
	    (function(me) {
	        document.getElementById("buorgclose").onclick = function(e) {
	            var e = e || window.event;
	            if (e.stopPropagation) e.stopPropagation();
	            else e.cancelBubble = true;
	            me.op.div.style.display = "none";
	            hm.style.marginTop = me.op.bodymt;
	            me.op.onclose(me.op);
	            setCookie(me.op.reminderClosed);
	            return true;
	        };
	    })(me);
	    op.onshow(this.op);
	};
	var $buoop = $buoop || {};
	$bu = $buo($buoop);

};
try {document.addEventListener("DOMContentLoaded", $buo_f,false)}
catch(e){window.attachEvent("onload", $buo_f)}

