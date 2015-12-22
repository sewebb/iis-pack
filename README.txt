=== IIS Pack ===
Contributors: (this should be a list of wordpress.org userid's)
Donate link: https://www.iis.se
Tags: FaceBook Open Graph, Twitter Cards, Google Analytics, IIS Fox meny
Requires at least: 4.0
Tested up to: 4.3
Stable tag: 4.3

IIS Pack är ett generellt plugin för alla IIS-sajter - sådant som vi alltid behöver

== Description ==

Vårt generella plugin lägger till följande:

* FaceBook Open Graph taggar såsom og:image, og:title, og:description, fb:admins (om man har sådana), og:url, og:type (website & article), fb:appid (om sådan finns)
* Twitter Card av typen "summery_large_image"
* Google Analytics enligt vår standard
* Fox menyn med dess utseende inline


== Installation ==

* Placera `iis-pack` i `/wp-content/plugins/`
* Kontrollera att inga plugin gör samma saker som IIS Pack
* Kontrollera att temat inte gör samma saker som IIS Pack
* Kontrollera att wp_head() & wp_footer() finns i temat
* När ovan är gjort (plugins & tema-funktioner avaktiverade) - AKTIVERA IIS Pack
* Fyll i fälten under `Inställningar` -> `IIS Pack`


== Changelog ==

= 1.0.0 =
* Första commiten

