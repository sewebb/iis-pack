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

$iis_alert_type = get_field( 'message_type', 'option' );
$iis_alert_text = get_field( 'message_text', 'option' );
$should_display_alert = ! empty( $iis_alert_text );

if ( $should_display_alert && have_rows('display_dates', 'option') ) {
    $should_display_alert = false;

    while( have_rows('display_dates', 'option') ) {
        the_row();

        $start_date = get_sub_field('start_date');
        $end_date = get_sub_field('end_date');
        $today = wp_date('Y-m-d H:i:s');

        if( $today >= $start_date && $today <= $end_date ) {
            $should_display_alert = true;
            break;
        }
    }
}

if ( $should_display_alert ) {
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
