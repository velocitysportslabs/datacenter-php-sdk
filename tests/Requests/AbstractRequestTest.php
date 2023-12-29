<?php

use FocusSportsLabs\FslDataCenter\Client;
use FocusSportsLabs\FslDataCenter\HttpClient\Builder;
use FocusSportsLabs\FslDataCenter\HttpClient\Options;
use FocusSportsLabs\FslDataCenter\Requests\AbstractRequest;
use Http\Client\Common\HttpMethodsClientInterface;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\MockObject\MockObject;

it('should pass get request to client', function (): void {
    $expectedArray = ['value'];

    $httpClient = mockHttpClient(
        'get',
        ['/path?param1=param1value', ['header1' => 'header1value']],
        $expectedArray
    );

    $client = mockClient($httpClient);

    $api = getAbstractRequestObject($client);

    $actual = getMethod($api, 'get')
        ->invokeArgs($api, ['/path', ['param1' => 'param1value'], ['header1' => 'header1value']]);

    expect($actual)->toEqual($expectedArray);
});

it('should pass post request to client', function (): void {
    $expectedArray = ['value'];

    $httpClient = mockHttpClient(
        'post',
        ['/path', ['option1' => 'option1value'], json_encode(['param1' => 'param1value'])],
        $expectedArray
    );

    $client = mockClient($httpClient);

    $api = getAbstractRequestObject($client);
    $actual = getMethod($api, 'post')
        ->invokeArgs($api, ['/path', ['param1' => 'param1value'], ['option1' => 'option1value']]);

    expect($actual)->toEqual($expectedArray);
});

it('should pass patch request to client', function (): void {
    $expectedArray = ['value'];

    $httpClient = mockHttpClient(
        'patch',
        ['/path', ['option1' => 'option1value'], json_encode(['param1' => 'param1value'])],
        $expectedArray
    );

    $client = mockClient($httpClient);

    $api = getAbstractRequestObject($client);
    $actual = getMethod($api, 'patch')
        ->invokeArgs($api, ['/path', ['param1' => 'param1value'], ['option1' => 'option1value']]);

    expect($actual)->toEqual($expectedArray);
});

it('should pass put request to client', function (): void {
    $expectedArray = ['value'];

    $httpClient = mockHttpClient(
        'put',
        ['/path', ['option1' => 'option1value'], json_encode(['param1' => 'param1value'])],
        $expectedArray
    );

    $client = mockClient($httpClient);

    $api = getAbstractRequestObject($client);

    $actual = getMethod($api, 'put')
        ->invokeArgs($api, ['/path', ['param1' => 'param1value'], ['option1' => 'option1value']]);

    expect($actual)->toEqual($expectedArray);
});

it('should pass delete request to client', function (): void {
    $expectedArray = ['value'];

    $httpClient = mockHttpClient(
        'delete',
        ['/path', ['option1' => 'option1value'], json_encode(['param1' => 'param1value'])],
        $expectedArray
    );

    $client = mockClient($httpClient);

    $api = getAbstractRequestObject($client);
    $actual = getMethod($api, 'delete')
        ->invokeArgs($api, ['/path', ['param1' => 'param1value'], ['option1' => 'option1value']]);

    expect($actual)->toEqual($expectedArray);
});

function getAbstractRequestObject($client): MockObject
{
    return test()->getMockForAbstractClass(AbstractRequest::class, [$client]);
}

function mockClient(HttpMethodsClientInterface $httpClient): MockObject
{
    $client = test()->getMockBuilder(Client::class)
        ->setConstructorArgs([new Options([
            'auth_token' => 'token',
            'origin' => 'origin',
        ])])
        ->onlyMethods(['getClient'])
        ->getMock();
    $client->expects(test()->any())
        ->method('getClient')
        ->willReturn($httpClient);

    return $client;
}

function mockHttpClient(string $method, array $requestParameters, array $expectedResults)
{
    $httpClient = getHttpMethodsMock();

    $httpClient->expects(test()->once())
        ->method($method)
        ->with(...$requestParameters)
        ->willReturn(getPSR7Response($expectedResults));

    return $httpClient;
}

function getClientWithHttpMethodsMock(): Client
{
    return new Client(
        new Options([
            'auth_token' => 'token',
            'origin' => 'origin',
        ]),
        new Builder(getHttpMethodsMock())
    );
}

function getHttpMethodsMock(): HttpMethodsClientInterface
{
    $mock = test()->createMock(HttpMethodsClientInterface::class);

    $mock
        ->expects(test()->any())
        ->method('sendRequest');

    return $mock;
}

function getPSR7Response(array $expectedArray): Response
{
    return new Response(
        200,
        ['Content-Type' => 'application/json'],
        json_encode($expectedArray)
    );
}

function getMethod($object, $methodName)
{
    $method = new ReflectionMethod($object, $methodName);
    $method->setAccessible(true);

    return $method;
}
