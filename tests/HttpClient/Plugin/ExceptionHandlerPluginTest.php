<?php

use Http\Client\Promise\HttpFulfilledPromise;
use Http\Client\Promise\HttpRejectedPromise;
use Nyholm\Psr7\Request;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

use function Safe\json_encode;

use VelocitySportsLabs\DataCenter\Exceptions\AuthorizationException;
use VelocitySportsLabs\DataCenter\Exceptions\BadRequestException;
use VelocitySportsLabs\DataCenter\Exceptions\Contracts\ExceptionContract;
use VelocitySportsLabs\DataCenter\Exceptions\ForbiddenException;
use VelocitySportsLabs\DataCenter\Exceptions\InternalServerErrorException;
use VelocitySportsLabs\DataCenter\Exceptions\RateLimitExceededException;
use VelocitySportsLabs\DataCenter\Exceptions\ResourceNotFoundException;
use VelocitySportsLabs\DataCenter\Exceptions\UnknownErrorException;
use VelocitySportsLabs\DataCenter\Exceptions\ValidationException;
use VelocitySportsLabs\DataCenter\HttpClient\Plugin\ExceptionHandlerPlugin;

it('handles the appropriate response for status codes', function (ResponseInterface $response, ?ExceptionContract $exception = null): void {
    $request = new Request('GET', 'https://somewhere.com');

    $promise = new HttpFulfilledPromise($response);

    $plugin = new ExceptionHandlerPlugin();

    $result = $plugin->handleRequest(
        $request,
        fn () => $promise,
        fn () => $promise,
    );

    if ($exception) {
        expect($result)
            ->toBeInstanceOf(HttpRejectedPromise::class)
            ->and(fn () => $result->wait())
            ->toThrow($exception::class, $exception->getMessage());
    } else {
        expect($result)
            ->toBeInstanceOf(HttpFulfilledPromise::class);
        $result->wait();
    }
})->with([
    '200 Response' => [
        new Response(),
        null,
    ],
    '400 Bad Request' => [
        new Response(
            400,
            ['Content-Type' => 'application/json'],
            json_encode(['message' => 'Bad data submitted']),
        ),
        new BadRequestException('Bad data submitted', 400),
    ],
    'Authorization' => [
        new Response(
            401,
            ['Content-Type' => 'application/json'],
            json_encode(['message' => 'Unauthenticated']),
        ),
        new AuthorizationException('Unauthenticated', 401),
    ],
    'Forbidden' => [
        new Response(
            403,
            ['Content-Type' => 'application/json'],
            json_encode(['message' => 'Permission denied']),
        ),
        new ForbiddenException('Permission denied', 403),
    ],
    'Not Found' => [
        new Response(
            404,
            ['Content-Type' => 'application/json'],
            json_encode(['message' => 'File not found.']),
        ),
        new ResourceNotFoundException('File not found.', 404),
    ],
    '422 Unprocessable Entity' => [
        new Response(
            422,
            [
                'Content-Type' => 'application/json',
            ],
            json_encode(
                [
                    'message' => 'Invalid data submitted',
                    'errors' => [
                        'name' => ['Field is required'],
                    ],
                ],
            ),
        ),
        new ValidationException('Invalid data submitted', 422, [
            'name' => ['Field is required'],
        ]),
    ],
    'Rate Limit Exceeded' => [
        new Response(
            429,
            [
                'Content-Type' => 'application/json',
                'X-RateLimit-Remaining' => 0,
                'X-RateLimit-Limit' => 5000,
            ],
            json_encode(['message' => 'Too many requests.']),
        ),
        new RateLimitExceededException('Too many requests.', 429, 5000, 0, 42),
    ],
    'Server error' => [
        new Response(
            500,
            [
                'Content-Type' => 'application/json',
            ],
            json_encode(['message' => 'Something went wrong with executing your query']),
        ),
        new InternalServerErrorException('Something went wrong with executing your query', 500),
    ],

    'Default Error Response' => [
        new Response(
            502,
            [
                'Content-Type' => 'application/json',
            ],
            json_encode(['message' => 'Something went wrong with executing your query']),
        ),
        new UnknownErrorException('Something went wrong with executing your query', 502, ['message' => 'Something went wrong with executing your query']),
    ],
]);
