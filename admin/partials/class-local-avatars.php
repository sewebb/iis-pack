<?php
/**
 * Lägger till möjlighet att ladda upp lokala avatarer
 *
 * @since      1.1
 *
 * @package    Iis_Pack
 * @subpackage Iis_Pack/partials
 */

/**
 * Calls the class
 */
function call_simple_local_avatars() {
	new LocalAvatars;
}

/**
 * Add field to user profiles
 */
class LocalAvatars {
	/**
	 * [simple_local_avatars description]
	 */

	public function __construct() {
		add_filter( 'get_avatar', array( $this, 'get_avatar' ), 10, 6 );

		add_action( 'show_user_profile', array( $this, 'edit_user_profile' ) );
		add_action( 'edit_user_profile', array( $this, 'edit_user_profile' ) );

		add_action( 'personal_options_update', array( $this, 'edit_user_profile_update' ) );
		add_action( 'edit_user_profile_update', array( $this, 'edit_user_profile_update' ) );

		add_filter( 'avatar_defaults', array( $this, 'avatar_defaults' ) );
	}

	/**
	 * [get_avatar description]
	 * @param  string  $avatar      [description]
	 * @param  [type]  $id_or_email [description]
	 * @param  string  $size        [description]
	 * @param  string  $default     [description]
	 * @param  boolean $alt         [description]
	 * @return [type]  $avatar;     [description]
	 */
	public function get_avatar( $avatar = '', $id_or_email, $size = '96', $default = '', $alt = false, $args = null ) {
		if ( is_numeric( $id_or_email ) ) {
			$user_id = (int) $id_or_email;
		} elseif ( is_string( $id_or_email ) ) {
			if ( $user = get_user_by_email( $id_or_email ) ) {
				$user_id = $user->ID;
			}
		} elseif ( is_object( $id_or_email ) && ! empty( $id_or_email->user_id ) ) {
			$user_id = (int) $id_or_email->user_id;
		}

		if ( ! empty( $user_id ) ) {
			$simple_local_avatars = get_user_meta( $user_id, 'simple_local_avatar', true );
		}

		if ( ! isset( $simple_local_avatars ) || empty( $simple_local_avatars ) || ! isset( $simple_local_avatars['full'] ) ) {
			if ( ! empty( $avatar ) ) {
				// if called by filter
				if ( $this->user_has_gravatar( $id_or_email ) ) {
					return $avatar;
				} else {
					return '';
				}
			}

			remove_filter( 'get_avatar', 'get_simple_local_avatar' );
			$avatar = get_avatar( $id_or_email, $size, $default );
			add_filter( 'get_avatar', 'get_simple_local_avatar', 10, 5 );
			return $avatar;
		}

		// ensure valid size
		if ( ! is_numeric( $size ) ) {
			$size = '96';
		}

		if ( empty( $alt ) ) {
			$alt = get_the_author_meta( 'display_name', $user_id );
		}

		// generate a new size
		if ( empty( $simple_local_avatars[ $size ] ) ) {
			$upload_path = wp_upload_dir();
			$avatar_full_path = str_replace( $upload_path['baseurl'], $upload_path['basedir'], $simple_local_avatars['full'] );
			$image_sized = image_resize( $avatar_full_path, $size, $size, true );

			if ( is_wp_error( $image_sized ) ) {
				$simple_local_avatars[ $size ] = $simple_local_avatars['full'];
			} else {
				$simple_local_avatars[ $size ] = str_replace( $upload_path['basedir'], $upload_path['baseurl'], $image_sized );
			}

			update_user_meta( $user_id, 'simple_local_avatar', $simple_local_avatars );
		} elseif ( substr( $simple_local_avatars[ $size ], 0, 4 ) != 'http' ) {
			$simple_local_avatars[ $size ] = home_url( $simple_local_avatars[ $size ] );
		}

		$author_class = is_author( $user_id ) ? ' current-author' : '';
		$extra_class  = $args['class'];
		$avatar       = '<img alt="' . esc_attr( $alt ) . '" src="' . $simple_local_avatars[ $size ] . '" class="avatar avatar-' . $size . ' ' . $author_class . ' photo ' . $extra_class . '" height="' . $size . '" width="' . $size . '" />';

		return $avatar;
	}

	/**
	 * [edit_user_profile description]
	 * @param  [type] $profileuser [description]
	 */
	public function edit_user_profile( $profileuser ) {
	?>
		<h3><?php _e( 'Locale Profile Picture.  Replaces your Gravatar picture ONLY FOR THIS SITE.','iis-pack' ); ?></h3>

		<table class="form-table">
			<tr>
				<th><label for="simple-local-avatar"><?php _e( 'Upload profile picture','iis-pack' ); ?></label></th>
				<td style="width: 50px;" valign="top">
					<?php echo get_avatar( $profileuser->ID ); ?>
				</td>
				<td>
				<?php
					$options = get_option( 'iis_pack_simple_local_avatars_caps' );

					if ( empty( $options['iis_pack_simple_local_avatars_caps'] ) || current_user_can( 'upload_files' ) ) {
						do_action( 'simple_local_avatar_notices' );
						wp_nonce_field( 'simple_local_avatar_nonce', '_simple_local_avatar_nonce', false );
				?>
						<input type="file" name="simple-local-avatar" id="simple-local-avatar" /><br />
				<?php
						if ( empty( $profileuser->simple_local_avatar ) ) {
							echo '<span class="description">' . __( 'No local profile picture is set. Use the upload field to add a local avatar for this site.','iis-pack' ) . '</span>';
						} else {
							echo '
								<input type="checkbox" name="simple-local-avatar-erase" value="1" /> ' . __( 'Delete local profile picture','iis-pack' ) . '<br />
								<span class="description">' . __( 'Replace the local profile picture by uploading a new image, or erase the local profile picture (falling back to a Gravatar) by checking the delete option.','iis-pack' ) . '</span>
							';
						}
					} else {
						if ( empty( $profileuser->simple_local_avatar ) ) {
							echo '<span class="description">' . __( 'No local avatar is set. Set up your avatar at Gravatar.com.','iis-pack' ) . '</span>';
						} else {
							echo '
								<span class="description">' . __( 'You do not have media management permissions. To change your local profile picture, contact the blog administrator.','iis-pack' ) . '</span>
							';
						}
					}
				?>
				</td>
			</tr>
		</table>

		<script type="text/javascript">
			var form = document.getElementById('your-profile');
			form.encoding = 'multipart/form-data';
			form.setAttribute('enctype', 'multipart/form-data');
		</script>
	<?php

	}

	/**
	 * [edit_user_profile_update description]
	 * @param  [type] $user_id [description]
	 * @return [type]          [description]
	 */
	public function edit_user_profile_update( $user_id ) {
		//security
		if ( ! wp_verify_nonce( $_POST['_simple_local_avatar_nonce'], 'simple_local_avatar_nonce' ) ) {
			return;
		}

		if ( ! empty( $_FILES['simple-local-avatar']['name'] ) ) {
			$mimes = array(
				'jpg|jpeg|jpe' => 'image/jpeg',
				'gif'          => 'image/gif',
				'png'          => 'image/png',
			);

			$avatar = wp_handle_upload( $_FILES['simple-local-avatar'], array( 'mimes' => $mimes, 'test_form' => false ) );
			// handle failures
			if ( empty( $avatar['file'] ) ) {
				switch ( $avatar['error'] ) {
					case 'File type does not meet security guidelines. Try another.' :
						add_action( 'user_profile_update_errors', create_function( '$a','$a->add("avatar_error",__("Please upload a valid image file for the Profile Picture.","iis-pack"));' ) );
						break;
					default :
						add_action( 'user_profile_update_errors', create_function( '$a','$a->add("avatar_error","<strong>".__("There was an error uploading the Profile Picture:","iis-pack")."</strong> ' . esc_attr( $avatar['error'] ) . '");' ) );
				}

				return;
			}
			// delete old images if successful
			$this->avatar_delete( $user_id );
			// save user information (overwriting old)
			update_user_meta( $user_id, 'simple_local_avatar', array( 'full' => $avatar['url'] ) );
		} elseif ( isset( $_POST['simple-local-avatar-erase'] ) && 1 == $_POST['simple-local-avatar-erase'] ) {
			$this->avatar_delete( $user_id );
		}
	}

	/**
	 *  Remove the custom get_avatar hook for the default avatar list output on options-discussion.php
	 * @param  [type] $avatar_defaults [description]
	 * @return [type]                  [description]
	 */
	public function avatar_defaults( $avatar_defaults ) {
		remove_action( 'get_avatar', array( $this, 'get_avatar' ) );
		return $avatar_defaults;
	}

	/**
	 * Delete avatars based on user_id
	 * @param  [type] $user_id [description]
	 */
	public function avatar_delete( $user_id ) {
		$old_avatars = get_user_meta( $user_id, 'simple_local_avatar', true );

		delete_user_meta( $user_id, 'simple_local_avatar' );
	}

	public function user_has_gravatar($id_or_email) {
		$email = '';
		if ( is_numeric( $id_or_email ) ) {
			$id = (int) $id_or_email;
			$user = get_userdata( $id );
			if ( $user )
				$email = $user->user_email;
		} elseif ( is_object( $id_or_email ) ) {
			// No avatar for pingbacks or trackbacks
			$allowed_comment_types = apply_filters( 'get_avatar_comment_types', array( 'comment' ) );
			if ( ! empty( $id_or_email->comment_type ) && ! in_array( $id_or_email->comment_type, (array) $allowed_comment_types ) )
				return false;

			if ( ! empty( $id_or_email->user_id ) ) {
				$id = (int) $id_or_email->user_id;
				$user = get_userdata( $id );
				if ( $user)
					$email = $user->user_email;
			} elseif ( ! empty( $id_or_email->comment_author_email ) ) {
				$email = $id_or_email->comment_author_email;
			}
		} else {
			$email = $id_or_email;
		}

		$hashkey = md5( strtolower( trim( $email ) ) );
		$uri = 'http://www.gravatar.com/avatar/' . $hashkey . '?d=404';

		$data = wp_cache_get( $hashkey );
		if ( false === $data ) {
			$response = wp_remote_head( $uri );
			if ( is_wp_error( $response ) ) {
				$data = 'not200';
			} else {
				$data = $response['response']['code'];
			}
			wp_cache_set( $hashkey, $data, $group = '', $expire = 60 * 5 );

		}
		if ( $data == '200' ) {
			return true;
		} else {
			return false;
		}
	}
}

if ( ! function_exists( 'get_simple_local_avatar' ) ) {
	/**
	 * More efficient to call simple local avatar directly in theme and avoid gravatar setup
	 *
	 * @param int|string|object $id_or_email A user ID,  email address, or comment object
	 * @param int               $size Size of the avatar image
	 * @param string            $default URL to a default image to use if no avatar is available
	 * @param string            $alt Alternate text to use in image tag. Defaults to blank
	 * @return string <img> tag for the user's avatar
	 */
	function get_simple_local_avatar( $id_or_email, $size = '96', $default = '', $alt = false ) {
		global $simple_local_avatars;
		return $simple_local_avatars->get_avatar( '', $id_or_email, $size, $default, $alt );
	}
}


