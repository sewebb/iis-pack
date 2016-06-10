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

