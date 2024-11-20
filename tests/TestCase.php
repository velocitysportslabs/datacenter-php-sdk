<?php

namespace VelocitySportsLabs\DataCenter\Tests;

use Http\Mock\Client as MockClient;
use PHPUnit\Framework\TestCase as BaseTestCase;
use VelocitySportsLabs\DataCenter\Client;
use VelocitySportsLabs\DataCenter\HttpClient\Builder;
use VelocitySportsLabs\DataCenter\HttpClient\Options;

abstract class TestCase extends BaseTestCase
{
    protected MockClient $mockClient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockClient = new MockClient();
    }

    protected function givenClient(): Client
    {
        return new Client(
            new Options([
                'client_builder' => new Builder($this->mockClient),
            ]),
        );
    }
}
