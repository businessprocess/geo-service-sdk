Geo Service PHP SDK
=============================
![PHP 8.x](https://img.shields.io/badge/PHP-%5E8.0-blue)
[![Laravel 8.x](https://img.shields.io/badge/Laravel-8.x-orange.svg)](http://laravel.com)
[![Yii 2.x](https://img.shields.io/badge/Yii-2.x-orange)](https://www.yiiframework.com/doc/guide/2.0/ru)
[![Latest Stable Version](https://poser.pugx.org/businessprocess/geo-service-sdk/v/stable)](https://packagist.org/packages/businessprocess/geo-service-sdk)
![Release date](https://img.shields.io/github/release-date/businessprocess/geo-service-sdk)
![Release Version](https://img.shields.io/github/v/release/businessprocess/geo-service-sdk)
![Total Downloads](https://poser.pugx.org/businessprocess/geo-service-sdk/downloads)
![Pull requests](https://img.shields.io/bitbucket/pr/businessprocess/geo-service-sdk)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
![Stars](https://img.shields.io/github/stars/businessprocess/geo-service-sdk?style=social)

Geo Service SDK is a PSR-compatible PHP package for working with geo service api.

[API Documentation](https://geo-service.ooo.ua/api/v1/api-docs/)


## Installation
The recommended way to install Geo service is through
[Composer](http://getcomposer.org).

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer command to install the latest stable version of Guzzle:

```bash
composer require businessprocess/geo-service-sdk
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

You can then later update Guzzle using composer:

 ```bash
composer update
 ```

## Usage

```php
$client = new \GeoService\Service\GeoService();

// set locale if we need
$client->setLocale('en')

$response = $client->countries();

print $response->all(); # '[{"id": ...}'
```

## Usage Laravel

```php
$response = \GeoService\Facade\Geo::setLocale('ru')->countries();

print $response->all(); # '[{"id": ...}'

$citiesAndTowns = \GeoService\Facade\Geo::getCitiesByCountry('r60199');

//get only cities, default city,town
$cities = \GeoService\Facade\Geo::getCitiesByCountry('r60199', 'city');

```

#### Available Methods

| Methods               | Description                        | Return value | 
|-----------------------|------------------------------------|--------------|
| getCountryWithCities  | Get all countries with children    | Collection   |
| countries             | Get all countries without details  | Collection   |
| country               | Get country by id                  | Country      |
| getCitiesByCountry    | Get cities by country id           | Collection   |
| getById               | Get model by id                    | BaseModel    |
| getChildById          | Get all children by parent id      | Collection   |
| search                | Get all model by keyword           | Collection   |
| ping                  | Ping node                          | boolean      |
| alive                 | Check is node is alive             | boolean      |
| isServiceId           | Check is id belongs to geo service | boolean      |
