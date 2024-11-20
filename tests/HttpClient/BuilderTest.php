<?php

use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin\HeaderAppendPlugin;
use VelocitySportsLabs\DataCenter\HttpClient\Builder;

it('can create a builder instance', function (): void {
    $builder = new Builder();

    expect($builder)->toBeInstanceOf(Builder::class);
});

it('can get the attached http client', function (): void {
    $builder = new Builder();

    expect($builder->getClient())->toBeInstanceOf(HttpMethodsClientInterface::class);
});

it("can add plugins to the builder's plugins", function (): void {
    $builder = new Builder();
    $plugin = new HeaderAppendPlugin(['Accept' => 'application/json']);

    $builder->addPlugin($plugin);

    expect($builder->plugins())
        ->toBeArray()
        ->not->toBeEmpty()
        ->toMatchArray([$plugin]);
});

it("can remove plugins from the builder's plugins", function (): void {
    $builder = new Builder();
    $plugin = new HeaderAppendPlugin(['Accept' => 'application/json']);
    $builder->addPlugin($plugin);

    expect($builder->plugins())
        ->toBeArray()
        ->not->toBeEmpty()
        ->toMatchArray([$plugin]);

    $builder->removePlugin($plugin::class);

    expect($builder->plugins())
        ->toBeArray()
        ->toBeEmpty()
        ->toMatchArray([]);
});

it('can get the attached plugins', function (): void {

    $builder = new Builder();

    expect($builder->plugins())
        ->toBeArray()
        ->toBeEmpty();
});
