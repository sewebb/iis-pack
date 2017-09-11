(function($) {
	var fvar           = '.iispack-js-',
		$password      = $( fvar + 'field-password' ),
		$submitButton  = $( fvar + 'field-submit' ),
		$strengthMeter = $( fvar + 'strength-meter' ),
		weakPassWordClass = 'iispack-js-weak-passw',
		$weakPasswordCheckbox = $( '<label><input type="checkbox" name="iispack_pw_weak" class="cb-iispack-js-weak-passw"/>Använd osäkert lösenord</label>' )
		.attr( {
			'class': weakPassWordClass
		} );

	function checkPasswordStrength() {
		var pass1 = $password.val(),
			blacklistArray = blacklist(),
			strength;

		$strengthMeter.removeClass('short bad good strong');

		// Extend our blacklist array with those from the inputs & site data
		blacklistArray = blacklistArray.concat( wp.passwordStrength.userInputBlacklist() )
		// console.log( 'blacklistArray',blacklistArray );
		// Get the password strength from WordPress function
		var strength = wp.passwordStrength.meter( pass1, blacklistArray, pass1 );
		blacklistArray.length = 0;
		$( '.' + weakPassWordClass ).remove();
		$submitButton.prop( 'disabled', true );
		// Add the strength meter results
		switch ( strength ) {

			case -1:
				$strengthMeter.addClass( 'bad' ).html( iisPackJsPassw.unknown );
				break;
			case 2:
				$strengthMeter.addClass('bad').html( iisPackJsPassw.bad );
				addWeakPasswordCheckbox();
				break;
			case 3:
				$strengthMeter.addClass('good').html( iisPackJsPassw.good );
				addWeakPasswordCheckbox();
				break;
			case 4:
				$strengthMeter.addClass('strong').html( iisPackJsPassw.strong );
				$submitButton.prop( 'disabled', false );
				break;
			case 5:
				$strengthMeter.addClass('short').html( iisPackJsPassw.mismatch );
				break;
			default:
				$strengthMeter.addClass('short').html( iisPackJsPassw['short'] );
		}
		return strength;
	}

	function getWordPressGeneratedPassword() {

		var data = {
					'iispack_action': 'getWordPressGeneratedPassword',
					'length': 12,
					'special_chars' : '1',
					'extra_special_chars' : '0'
				};

		var posting = $.post('/', data );

		posting.done( function( data ) {
			var generatedPassw = data.randpassw;
			generatePassword( generatedPassw );
		});
	}

	function generatePassword( generatedPassw ) {
		if ( typeof generatedPassw != 'undefined' ) {
			suggested_password = generatedPassw;
		}
		if ( typeof zxcvbn !== 'function' ) {
			setTimeout( generatePassword, 100 );
			return;
		} else if ( ! $password.val() ) {
			// zxcvbn loaded before user entered password.
			$password.val( suggested_password );
			checkPasswordStrength();
		}
		else {
			// zxcvbn loaded after the user entered password, check strength.
			checkPasswordStrength();
		}

	}

	function blacklist() {
		var i, inputFieldsLength, blacklistArrayLength, currentField,
			blacklist      = [],
			blacklistArray = iisPackJsPassw.blacklist,
			inputFields = [ $( fvar + 'field-firstname' ), $( fvar + 'field-lastname' ), $( fvar + 'field-username' ), $( fvar + 'field-email' ) ];

		inputFieldsLength = inputFields.length;
		for ( i = 0; i < inputFieldsLength; i++ ) {
			currentField = inputFields[ i ];

			blacklistArray.push( currentField[0].defaultValue );
			blacklistArray.push( currentField.val() );

		}

		// Strip out non-alphanumeric characters and convert each word to an individual entry
		blacklistArrayLength = blacklistArray.length;
		for ( i = 0; i < blacklistArrayLength; i++ ) {
			if ( blacklistArray[ i ] ) {
				blacklist = blacklist.concat( blacklistArray[ i ].replace( /\W/g, ' ' ).split( ' ' ) );
			}
		}

		// Remove empty values, short words, and duplicates. Short words are likely to cause many false positives.
		blacklist = $.grep( blacklist, function( value, key ) {
			if ( '' === value || 4 > value.length ) {
				return false;
			}

			return $.inArray( value, blacklist ) === key;
		});

		return blacklist;
	}

	function addWeakPasswordCheckbox() {
		// IIS rules dictates at least 12 characters in password
		if ( '' === $password.val() || 12 > $password.val().length ) {
			// $submitButton.prop( 'disabled', true );
			return false;
		}
		$strengthMeter.after( $weakPasswordCheckbox );
	}


	$( document ).on({
		'click': function () {
			if ( ! $( '.' + weakPassWordClass + ' input:checkbox' ).prop( 'checked' ) ) {
				$submitButton.prop( 'disabled', true );
			} else {
				$submitButton.prop( 'disabled', false );
			}
		}
	}, '.' + weakPassWordClass );


	// $( document ).on({
	// 	'input': function () {
	// 		checkPasswordStrength();
	// 	}
	// }, fvar + 'field-username' )

	$( document ).on({
		'input': function () {
			checkPasswordStrength();
		}
	}, fvar + 'field-password' )


	$( document ).ready( function() {
		getWordPressGeneratedPassword();
	});

})(jQuery);


///  COPIED FROM /wp-admin/js/password-strenght-meter.js
///  because not all sites has frontend access to /wp-admin/
/* global zxcvbn */
window.wp = window.wp || {};

var passwordStrength;
(function($){
	wp.passwordStrength = {
		/**
		 * Determine the strength of a given password
		 *
		 * @param string password1 The password
		 * @param array blacklist An array of words that will lower the entropy of the password
		 * @param string password2 The confirmed password
		 */
		meter : function( password1, blacklist, password2 ) {
			if ( ! $.isArray( blacklist ) )
				blacklist = [ blacklist.toString() ];

			if (password1 != password2 && password2 && password2.length > 0)
				return 5;

			if ( 'undefined' === typeof window.zxcvbn ) {
				// Password strength unknown.
				return -1;
			}

			var result = zxcvbn( password1, blacklist );
			return result.score;
		},

		/**
		 * Builds an array of data that should be penalized, because it would lower the entropy of a password if it were used
		 *
		 * @return array The array of data to be blacklisted
		 */
		userInputBlacklist : function() {
			var i, userInputFieldsLength, rawValuesLength, currentField,
				rawValues       = [],
				blacklist       = [],
				userInputFields = [ 'user_login', 'first_name', 'last_name', 'nickname', 'display_name', 'email', 'url', 'description', 'weblog_title', 'admin_email' ];

			// Collect all the strings we want to blacklist
			rawValues.push( document.title );
			rawValues.push( document.URL );

			userInputFieldsLength = userInputFields.length;
			for ( i = 0; i < userInputFieldsLength; i++ ) {
				currentField = $( '#' + userInputFields[ i ] );

				if ( 0 === currentField.length ) {
					continue;
				}

				rawValues.push( currentField[0].defaultValue );
				rawValues.push( currentField.val() );
			}

			// Strip out non-alphanumeric characters and convert each word to an individual entry
			rawValuesLength = rawValues.length;
			for ( i = 0; i < rawValuesLength; i++ ) {
				if ( rawValues[ i ] ) {
					blacklist = blacklist.concat( rawValues[ i ].replace( /\W/g, ' ' ).split( ' ' ) );
				}
			}

			// Remove empty values, short words, and duplicates. Short words are likely to cause many false positives.
			blacklist = $.grep( blacklist, function( value, key ) {
				if ( '' === value || 4 > value.length ) {
					return false;
				}

				return $.inArray( value, blacklist ) === key;
			});

			return blacklist;
		}
	};

	// Back-compat.
	passwordStrength = wp.passwordStrength.meter;
})(jQuery);
