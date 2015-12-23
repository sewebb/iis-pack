IIS Pack
========

IIS Pack är ett generellt plugin för alla IIS-sajter - sådant som vi alltid behöver

# Om IIS Pack

Vårt generella plugin lägger till följande:

* FaceBook Open Graph taggar såsom og:image, og:title, og:description, fb:admins (om man har sådana), og:url, og:type (website & article), fb:appid (om sådan finns)
* Twitter Card av typen "summery_large_image"
* Google Analytics enligt vår standard
* Fox menyn med dess utseende inline

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

#### 1.0.0
* Första commiten

