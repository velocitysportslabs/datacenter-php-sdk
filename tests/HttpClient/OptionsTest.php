<?php

use FocusSportsLabs\FslDataCenter\HttpClient\Options;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException;

it('can create an options object with default values', function (): void {
    $options = new Options([
        'user_agent' => 'My Custom SDK',
        'auth_token' => 'token',
        'origin' => 'origin'
    ]);

    expect($options)->toBeInstanceOf(Options::class);
    expect($options->getOptions())->toMatchArray([
        'uri' => 'http://fsl-data-center.test', // TODO: change this url to use the production url by default
        'user_agent' => 'My Custom SDK',
        'auth_token' => 'token',
        'origin' => 'origin'
    ]);
});

it('sets the options to the value passed when instantiating options object', function (): void {
    $options = new Options([
        'uri' => 'https://somewhere.com',
        'user_agent' => 'Testing Agent',
        'auth_token' => 'token',
        'origin' => 'origin'
    ]);

    expect($options)->toBeInstanceOf(Options::class);
    expect($options->getOptions())->toMatchArray([
        'uri' => 'https://somewhere.com',
        'user_agent' => 'Testing Agent',
        'auth_token' => 'token',
        'origin' => 'origin'
    ]);
});

it('fails if an invalid option is passed', function (): void {
    new Options([
        'invalid' => 'https://somewhere.com',
        'auth_token' => 'token',
        'origin' => 'origin'
    ]);
})->throws(UndefinedOptionsException::class);

it('validates the values passed when creating an option', function (): void {
    new Options([
        'uri' => 1,
        'auth_token' => 'token',
        'origin' => 'origin'
    ]);
})->throws(InvalidOptionsException::class);

it('can get the uri', function (): void {
    $options = new Options([
        'auth_token' => 'token',
        'origin' => 'origin'
    ]);

    expect($options->getUri())
        ->toBeString()
        ->toBe('http://fsl-data-center.test'); // TODO: change this url to use the production url by default
});

it('can get the user agent', function (): void {
    $options = new Options([
        'auth_token' => 'token',
        'origin' => 'origin',
        'user_agent' => 'My Custom SDK'
    ]);

    expect($options->getUserAgent())
        ->toBeString()
        ->toBe('My Custom SDK');
});

it('can get the auth token', function (): void {
    $options = new Options([
        'auth_token' => 'token',
        'origin' => 'origin'
    ]);

    expect($options->getAuthToken())
        ->toBeString()
        ->toBe('token');
});

it('can get the origin', function (): void {
    $options = new Options([
        'origin' => 'origin',
        'auth_token' => 'token'
    ]);

    expect($options->getOrigin())
        ->toBeString()
        ->toBe('origin');
});
