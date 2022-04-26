<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @link       https://www.internetstiftelsen.se
 * @since      1.0.0
 *
 * @package    Iis_Pack
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

/**
 * Remove local images on uninstall
 *
 * @since 1.1
 */
function simple_local_avatars_uninstall() {
	$simple_local_avatars = new simple_local_avatars;
	$users = get_users();

	foreach ( $users as $user ) {
		$simple_local_avatars->avatar_delete( $user->user_id );
	}

	delete_option( 'simple_local_avatars_caps' );
}
