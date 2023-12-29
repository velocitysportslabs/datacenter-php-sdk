# FSL Data Center PHP SDK

A simple PHP SDK for [FSL's Data Center API](https://focussportslabs.com/).

Using this sdk you can easily communicate with FSL's Data Center API

Here are a few examples of the provided methods:

```php
use FocusSportsLabs\FslDataCenter\Client;
use FocusSportsLabs\FslDataCenter\HttpClient\Options;

// This file is generated by Composer
require_once __DIR__ . '/vendor/autoload.php';

$options = new Options([
    'auth_token' => 'token', // get this from your application profile
    'origin' => 'http://localhost', // you set this when creating your application
]);

$client = new Client($options);
$response = $client->countries()->list();

// this would give you a list of all countries supported by FSL
dump($response);
```

## Requirements

To use this project you need:

* PHP 8.1 and above
* A [PSR-17 implementation](https://packagist.org/providers/psr/http-factory-implementation)
* A [PSR-18 implementation](https://packagist.org/providers/psr/http-client-implementation)

## Installation

You can install the package via composer by running:

```bash
composer require focus-sports-labs/data-center-php-sdk
```

## How to obtain api keys

The first thing you will need to do is create or login to your account at [FSL's Data Center API](https://focussportslabs.com/)

![Image of login page]()

![Image of registeration page]()

Next up is create an application to get the api keys and origin

![Image of create application page]()

Make sure to copy your api keys as you will need it when setting up the client.

## Usage

First instantiate the client

```php
use FocusSportsLabs\FslDataCenter\Client;
use FocusSportsLabs\FslDataCenter\HttpClient\Options;

// This file is generated by Composer
require_once __DIR__ . '/vendor/autoload.php';

$options = new Options([
    'auth_token' => 'token', // get this from your application profile
    'origin' => 'http://localhost', // you set this when creating your application
]);

$client = new Client($options);
```

Now that you have the client you can access all available endpoints. Like shown below

```php
<?php

// use the request helper to access endpoints
$countries = $client->request('countries')->list();

// or use the magic method to access endpoints
$countries = $client->countries()->list();
```

***More documentation to come***

## Testing

Run the tests with:

``` bash
vendor/bin/pest
```

## Roadmap

Here are a list of outstanding tasks to do:

* [ ] add documentation for every request
* [ ] add tests for every requests

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you've found a bug regarding security please mail [security@spatie.be](mailto:security@spatie.be) instead of using the issue tracker.

## Credits

* [Abdul Kudus Issah](https://github.com/alhaji-aki)
* [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
