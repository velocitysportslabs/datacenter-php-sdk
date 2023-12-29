<?php

namespace FocusSportsLabs\FslDataCenter\HttpClient\Plugin;

use FocusSportsLabs\FslDataCenter\Exceptions;
use FocusSportsLabs\FslDataCenter\HttpClient\Message\ResponseMediator;
use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class ExceptionHandlerPlugin implements Plugin
{
    /**
     * @return Promise
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        // @phpstan-ignore-next-line
        return $next($request)->then(function (ResponseInterface $response) {
            $statusCode = $response->getStatusCode();

            if ($statusCode >= 200 && $statusCode <= 299) {
                return $response;
            }

            $content = ResponseMediator::getContent($response);
            $message = $content['message'] ?? $response->getReasonPhrase();

            $rateLimit = (int) ResponseMediator::getHeader($response, 'X-RateLimit-Limit');
            $rateLimitRemaining = (int) ResponseMediator::getHeader($response, 'X-RateLimit-Remaining');
            $rateLimitRetryAfter = (int) ResponseMediator::getHeader($response, 'Retry-After');

            match ($statusCode) {
                400 => throw new Exceptions\BadRequestException($message, $statusCode),
                401 => throw new Exceptions\AuthorizationException($message, $statusCode),
                403 => throw new Exceptions\ForbiddenException($message, $statusCode),
                404 => throw new Exceptions\ResourceNotFoundException($message, $statusCode),
                422 => throw new Exceptions\ValidationException($message, $statusCode, $content['errors']),
                429 => throw new Exceptions\RateLimitExceededException($message, $statusCode, $rateLimit, $rateLimitRemaining, $rateLimitRetryAfter),
                500 => throw new Exceptions\InternalServerErrorException($message, $statusCode),
                default => throw new Exceptions\UnknownErrorException($message, $statusCode, $content)
            };
        });
    }
}
