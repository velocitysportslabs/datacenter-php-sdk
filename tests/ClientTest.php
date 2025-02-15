<?php

use Http\Client\Common\HttpMethodsClientInterface;
use VelocitySportsLabs\DataCenter\Client;
use VelocitySportsLabs\DataCenter\Exceptions\BadMethodCallException;
use VelocitySportsLabs\DataCenter\Exceptions\InvalidArgumentException;
use VelocitySportsLabs\DataCenter\HttpClient\Options;

it('can create a new Client', function (): void {
    $client = new Client(
        new Options([
            'auth_token' => 'token',
            'origin' => 'origin',
        ]),
    );

    expect($client)
        ->toBeInstanceOf(Client::class);
});

it('can get the attached client from the Client', function (): void {
    expect(
        (new Client(
            new Options([
                'auth_token' => 'token',
                'origin' => 'origin',
            ]),
        ))->getClient(),
    )->toBeInstanceOf(HttpMethodsClientInterface::class);
});

it('should get request instance using the magic method', function ($apiName, $class): void {
    $client = new Client(
        new Options([
            'auth_token' => 'token',
            'origin' => 'origin',
        ]),
    );

    expect($client->{$apiName}())->toBeInstanceOf($class);
})->with('apis');

it('should get the request using the api method', function ($apiName, $class): void {
    $client = new Client(
        new Options([
            'auth_token' => 'token',
            'origin' => 'origin',
        ]),
    );

    expect($client->request($apiName))->toBeInstanceOf($class);
})->with('apis');

it('should throw exception if request does not exist using the magic method', function (): void {
    $client = new Client(new Options([
        'auth_token' => 'token',
        'origin' => 'origin',
    ]));

    $client->doesNotExist();
})->throws(BadMethodCallException::class);

it('should throw exception if request does not exist using the api method', function (): void {
    $client = new Client(new Options([
        'auth_token' => 'token',
        'origin' => 'origin',
    ]));

    $client->request('doesNotExist');
})->throws(InvalidArgumentException::class);
