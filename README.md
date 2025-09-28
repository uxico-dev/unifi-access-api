# A PHP (Laravel) API client for the Unifi Access API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/uxicodev/unifi-access-api.svg?style=flat-square)](https://packagist.org/packages/uxicodev/unifi-access-api)
[![Total Downloads](https://img.shields.io/packagist/dt/uxicodev/unifi-access-api.svg?style=flat-square)](https://packagist.org/packages/uxicodev/unifi-access-api)
[![Github Actions](https://github.com/uxico-dev/unifi-access-api/actions/workflows/main.yml/badge.svg)](https://github.com/uxico-dev/unifi-access-api/actions/workflows/main.yml)

A PHP (Laravel) API client for the Ubiquity Unifi Access API

## Installation

You can install the package via composer:

```bash
composer require uxicodev/unifi-access-api
```

## Usage

### Laravel

Add the following to your `.env` file:
```dotenv
## Replace with your actual Unifi Access controller URL
UNIFI_ACCESS_URI=https://192.168.1.1:12445/api/v1/developer/
#API key can be retrieved in your admin console at page "access/settings/system"
UNIFI_ACCESS_API_KEY=your_api_key_here
UNIFI_ACCESS_SSL_VERIFY=false
```

```php
use Carbon\Carbon;
use Uxicodev\UnifiAccessApi\API\Enums\VisitReason;
use Uxicodev\UnifiAccessApi\API\Requests\Visitor\CreateVisitorRequest;
use Uxicodev\UnifiAccessApi\UnifiAccessApiFacade;

$unifiClient = UnifiAccessApiFacade::getClient();
$visitorRequest = new CreateVisitorRequest('Jimmy', 'McGill', Carbon::now(), Carbon::now()->addHour(), VisitReason::Others);
$visitorResponse = $unifiClient->visitor()->create($visitorRequest);
$unifiClient->visitor()->assignQrCode($visitorResponse->data->id);
```

### Non-Laravel application
```php
use Carbon\Carbon;
use Uxicodev\UnifiAccessApi\API\Enums\VisitReason;
use Uxicodev\UnifiAccessApi\API\Requests\Visitor\CreateVisitorRequest;
use Uxicodev\UnifiAccessApi\HttpClient\Client as UnifiClient;

$unifiClient = new UnifiClient($baseUri, $apiKey, ['verify' => false]);
$visitorRequest = new CreateVisitorRequest('Jimmy', 'McGill', Carbon::now(), Carbon::now()->addHour(), VisitReason::Others);
$visitorResponse = $unifiClient->visitor()->create($visitorRequest);
$unifiClient->visitor()->assignQrCode($visitorResponse->data->id);
```

## FAQ

### My API key is not working

Make sure you are using the correct API key. You can create an API key at two seperate locations, but those locations serve a different purpose.
You can retrieve the Access API key in your admin console at page `access/settings/system`.

You can also create a Network/Protect API key at `access/settings/control-plane/integrations`. However, this key does NOT work for the Access API. 

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email security@uxico.dev instead of using the issue tracker.

## Credits

-   [Maarten Kuiper](https://github.com/uxicodev)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
