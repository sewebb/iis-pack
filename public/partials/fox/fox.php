<?php
/**
 * Inkludera fox i vårt IIS Pack
 * Baserat på om option är vald
 *
 * @link       https://www.iis.se
 * @since      1.0.0
 *
 * @package    Iis_Pack
 * @subpackage Iis_Pack/public/partials/fox
 */

$show_fox_menu = get_option( 'iis_pack_show_fox_menu' );

if ( 'true' === $show_fox_menu ) {
	require_once( plugin_dir_path( __FILE__ ) . 'classes/class-se-plugin-base.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'classes/class-se-fox.php' );
	Se_Fox::Init();
}

