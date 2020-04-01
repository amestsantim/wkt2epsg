# wkt2epsg

A PHP library that can be used to convert well-known text (WKT) projection information (like ones found in .prj files) to standard EPSG codes.

## Prerequisites

-   php >= 7.1
-   ext-sqlite3: 

## Installation


### Via Composer

This package can be installed easily with composer - just require the  `amestsantim/wkt2epsg`  package from the command line.

```
composer require amestsantim/wkt2epsg
```

Alternatively, you can manually add the voucherator package to your  `composer.json`  file and then run  `composer install`  from the command line as follows:
```
{
    "require": {
        "amestsantim/wkt2epsg": "^1.0"
    }
}
```
```
composer install
```

You can use it in your PHP code like this:
```php
<?php
require __DIR__ . '/vendor/autoload.php';
use amestsantim\wkt2epsg\Translator;

$finder = new Translator();
echo "EPSG code is " . $finder->wktToEpsg('your wkt string');
```
If you are using it in Laravel, you can instantiate an object from the `amestsantim\wkt2epsg\Translator` class and access the conversion methods epsgToWkt() and wktToEpsg().

## Usage

```php
$finder = amestsantim\wkt2epsg\Translator();

$finder->epsgToWkt('epsg code');
// Equivalent WKT string or null (if not found)

$finder->wktToEpsg('wkt string');
// Equivalent EPSG code or null (if not found)
```
## Documentation
The package works by querying the included sqlite database. The database has a table called 'epsg' which has three columns:
-   epsg
-   name
-   wkt

The the two conversion methods simply query the respective field and return the corresponding value from the other column (as per the method you are calling).

The sqlite database (epsg.db) is created by scrapping the Projected Coordinate Systems page (https://developers.arcgis.com/javascript/3/jshelp/pcs.html) from ESRI's arcgis website.

Since Projected Coordinate Systems page might get updated, I have included with this library, the python script that I used to scrape and generate the database. To do so, just run the script (esri_scrapper.py) from the esri directory.

## Contributing

Please feel free to submit a pull request, if you come up with any useful improvements.

## Authors

* **Nahom Tamerat**

## License

This project is licensed under the MIT License

## Acknowledgments

* This package was inspired by [sridentify](https://github.com/gladchinda/keygen-php)

