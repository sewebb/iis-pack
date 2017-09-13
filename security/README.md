IIS Pack - Security
========
Settings
========
`/wp-admin/options-general.php?page=iis-pack`
### Specify if password strength check should be used on your site _(default false)_
* If the site has other demands on password length then default 12 characters - add the number of characters
* Add page template / posttype specification if logged in users should use the script (for example password change pages)

Files
=====
* `/public/assets/js/iis-pack-passw-strength-meter.js`
* `/public/security/class-iis-pack-security.php`

Javascript file contains and uses a copy of WP `/wp-admin/js/password-strength-meter.js` and also our own code. For example code for checking field values, se below how to define fields in your registration form.

# Set up your frontend form with theese classes
* PASSWORD FIELD ==> .iispack-js-field-password
* SUBMIT BUTTON ==> .iispack-js-field-submit
* AREA FOR STRENGTH METER ==> .iispack-js-strength-meter

### Input fields to check (password should not use theese values)
* FIRST NAME FIELD ==> .iispack-js-field-firstname
* LAST NAME  FIELD ==> .iispack-js-field-lastname
* USERNAME  FIELD ==> .iispack-js-field-username
* EMAIL  FIELD ==> .iispack-js-field-email
 
# Class IIS_Pack_Security 
* Creates random wp-password in password field from a ajax-request
* IIS special blacklist 
* Servercheck of provided user password.

## Class IIS_Pack_Public
* Enques scripts, including WP `/wp-includes/js/zxcvbn-async.js` 



# Check that provided password is good enough for IIS (serverside)
<code>
    $args  = array(
        'container'       => 'ul', // If returned complexity descriptions needs special container
        'container_class' => 'my-ul-class', // well...
        'sec_level'       => 'iis_default', // This is default if left out. Note: You could provide site specific demands by adding 'sec_level' and update this plugin class-iis-pack-security.php
    );
    if ( ! Iis_Pack_Security::is_strong_password( $password, $msg, $args ) {
        // The password is not good enough
    } else {
        // Function returns true - good enough password according to IIS rules
    }
</code>


Changelog
=========

#### 1.6.0
* First version with frontend js
* Modified backend check with settings for number of characters
