IIS Pack
========

IIS Pack är ett generellt plugin för alla IIS-sajter - sådant som vi alltid behöver

# Om IIS Pack

Vårt generella plugin lägger till följande:

* FaceBook Open Graph taggar såsom og:image, og:title, og:description, fb:admins (om man har sådana), og:url, og:type (website & article), fb:appid (om sådan finns)
* Twitter Card av typen "summery_large_image"
* Google Analytics enligt vår standard
* Metafält för bilder/media

Som grund för IIS Pack används denna boilerplate:
https://github.com/DevinVinson/WordPress-Plugin-Boilerplate

Installation
============

* Placera `iis-pack` i `/wp-content/plugins/`
* Kontrollera att inga plugin gör samma saker som IIS Pack
* Kontrollera att temat inte gör samma saker som IIS Pack
* Kontrollera att wp_head() och wp_footer() samt body_class() finns i temat
* När ovan är gjort (plugins & tema-funktioner avaktiverade) - AKTIVERA IIS Pack
* Fyll i fälten under `Inställningar` -> `IIS Pack`


Changelog
=========

#### 2.0.1-2.1.4
* Remove password strength functions
* Make GTM ignore Onetrust
* Migrate to PHP 8.1
* Remove Grunt and all NPM packages (no CSS left to build and include)
* Remove protocol selection (http/https)

#### 2.0.0
* Removed fox

#### 1.6.3
* Fallback to site description on og:description
* Changed image license container to span

#### 1.6.2
* Fox menu: soi2016.se changed to svenskarnaochinternet.se
* Added settings for soi2017.se
* Deleted internetfonden from zonemaster (menu was to wide)

#### 1.6.1
* Mainly for Digitala Lektioner startpage - correction of og:url (querystrings)
* Mainly for Digitala Lektioner startpage - if no postid apply filters anyway

#### 1.6.0
* Support for adding javascript password strenght to frontend register forms
* Two parts, one check in the browser and one serverside (optional both)
* Explanations on how to implement in a site is in README inside folder /security/

#### 1.5.5
* Filter iis_og_title added

#### 1.5.4
* Fast social [fastsocial] shortcode was added to late in some cases

#### 1.5.2
* Google Anlytics: Changed from analyzing is_user_logged_in() -> current_user_can( 'edit_others_pages' )

#### 1.5.1
* Bugfix for validating password in frontend form (wp-login.php)

#### 1.5.0
* Added class Iis_Pack_Security that adds default password checking on wordpress backend user profiles.
* Iis_Pack_Security::is_strong_password( 'myPassToTest' ) could be used in IIS themes like this:
<code php>$args  = array(
    'container'       => 'ul',
    'container_class' => ‘my-ul-class’,
);
if ( ! Iis_Pack_Security::is_strong_password( 'PasswordAttTesta', $msg, $args ) ) {
    echo $msg;
}</code>
Prints as an example:
<code html>Lösenordet saknar tecken från en av dessa grupper<ul class="my-ul-class"><li>[ siffror (0-9) ]</li><li>[ specialtecken (!@#$%&*) ]</li></ul></code>

#### 1.4.9
* Added back callback functions that was removed some time ago and was causing errors
* Added goto.se to Fox menu

#### 1.4.8
* Added filters to be able to set og:image height and width (Helps FB show the image on the first share)

#### 1.4.7
* Plugins url in javascript is set with iispackDefs
* Local enviroment, no debug.log messages from fox menu on sites not yet ready

#### 1.4.6
* Getting data from Flickr is now done with javascript and gives users feedback

#### 1.4.5
* soi links to soi2016

#### 1.4.4
* www.soi2016.se added to fox (not actual meny, just site being able to show fox)

#### 1.4.3
* New Translations of texts by @rich_brat
* Pages (for example Sajtkollen) can modify og:title

#### 1.4.2
* Buggfix för FaceBook & Twitterboxar på Evenemang IND

#### 1.4.1
* Sanera dåliga filnamn

#### 1.4
* Tar bort interna pingbacks
* Publika funktionsnamn ändradr till iis-pack_xxx

#### 1.3.2
* Anpassningar för när man är inloggad på kurser.iis
* Städat bort gammal inline css som inte användes iaf (finns sedan länge ett stylesheet)

#### 1.3.1
* kurser.iis.se i foxmenyn

#### 1.3.0
* Förenklingar av beskrivningar, defaultvärde https Facebook Open Graph när man sparar inställningar
* Zonemaster deploy

#### 1.2.2
* post_type page har nu Utdrag / Excerpt tillagt om inte temat redan stödjer det

#### 1.2.1
* arkiv.internetmuseum.se
* datahotell.se

#### 1.1.1
* Bildattribution kan döljas på featured images, i de fall alternativ finns i temat

#### 1.1
* Lägger till möjlighet att ladda upp lokal avatar i Användarprofilen

#### 1.0.2
* Fast Social Share buttons

#### 1.0.1
* Metafält för bilder/media
* Visa inte FaceBook & Twitter Cards fält i redigera media

#### 1.0.0
* Första commiten
