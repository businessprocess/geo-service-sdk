Geo Service PHP SDK
=============================

[![Latest Stable Version](https://poser.pugx.org/businessprocess/geo-service-sdk/v/stable)](https://packagist.org/packages/businessprocess/geo-service-sdk)
![Total Downloads](https://poser.pugx.org/businessprocess/geo-service-sdk/downloads)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

Geo Service SDK is a PSR-compatible PHP package for working with geo service api.

[API Documentation](https://geo-service.ooo.ua/api/v1/api-docs/)


## Installation
The recommended way to install Translate API client is through
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
$response = $client->countries();

echo $response->all(); # '[{"id": ...}'
```

## Usage Laravel

```php
$response = \GeoService\Facade\Geo::countries();

echo $response->all(); # '[{"id": ...}'
```

#### Available Methods

| Methods                | Description                       | Return value | 
|------------------------|-----------------------------------|--------------|
| getCountryWithChildren | Get all countries with children   | Collection   |
| countries              | Get all countries without details | Collection   |
| country                | Get country by id                 | Country      |
| getById                | Get model by id                   | BaseModel    |
| getChildById           | Get all children by parent id     | Collection   |
| search                 | Get all model by keyword          | Collection   |
| ping                   | Ping node                         | boolean      |
| alive                  | Check is node is alive            | boolean      |
