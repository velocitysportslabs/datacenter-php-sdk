<?php

namespace FocusSportsLabs\FslDataCenter\Requests;

use FocusSportsLabs\FslDataCenter\Client;
use FocusSportsLabs\FslDataCenter\HttpClient\Message\ResponseMediator;
use FocusSportsLabs\FslDataCenter\Requests\Contracts\RequestContract;
use Psr\Http\Message\ResponseInterface;

use function Safe\json_encode;

abstract class AbstractRequest implements RequestContract
{
    public function __construct(
        protected Client $client,
    ) {}

    /**
     * Send a GET request with query parameters.
     */
    protected function get(string $path, array $parameters = [], array $requestHeaders = []): array
    {
        if (count($parameters) > 0) {
            $path .= '?' . http_build_query($parameters, '', '&', PHP_QUERY_RFC3986);
        }

        $response = $this->client->getClient()->get($path, $requestHeaders);

        return ResponseMediator::getContent($response);
    }

    /**
     * Send a HEAD request with query parameters.
     */
    protected function head(string $path, array $parameters = [], array $requestHeaders = []): ResponseInterface
    {
        if (count($parameters) > 0) {
            $path .= '?' . http_build_query($parameters, '', '&', PHP_QUERY_RFC3986);
        }

        return $this->client->getClient()->head($path, $requestHeaders);
    }

    /**
     * Send a POST request with JSON-encoded parameters.
     */
    protected function post(string $path, array $parameters = [], array $requestHeaders = []): array
    {
        return $this->postRaw(
            $path,
            $this->createJsonBody($parameters),
            $requestHeaders,
        );
    }

    /**
     * Send a POST request with raw data.
     */
    protected function postRaw(string $path, ?string $body = null, array $requestHeaders = []): array
    {
        $response = $this->client->getClient()->post(
            $path,
            $requestHeaders,
            $body,
        );

        return ResponseMediator::getContent($response);
    }

    /**
     * Send a PATCH request with JSON-encoded parameters.
     */
    protected function patch(string $path, array $parameters = [], array $requestHeaders = []): array
    {
        $response = $this->client->getClient()->patch(
            $path,
            $requestHeaders,
            $this->createJsonBody($parameters),
        );

        return ResponseMediator::getContent($response);
    }

    /**
     * Send a PUT request with JSON-encoded parameters.
     */
    protected function put(string $path, array $parameters = [], array $requestHeaders = []): array
    {
        $response = $this->client->getClient()->put(
            $path,
            $requestHeaders,
            $this->createJsonBody($parameters),
        );

        return ResponseMediator::getContent($response);
    }

    /**
     * Send a DELETE request with JSON-encoded parameters.
     */
    protected function delete(string $path, array $parameters = [], array $requestHeaders = []): array
    {
        $response = $this->client->getClient()->delete(
            $path,
            $requestHeaders,
            $this->createJsonBody($parameters),
        );

        return ResponseMediator::getContent($response);
    }

    /**
     * Create a JSON encoded version of an array of parameters.
     */
    protected function createJsonBody(array $parameters): ?string
    {
        if (0 === count($parameters)) {
            return null;
        }

        return json_encode($parameters, JSON_FORCE_OBJECT);
    }
}
