(function($) {
	var fvar           = '.iispack-js-',
		$password      = $( fvar + 'field-password' ),
		$submitButton  = $( fvar + 'field-submit' ),
		$firstName     = $( fvar + 'field-firstname' ),
		$lastName      = $( fvar + 'field-lastname' ),
		$userName      = $( fvar + 'field-username' ),
		$email         = $( fvar + 'field-email' ),
		$strengthMeter = $( fvar + 'strength-meter' ),
		weakPassWordClass = 'iispack-js-weak-passw',
		$weakPasswordCheckbox = $( '<label><input type="checkbox" name="iispack_pw_weak" class="cb-iispack-js-weak-passw"/>' + iisPackJsPassw.useUnsecure + '</label>' )
		.attr( {
			'class': weakPassWordClass
		} );

		//If class is added to parent element (for example in ACF)
		if ( ! $password.is( 'input') ) {
			$password = $password.find( 'input' );
		}

	function checkPasswordStrength() {
		var pass1 = $password.val(),
			blacklistArray = blacklist(),
			strength;

		$strengthMeter.removeClass('iis-pack-short iis-pack-bad iis-pack-good iis-pack-strong');

		// Extend our blacklist array with those from the inputs & site data
		blacklistArray = blacklistArray.concat( wp.passwordStrength.userInputBlacklist() )

		// Get the password strength from WordPress function
		var strength = wp.passwordStrength.meter( pass1, blacklistArray, pass1 );
		blacklistArray.length = 0;
		$( '.' + weakPassWordClass ).remove();
		$submitButton.prop( 'disabled', true );
		// Add the strength meter results
		switch ( strength ) {

			case -1:
				$strengthMeter.addClass( 'iis-pack-bad' ).html( iisPackJsPassw.unknown );
				break;
			case 2:
				$strengthMeter.addClass('iis-pack-bad').html( iisPackJsPassw.bad );
				addWeakPasswordCheckbox();
				break;
			case 3:
				$strengthMeter.addClass('iis-pack-good').html( iisPackJsPassw.good );
				addWeakPasswordCheckbox();
				break;
			case 4:
				$strengthMeter.addClass('iis-pack-strong').html( iisPackJsPassw.strong );
				$submitButton.prop( 'disabled', false );
				break;
			case 5:
				$strengthMeter.addClass('iis-pack-short').html( iisPackJsPassw.mismatch );
				break;
			default:
				$strengthMeter.addClass('iis-pack-short').html( iisPackJsPassw['short'] );
		}
		return strength;
	}

	function getWordPressGeneratedPassword() {
		// If page lacks correct fields, avoid js-errors
		console.log( '$password.length',$password.length );
		if ( 0 < $password.length ) {
			// If password length set in IIS pack settings is shorter than 12 characters - at least
			// suggest a better password
			var passwordLength = iisPackJsPassw.pLength;
			if ( passwordLength < 12 ) {
				passwordLength = 12;
			}
			var data = {
						'iispack_action': 'getWordPressGeneratedPassword',
						'length': passwordLength,
						'special_chars' : '1',
						'extra_special_chars' : '0'
					};

			var posting = $.post('/', data );

			posting.done( function( data ) {
				var generatedPassw = data.randpassw;
				generatePassword( generatedPassw );
			});
		}
	}

	function generatePassword( generatedPassw ) {

		if ( typeof generatedPassw != 'undefined' ) {
			suggested_password = generatedPassw;
		}

		if ( typeof zxcvbn !== 'function' ) {
			setTimeout( generatePassword, 50 );
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
			inputFields = [ $firstName, $lastName, $userName, $email ];

		inputFieldsLength = inputFields.length;

		for ( i = 0; i < inputFieldsLength; i++ ) {
			currentField = inputFields[ i ];
			if ( typeof currentField[0] != 'undefined' ) {
				blacklistArray.push( currentField[0].defaultValue );
				blacklistArray.push( currentField.val() );
			}
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
		// But indivudual sites can have other demands (iisPackJsPassw.pLength)

		if ( '' === $password.val() || iisPackJsPassw.pLength > $password.val().length ) {
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
