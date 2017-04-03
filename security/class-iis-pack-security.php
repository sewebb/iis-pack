<?php
/**
 * Security related stuff
 *
 * @package Iis_Pack_Security
 * @since      1.5.0
 *
 */

/**
 * Adopted from Ws_security webbstjarnan
 */
class Iis_Pack_Security {
	/**
	 * Instance
	 *
	 * @var null
	 */
	protected static $instance = null;

	/**
	 * Get current instance
	 *
	 * @return Iis_Pack_Security instance
	 */
	public static function get_instance() {
		null === self::$instance and self::$instance = new self;

		return self::$instance;
	}

	/**
	 * Setup class
	 */
	public function setup() {
		add_action( 'user_profile_update_errors', array( $this, 'validate_profile_update' ), 10, 3 );
		add_filter( 'registration_errors', array( $this, 'validate_registration' ), 10, 3 );
		add_action( 'validate_password_reset', array( $this, 'validate_password_reset' ), 10, 2 );
	}

	/**
	 * Validate profile update
	 *
	 * @author  Jonas Nordström <jonas.nordstrom@gmail.com>
	 * @param   WP_Error $errors Error object
	 * @param   boolean  $update Whether this is a user update
	 * @param   object   $user   raw user object not a WP_User
	 */
	public function validate_profile_update( WP_Error &$errors, $update, &$user ) {
		return $this->validate_complex_password( $errors );
	}

	/**
	 * Validate registration
	 *
	 * @author  Jonas Nordström <jonas.nordstrom@gmail.com>
	 * @param   WP_Error $errors Error object
	 * @param   string   $sanitized_user_login User login
	 * @param   string   $user_email User email
	 * @return  WP_Error
	 */
	public function validate_registration( WP_Error &$errors, $sanitized_user_login, $user_email ) {
		return $this->validate_complex_password( $errors );
	}

	/**
	 * Validate password reset
	 *
	 * @author  Jonas Nordström <jonas.nordstrom@gmail.com>
	 * @param   WP_Error $errors Error object
	 * @param   stdClass $userData User data
	 * @since   1.5.1 Bugfix for WP_Error &$errors --> WP_Error $errors
	 * @return  WP_Error
	 */
	public function validate_password_reset( WP_Error $errors, $userData ) {
		return $this->validate_complex_password( $errors );
	}

	/**
	 * Validate complex password
	 *
	 * @author  Jonas Nordström <jonas.nordstrom@gmail.com>
	 * @param   WP_Error $errors Errors
	 * @return  WP_Error
	 */
	public function validate_complex_password( $errors ) {
		$input_password = esc_html( $_POST['pass1'] );
		$password       = ( isset( $input_password ) && trim( $input_password ) ) ? $input_password : null;

		// no password or already has password error
		if ( empty( $password ) || ( $errors->get_error_data( 'pass' ) ) ) {
			return $errors;
		}

		$args = array(
					'container' => 'ul',
		);
		// validate
		if ( ! self::is_strong_password( $password, $msg, $args ) ) {
			$errors->add( 'pass', sprintf( '<strong>ERROR</strong>: %s', $msg ) );
		}

		return $errors;
	}

	/**
	 * Test if password is strong
	 *
	 * @author  Jonas Nordström <jonas.nordstrom@gmail.com>
	 * @param   string $password Password
	 * @param   string $msg      Error message
	 * @param   array  $args     If we want formatting of messages returned (or in future something else)
	 * @return  boolean
	 */
	public static function is_strong_password( $password, &$msg, $args = array() ) {
		/* Lösenord måste vara minst nio tecken långa, ingen maxlängd.
		 * Lösenord måste innehålla tecken från minst tre av följande grupper:
		 * Stora bokstäver, små bokstäver, siffror eller specialtecken (!@#$%&*)
		 */
		$defaults = array(
						'container'       => '',
						'container_class' => '',
		);
		$args     = wp_parse_args( $args, $defaults );

		if ( mb_strlen( $password ) < 9 ) {
			$msg = 'Lösenordet måste vara minst nio tecken långt';
			return false;
		}

		$lower_case = false;
		$upper_case = false;
		$numbers    = false;
		$special_ch = false;
		$complexity = 0;

		if ( preg_match( '/[a-z]+/', $password ) ) {
			$complexity++;
			$lower_case = true;
		}
		if ( preg_match( '/[A-Z]+/', $password ) ) {
			$complexity++;
			$upper_case = true;
		}
		if ( preg_match( '/[0-9]+/', $password ) ) {
			$complexity++;
			$numbers    = true;
		}
		if ( preg_match( '/[!@#$%&*]+/', $password ) ) {
			$complexity++;
			$special_ch = true;
		}

		switch ( $complexity ) {
			case 1:
				$info = 'två av dessa grupper';
				break;
			case 2:
				$info = 'en av dessa grupper';
				break;
		}

		if ( $complexity < 3 ) {

			$show_container = false;
			$msg_container  = ': ';
			$sub_container  = 'span';
			if ( $args['container'] ) {
				/**
				 * Overkill - Filters the list of HTML tags that are valid for use as message containers.
				 *
				 * @since 1.5.0
				 *
				 * @param array $tags The acceptable HTML tags for use as message containers.
				 *                    Default is array containing just 'ul'.
				 */
				$allowed_tags = apply_filters( 'iis_pack_password_security_message', array( 'ul' ) );

				if ( is_string( $args['container'] ) && in_array( $args['container'], $allowed_tags ) ) {
					$show_container = true;
					$class          = $args['container_class'] ? ' class="' . esc_attr( $args['container_class'] ) . '"' : '';

					$msg_container  = '<' . $args['container'] . $class . '>';
					// Hardcoded, would we ever need something else then ul->li ?
					$sub_container  = 'li';
				}
			}

			$sub_message = 'Lösenordet saknar tecken från ' . $info . $msg_container;
			$el          = $sub_container;
			if ( ! $lower_case ) {
				$sub_message .= '<' . $el . '>[ små bokstäver ]</' . $el . '>';
			}
			if ( ! $upper_case ) {
				$sub_message .= '<' . $el . '>[ Stora bokstäver ]</' . $el . '>';
			}
			if ( ! $numbers ) {
				$sub_message .= '<' . $el . '>[ siffror (0-9) ]</' . $el . '>';
			}
			if ( ! $special_ch ) {
				$sub_message .= '<' . $el . '>[ specialtecken (!@#$%&*) ]</' . $el . '>';
			}

			if ( $show_container ) {
				$sub_message .= '</' . $args['container'] . '>';
			}

			$msg = $sub_message;

			return false;
		} // End if().

		return true;
	}
}

add_action( 'init', array( Iis_Pack_Security::get_instance(), 'setup' ) );
