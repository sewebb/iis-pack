IIS Pack
========

IIS Pack är ett generellt plugin för alla IIS-sajter - sådant som vi alltid behöver

# Om IIS Pack

Vårt generella plugin lägger till följande:

* FaceBook Open Graph taggar såsom og:image, og:title, og:description, fb:admins (om man har sådana), og:url, og:type (website & article), fb:appid (om sådan finns)
* Twitter Card av typen "summery_large_image"
* Google Analytics enligt vår standard
* Fox menyn med dess utseende inline
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
