<?php
/*
Copyright Ryan Hellyer

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA

*/

/**
 * Add browser warning for outdated browsers
 *
 * @link       https://www.iis.se
 * @since      2.0.0
 *
 * @package    Iis_Pack
 * @subpackage Iis_Pack/public/partials
 */

defined( 'WPINC' ) or die;

$message = __( 'We want to alert you that your browser is outdated. <a href="https://internetstiftelsen.se/uppdatera-din-webblasare/" target="_blank">Update your browser</a> for improved security and more fun on the web.', 'iis-pack' );

ob_start();

?>
<script>
	var supportsES6 = function () {
		try {
			new Function('(a = 0) => a');
			return true;
		} catch (err) {
			return false;
		}
	}();

	if (!supportsES6) {
		var warningMessage = '<p><?php echo $message; ?></p>';
		var warning = document.createElement('div');
		var site = document.getElementById('site');
		var namespace = 'iis-pack-browser-warning-';

		warning.innerHTML = warningMessage;
		warning.className = namespace + 'm-alert ' + namespace + 'm-alert--warning u-m-b-0';

		site.parentNode.insertBefore(warning, site);
	}
</script>
<?php echo ob_get_clean();
