# SmartyStreets PHP SDK

## Modern Usage (PSR-7/17/18)

This SDK now uses [PSR-7](https://www.php-fig.org/psr/psr-7/), [PSR-17](https://www.php-fig.org/psr/psr-17/), and [PSR-18](https://www.php-fig.org/psr/psr-18/) for HTTP abstraction. You can use any compatible HTTP client and factories, such as [Guzzle](https://docs.guzzlephp.org/en/stable/).

### Example: Setup with Guzzle

```php
use GuzzleHttp\Client as GuzzleClient;
use Http\Factory\Guzzle\RequestFactory;
use Http\Factory\Guzzle\StreamFactory;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\NativeSerializer;

$httpClient = new GuzzleClient();
$requestFactory = new RequestFactory();
$streamFactory = new StreamFactory();
$serializer = new NativeSerializer();

$builder = new ClientBuilder($httpClient, $requestFactory, $streamFactory, $serializer);
$usStreetClient = $builder->buildUsStreetApiClient();
```

### Making a Request

```php
$lookup = new SmartyStreets\PhpSdk\US_Street\Lookup();
// ... set lookup fields ...
$usStreetClient->sendLookup($lookup);
// ... handle results ...
```

## Requirements
- PHP 7.2+
- PSR-7, PSR-17, PSR-18 compatible HTTP client (e.g., Guzzle)

## Migration from Legacy Version
- All custom HTTP abstractions (`Sender`, `Request`, `Response`, etc.) are deprecated.
- Use PSR-18 client and PSR-17 factories for all HTTP operations.
- See `examples/` for more usage patterns.
