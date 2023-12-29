<?php

namespace FocusSportsLabs\FslDataCenter\HttpClient\Message;

use JsonException;
use Psr\Http\Message\ResponseInterface;

use function Safe\json_decode;

final class ResponseMediator
{
    /**
     * @throws JsonException
     */
    public static function getContent(ResponseInterface $response): array
    {
        return (array) json_decode($response->getBody()->getContents(), true, JSON_THROW_ON_ERROR);
    }

    public static function getHeader(ResponseInterface $response, string $name): ?string
    {
        $headers = $response->getHeader($name);

        return array_shift($headers);
    }
}
