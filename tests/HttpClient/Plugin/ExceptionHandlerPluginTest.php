<?php

use FocusSportsLabs\FslDataCenter\Exceptions\AuthorizationException;
use FocusSportsLabs\FslDataCenter\Exceptions\BadRequestException;
use FocusSportsLabs\FslDataCenter\Exceptions\Contracts\ExceptionContract;
use FocusSportsLabs\FslDataCenter\Exceptions\ForbiddenException;
use FocusSportsLabs\FslDataCenter\Exceptions\InternalServerErrorException;
use FocusSportsLabs\FslDataCenter\Exceptions\RateLimitExceededException;
use FocusSportsLabs\FslDataCenter\Exceptions\ResourceNotFoundException;
use FocusSportsLabs\FslDataCenter\Exceptions\UnknownErrorException;
use FocusSportsLabs\FslDataCenter\Exceptions\ValidationException;
use FocusSportsLabs\FslDataCenter\HttpClient\Plugin\ExceptionHandlerPlugin;
use Http\Client\Promise\HttpFulfilledPromise;
use Http\Client\Promise\HttpRejectedPromise;
use Nyholm\Psr7\Request;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

it('handles the appropriate response for status codes', function (ResponseInterface $response, ?ExceptionContract $exception = null): void {
    $request = new Request('GET', 'https://somewhere.com');

    $promise = new HttpFulfilledPromise($response);

    $plugin = new ExceptionHandlerPlugin();

    $result = $plugin->handleRequest(
        $request,
        fn() => $promise,
        fn() => $promise,
    );

    if ($exception) {
        expect($result)->toBeInstanceOf(HttpRejectedPromise::class);
        expect(fn() => $result->wait())->toThrow($exception::class, $exception->getMessage());
    } else {
        expect($result)->toBeInstanceOf(HttpFulfilledPromise::class);
        $result->wait();
    }
})->with([
    '200 Response' => [
        'response' => new Response(),
        'exception' => null,
    ],
    '400 Bad Request' => [
        'response' => new Response(
            400,
            ['Content-Type' => 'application/json'],
            json_encode(['message' => 'Bad data submitted'])
        ),
        'exception' => new BadRequestException('Bad data submitted', 400),
    ],
    'Authorization' => [
        'response' => new Response(
            401,
            ['Content-Type' => 'application/json'],
            json_encode(['message' => 'Unauthenticated'])
        ),
        'exception' => new AuthorizationException('Unauthenticated', 401),
    ],
    'Forbidden' => [
        'response' => new Response(
            403,
            ['Content-Type' => 'application/json'],
            json_encode(['message' => 'Permission denied'])
        ),
        'exception' => new ForbiddenException('Permission denied', 403),
    ],
    'Not Found' => [
        'response' => new Response(
            404,
            ['Content-Type' => 'application/json'],
            json_encode(['message' => 'File not found.'])
        ),
        'exception' => new ResourceNotFoundException('File not found.', 404),
    ],
    '422 Unprocessable Entity' => [
        'response' => new Response(
            422,
            [
                'Content-Type' => 'application/json',
            ],
            json_encode(
                [
                    'message' => 'Invalid data submitted',
                    'errors' => [
                        'name' => ['Field is required']
                    ],
                ]
            )
        ),
        'exception' => new ValidationException('Invalid data submitted', 422, [
            'name' => ['Field is required']
        ]),
    ],
    'Rate Limit Exceeded' => [
        'response' => new Response(
            429,
            [
                'Content-Type' => 'application/json',
                'X-RateLimit-Remaining' => 0,
                'X-RateLimit-Limit' => 5000,
            ],
            json_encode(['message' => 'Too many requests.'])
        ),
        'exception' => new RateLimitExceededException('Too many requests.', 429, 5000, 0, 42),
    ],
    'Server error' => [
        'response' => new Response(
            500,
            [
                'Content-Type' => 'application/json',
            ],
            json_encode(['message' => 'Something went wrong with executing your query'])
        ),
        'exception' => new InternalServerErrorException('Something went wrong with executing your query', 500),
    ],

    'Default Error Response' => [
        'response' => new Response(
            502,
            [
                'Content-Type' => 'application/json',
            ],
            json_encode(['message' => 'Something went wrong with executing your query'])
        ),
        'exception' => new UnknownErrorException('Something went wrong with executing your query', 502, ['message' => 'Something went wrong with executing your query']),
    ],
]);
