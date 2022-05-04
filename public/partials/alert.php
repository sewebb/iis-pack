<?php
/**
 * Provide a global Alert Message
 *
 * @link       https://internetstiftelsen.se
 * @since      2.1.2
 *
 * @package    Iis_Pack
 * @subpackage Iis_Pack/public/partials
 */

defined( 'WPINC' ) || die;

$iis_alert_type = get_option( 'iis_pack_alert_type' );
$iis_alert_text = get_option( 'iis_pack_alert_text' );

if ( ! empty( $iis_alert_text ) ) {
	?>
	<div id="alert-1" role="alert" class="<?php imns( 'm-alert m-alert--' . $iis_alert_type . ' m-alert--dismissable' ); ?> u-m-b-0 js-dismiss-alert" aria-hidden="true">
		<button class="<?php imns('a-button a-button--icon a-button--standalone-icon a-button--icon'); ?>" data-a11y-toggle="alert-1">
			<span class="<?php imns('a-button__text'); ?>"><?php _e( 'Close', 'iis-pack' ); ?></span>
			<svg class="icon <?php imns('a-button__icon'); ?>">
				<use xlink:href="#icon-close"></use>
			</svg>
		</button>
		<?php echo $iis_alert_text; ?>
	</div>
	<?php
}
