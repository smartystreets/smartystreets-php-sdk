<?php

namespace SmartyStreets\PhpSdk;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use SmartyStreets\PhpSdk\US_Autocomplete_Pro\Client as USAutoCompleteProApiClient;
use SmartyStreets\PhpSdk\US_Extract\Client as USExtractApiClient;
use SmartyStreets\PhpSdk\International_Street\Client as InternationalStreetApiClient;
use SmartyStreets\PhpSdk\International_Autocomplete\Client as InternationalAutocompleteApiClient;
use SmartyStreets\PhpSdk\International_Postal_Code\Client as InternationalPostalCodeApiClient;
use SmartyStreets\PhpSdk\US_Street\Client as USStreetApiClient;
use SmartyStreets\PhpSdk\US_ZIPCode\Client as USZIPCodeApiClient;
use SmartyStreets\PhpSdk\US_Reverse_Geo\Client as USReverseGeoApiClient;
use SmartyStreets\PhpSdk\US_Enrichment\Client as USEnrichmentApiClient;
use Psr\Log\LoggerInterface;
use Http\Client\Common\Plugin\RetryPlugin;
use Http\Client\Common\Plugin\TimeoutPlugin;
use Http\Client\Common\Plugin\ProxyPlugin;
use Http\Client\Common\PluginClient;

/**
 * PSR-compliant ClientBuilder for SmartyStreets SDK.
 * Supports endpoint constants, custom base URL, retry/timeout/proxy via HTTP client decorators, and chainable configuration.
 */
class ClientBuilder {
    // Endpoint constants
    const INTERNATIONAL_STREET_API_URL = 'https://international-street.api.smarty.com';
    const INTERNATIONAL_AUTOCOMPLETE_API_URL = 'https://international-autocomplete.api.smarty.com';
    const INTERNATIONAL_POSTAL_CODE_API_URL = 'https://international-postal-code.api.smarty.com';
    const US_AUTOCOMPLETE_PRO_API_URL = 'https://us-autocomplete-pro.api.smarty.com/';
    const US_EXTRACT_API_URL = 'https://us-extract.api.smarty.com';
    const US_STREET_API_URL = 'https://us-street.api.smarty.com/street-address';
    const US_ZIP_CODE_API_URL = 'https://us-zipcode.api.smarty.com/lookup';
    const US_REVERSE_GEO_API_URL = 'https://us-reverse-geo.api.smarty.com';
    const US_ENRICHMENT_API_URL = 'https://us-enrichment.api.smarty.com';

    private $httpClient;
    private $requestFactory;
    private $streamFactory;
    private $serializer;
    private $baseUrl = null;
    private $maxRetries = 0;
    private $timeoutMs = null;
    private $proxy = null;
    private $customHeaders = [];
    private $xForwardedFor = null;
    private $licenses = [];
    private $debugMode = false;
    private $logger = null;
    private $signer = null;
    private $directHttpClient = null;
    private $bypassMiddleware = false;
    private $proxyUsername = null;
    private $proxyPassword = null;
    private $proxyObject = null;

    /**
     * @param ClientInterface $httpClient PSR-18 HTTP client
     * @param RequestFactoryInterface $requestFactory PSR-17 request factory
     * @param StreamFactoryInterface $streamFactory PSR-17 stream factory
     * @param Serializer|null $serializer Optional serializer (defaults to NativeSerializer)
     */
    public function __construct(
        ClientInterface $httpClient,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        ?Serializer $serializer = null
    ) {
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
        $this->serializer = $serializer ?: new NativeSerializer();
    }

    /**
     * Set a custom base URL for the API client.
     * @param string $baseUrl
     * @return $this
     */
    public function withUrl($baseUrl) {
        $this->baseUrl = $baseUrl;
        return $this;
    }

    /**
     * Set the maximum number of retries for the HTTP client.
     * @param int $maxRetries
     * @return $this
     */
    public function withRetry($maxRetries) {
        $this->maxRetries = $maxRetries;
        return $this;
    }

    /**
     * Set the timeout (in milliseconds) for the HTTP client.
     * @param int $timeoutMs
     * @return $this
     */
    public function withTimeout($timeoutMs) {
        $this->timeoutMs = $timeoutMs;
        return $this;
    }

    /**
     * Set a proxy URL for the HTTP client, with optional username and password for authentication.
     * @param string $proxyUrl
     * @param string|null $username
     * @param string|null $password
     * @return $this
     */
    public function viaProxy($proxyUrl, $username = null, $password = null) {
        $this->proxy = $proxyUrl;
        $this->proxyUsername = $username;
        $this->proxyPassword = $password;
        return $this;
    }

    /**
     * Set a custom proxy object. The object should implement getProxyForRequest(RequestInterface $request): string|null
     * @param object $proxyObject
     * @return $this
     */
    public function withProxyObject($proxyObject) {
        $this->proxyObject = $proxyObject;
        return $this;
    }

    /**
     * Add a custom header to be included in all requests.
     * @param string $header
     * @param string $value
     * @return $this
     */
    public function withCustomHeader($header, $value) {
        $this->customHeaders[$header] = $value;
        return $this;
    }

    /**
     * Set the X-Forwarded-For header for all requests.
     * @param string $ip
     * @return $this
     */
    public function withXForwardedFor($ip) {
        $this->xForwardedFor = $ip;
        return $this;
    }

    /**
     * Add license strings to be included in all requests as an 'X-License' header (comma-separated).
     * @param array $licenses
     * @return $this
     */
    public function withLicenses(array $licenses) {
        $this->licenses = array_merge($this->licenses, $licenses);
        return $this;
    }

    /**
     * Enable debug mode to log request and response details to STDERR.
     * @return $this
     */
    public function withDebug() {
        $this->debugMode = true;
        return $this;
    }

    /**
     * Set a PSR-3 logger to be used for request/response logging.
     * @param LoggerInterface $logger
     * @return $this
     */
    public function withLogger(LoggerInterface $logger) {
        $this->logger = $logger;
        return $this;
    }

    /**
     * Set a signer callable to sign requests. The callable should accept and return a PSR-7 RequestInterface.
     * @param callable $signer
     * @return $this
     */
    public function withSigner(callable $signer) {
        $this->signer = $signer;
        return $this;
    }

    /**
     * Inject a fully custom PSR-18 HTTP client, optionally bypassing all built-in middleware.
     * @param ClientInterface $httpClient
     * @param bool $bypassMiddleware
     * @return $this
     */
    public function withHttpClient(ClientInterface $httpClient, $bypassMiddleware = false) {
        $this->directHttpClient = $httpClient;
        $this->bypassMiddleware = $bypassMiddleware;
        return $this;
    }

    /**
     * Set a custom serializer to be used for all API clients built from this builder.
     * @param Serializer $serializer
     * @return $this
     */
    public function withSerializer(Serializer $serializer) {
        $this->serializer = $serializer;
        return $this;
    }

    /**
     * Build a PSR-18 HTTP client with all configured middleware (retry, timeout, proxy, custom headers).
     * You may need to use a library like php-http/client-common for real middleware support.
     * @return ClientInterface
     */
    private function buildHttpClient() {
        if ($this->directHttpClient && $this->bypassMiddleware) {
            return $this->directHttpClient;
        }
        $client = $this->directHttpClient ?: $this->httpClient;

        $plugins = [];

        if ($this->maxRetries > 0) {
            $plugins[] = new RetryPlugin([
                'retries' => $this->maxRetries,
                'delay' => 100, // 100ms delay between retries
                'max_delay' => 1000, // 1 second max delay
            ]);
        }

        if ($this->timeoutMs !== null) {
            $plugins[] = new TimeoutPlugin([
                'timeout' => $this->timeoutMs / 1000, // Convert ms to seconds
            ]);
        }

        if ($this->proxyObject !== null) {
            // Dynamic proxy selection per request
            $proxyObject = $this->proxyObject;
            $plugins[] = new class($proxyObject, $this->proxyUsername, $this->proxyPassword) extends ProxyPlugin {
                private $proxyObject;
                private $username;
                private $password;
                public function __construct($proxyObject, $username, $password) {
                    $this->proxyObject = $proxyObject;
                    $this->username = $username;
                    $this->password = $password;
                }
                public function handleRequest(
                    \Psr\Http\Message\RequestInterface $request,
                    callable $next,
                    callable $first
                ) {
                    $proxy = $this->proxyObject->getProxyForRequest($request);
                    if ($proxy) {
                        $options = ['proxy' => $proxy];
                        if ($this->username && $this->password) {
                            $options['auth'] = base64_encode($this->username . ':' . $this->password);
                        }
                        $plugin = new ProxyPlugin($options);
                        return $plugin->handleRequest($request, $next, $first);
                    }
                    return $next($request);
                }
            };
        } else if ($this->proxy !== null) {
            $plugins[] = new ProxyPlugin([
                'proxy' => $this->proxy,
                'auth' => $this->proxyUsername && $this->proxyPassword ?
                    base64_encode($this->proxyUsername . ':' . $this->proxyPassword) : null,
            ]);
        }

        $client = new PluginClient($client, $plugins);

        $headers = $this->customHeaders;
        if ($this->xForwardedFor !== null) {
            $headers['X-Forwarded-For'] = $this->xForwardedFor;
        }
        if (!empty($this->licenses)) {
            $headers['X-License'] = implode(',', $this->licenses);
        }
        if ($this->proxy && $this->proxyUsername && $this->proxyPassword) {
            $auth = base64_encode($this->proxyUsername . ':' . $this->proxyPassword);
            $headers['Proxy-Authorization'] = 'Basic ' . $auth;
        }
        if (!empty($headers)) {
            $client = new class($client, $headers) implements ClientInterface {
                private $client;
                private $headers;
                public function __construct($client, $headers) {
                    $this->client = $client;
                    $this->headers = $headers;
                }
                public function sendRequest(\Psr\Http\Message\RequestInterface $request): \Psr\Http\Message\ResponseInterface {
                    foreach ($this->headers as $header => $value) {
                        $request = $request->withHeader($header, $value);
                    }
                    return $this->client->sendRequest($request);
                }
            };
        }
        if ($this->signer) {
            $client = new class($client, $this->signer) implements ClientInterface {
                private $client;
                private $signer;
                public function __construct($client, $signer) {
                    $this->client = $client;
                    $this->signer = $signer;
                }
                public function sendRequest(\Psr\Http\Message\RequestInterface $request): \Psr\Http\Message\ResponseInterface {
                    $request = call_user_func($this->signer, $request);
                    return $this->client->sendRequest($request);
                }
            };
        }
        if ($this->logger) {
            $client = new class($client, $this->logger) implements ClientInterface {
                private $client;
                private $logger;
                public function __construct($client, $logger) {
                    $this->client = $client;
                    $this->logger = $logger;
                }
                public function sendRequest(\Psr\Http\Message\RequestInterface $request): \Psr\Http\Message\ResponseInterface {
                    $this->logger->info('[REQUEST]', [
                        'method' => $request->getMethod(),
                        'uri' => (string)$request->getUri(),
                        'headers' => $request->getHeaders(),
                        'body' => (string)$request->getBody()
                    ]);
                    $response = $this->client->sendRequest($request);
                    $this->logger->info('[RESPONSE]', [
                        'status' => $response->getStatusCode(),
                        'headers' => $response->getHeaders(),
                        'body' => (string)$response->getBody()
                    ]);
                    return $response;
                }
            };
        }
        if ($this->debugMode) {
            $client = new class($client) implements ClientInterface {
                private $client;
                public function __construct($client) {
                    $this->client = $client;
                }
                public function sendRequest(\Psr\Http\Message\RequestInterface $request): \Psr\Http\Message\ResponseInterface {
                    error_log("[DEBUG] Request: " . $request->getMethod() . ' ' . (string)$request->getUri());
                    foreach ($request->getHeaders() as $name => $values) {
                        error_log("[DEBUG]   $name: " . implode(", ", $values));
                    }
                    $body = (string)$request->getBody();
                    if ($body !== '') {
                        error_log("[DEBUG]   Body: $body");
                    }
                    $response = $this->client->sendRequest($request);
                    error_log("[DEBUG] Response: " . $response->getStatusCode());
                    foreach ($response->getHeaders() as $name => $values) {
                        error_log("[DEBUG]   $name: " . implode(", ", $values));
                    }
                    $respBody = (string)$response->getBody();
                    if ($respBody !== '') {
                        error_log("[DEBUG]   Body: $respBody");
                    }
                    return $response;
                }
            };
        }
        return $client;
    }

    /**
     * Build a US Street API client.
     */
    public function buildUsStreetApiClient() {
        return new USStreetApiClient(
            $this->buildHttpClient(),
            $this->requestFactory,
            $this->streamFactory,
            $this->serializer,
            $this->baseUrl ?: self::US_STREET_API_URL
        );
    }
    public function buildUsZIPCodeApiClient() {
        return new USZIPCodeApiClient(
            $this->buildHttpClient(),
            $this->requestFactory,
            $this->streamFactory,
            $this->serializer,
            $this->baseUrl ?: self::US_ZIP_CODE_API_URL
        );
    }
    public function buildUsExtractApiClient() {
        return new USExtractApiClient(
            $this->buildHttpClient(),
            $this->requestFactory,
            $this->streamFactory,
            $this->serializer,
            $this->baseUrl ?: self::US_EXTRACT_API_URL
        );
    }
    public function buildUsAutocompleteProApiClient() {
        return new USAutoCompleteProApiClient(
            $this->buildHttpClient(),
            $this->requestFactory,
            $this->streamFactory,
            $this->serializer,
            $this->baseUrl ?: self::US_AUTOCOMPLETE_PRO_API_URL
        );
    }
    public function buildInternationalStreetApiClient() {
        return new InternationalStreetApiClient(
            $this->buildHttpClient(),
            $this->requestFactory,
            $this->streamFactory,
            $this->serializer,
            $this->baseUrl ?: self::INTERNATIONAL_STREET_API_URL
        );
    }
    public function buildInternationalAutocompleteApiClient() {
        return new InternationalAutocompleteApiClient(
            $this->buildHttpClient(),
            $this->requestFactory,
            $this->streamFactory,
            $this->serializer,
            $this->baseUrl ?: self::INTERNATIONAL_AUTOCOMPLETE_API_URL
        );
    }
    public function buildInternationalPostalCodeApiClient() {
        return new InternationalPostalCodeApiClient(
            $this->buildHttpClient(),
            $this->requestFactory,
            $this->streamFactory,
            $this->serializer,
            $this->baseUrl ?: self::INTERNATIONAL_POSTAL_CODE_API_URL
        );
    }
    public function buildUsReverseGeoApiClient() {
        return new USReverseGeoApiClient(
            $this->buildHttpClient(),
            $this->requestFactory,
            $this->streamFactory,
            $this->serializer,
            $this->baseUrl ?: self::US_REVERSE_GEO_API_URL
        );
    }
    public function buildUsEnrichmentApiClient() {
        return new USEnrichmentApiClient(
            $this->buildHttpClient(),
            $this->requestFactory,
            $this->streamFactory,
            $this->serializer,
            $this->baseUrl ?: self::US_ENRICHMENT_API_URL
        );
    }
}