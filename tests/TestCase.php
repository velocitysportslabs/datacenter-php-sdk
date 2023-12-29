<?php

namespace FocusSportsLabs\FslDataCenter\Tests;

use FocusSportsLabs\FslDataCenter\Client;
use FocusSportsLabs\FslDataCenter\HttpClient\Builder;
use FocusSportsLabs\FslDataCenter\HttpClient\Options;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\TestCase as BaseTestCase;

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
            ])
        );
    }
}
