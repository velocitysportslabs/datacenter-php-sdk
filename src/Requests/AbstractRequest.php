<?php

namespace VelocitySportsLabs\DataCenter\Requests;

use Psr\Http\Message\ResponseInterface;
use Random\RandomException;
use Safe\Exceptions\FileinfoException;
use Safe\Exceptions\FilesystemException;

use function Safe\file_get_contents;
use function Safe\json_encode;
use function Safe\mime_content_type;

use SplFileInfo;
use VelocitySportsLabs\DataCenter\Client;
use VelocitySportsLabs\DataCenter\HttpClient\Message\ResponseMediator;
use VelocitySportsLabs\DataCenter\Requests\Contracts\RequestContract;

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
     * Send a POST request with multipart/form-data (for file uploads).
     *
     * @param  array<string, string|null>  $fields  Regular form fields
     * @param  array<string, string|SplFileInfo>  $files  Field name => file path or SplFileInfo instance
     *
     * @throws FileinfoException
     * @throws FilesystemException|RandomException
     */
    protected function postMultipart(string $path, array $fields = [], array $files = [], array $requestHeaders = []): array
    {
        $boundary = '----FormBoundary' . bin2hex(random_bytes(16));
        $body = '';

        foreach ($fields as $name => $value) {
            if (null === $value) {
                continue;
            }
            $body .= "--{$boundary}\r\n";
            $body .= "Content-Disposition: form-data; name=\"{$name}\"\r\n\r\n";
            $body .= "{$value}\r\n";
        }

        foreach ($files as $name => $file) {
            if ($file instanceof SplFileInfo) {
                $realPath = $file->getRealPath() ?: $file->getPathname();
                $filename = method_exists($file, 'getClientOriginalName')
                    ? $file->getClientOriginalName()
                    : $file->getFilename();
                $mime = method_exists($file, 'getMimeType')
                    ? ($file->getMimeType() ?? 'application/octet-stream')
                    : (mime_content_type($realPath) ?: 'application/octet-stream');
            } else {
                $realPath = $file;
                $filename = basename($file);
                $mime = mime_content_type($realPath) ?: 'application/octet-stream';
            }

            $content = file_get_contents($realPath);

            $body .= "--{$boundary}\r\n";
            $body .= "Content-Disposition: form-data; name=\"{$name}\"; filename=\"{$filename}\"\r\n";
            $body .= "Content-Type: {$mime}\r\n\r\n";
            $body .= "{$content}\r\n";
        }

        $body .= "--{$boundary}--\r\n";

        $requestHeaders['Content-Type'] = "multipart/form-data; boundary={$boundary}";

        return $this->postRaw($path, $body, $requestHeaders);
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
