<?php

namespace FocusSportsLabs\FslDataCenter\HttpClient;

use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin;
use Http\Client\Common\PluginClientFactory;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

class Builder
{
    private ClientInterface $client;

    /**
     * A HTTP client with all our plugins.
     */
    private HttpMethodsClientInterface $pluginClient;

    private RequestFactoryInterface $requestFactory;

    private StreamFactoryInterface $streamFactory;

    /**
     * True if we should create a new Plugin client at next request.
     */
    private bool $httpClientModified = true;

    private array $plugins = [];

    public function __construct(
        ?ClientInterface $client = null,
        ?RequestFactoryInterface $requestFactory = null,
        ?StreamFactoryInterface $streamFactory = null,
    ) {
        $this->client = $client ?: Psr18ClientDiscovery::find();
        $this->requestFactory = $requestFactory ?: Psr17FactoryDiscovery::findRequestFactory();
        $this->streamFactory = $streamFactory ?: Psr17FactoryDiscovery::findStreamFactory();
    }

    public function getClient(): HttpMethodsClientInterface
    {
        if ($this->httpClientModified) {
            $this->httpClientModified = false;

            $pluginClient = (new PluginClientFactory())->createClient(
                client: $this->client,
                plugins: $this->plugins(),
            );

            $this->pluginClient = new HttpMethodsClient(
                $pluginClient,
                $this->requestFactory,
                $this->streamFactory,
            );
        }

        return $this->pluginClient;
    }

    public function addPlugin(Plugin $plugin): void
    {
        $this->plugins[] = $plugin;
        $this->httpClientModified = true;
    }

    public function removePlugin(string $fqcn): void
    {
        foreach ($this->plugins as $idx => $plugin) {
            if ($plugin instanceof $fqcn) {
                unset($this->plugins[$idx]);
                $this->httpClientModified = true;
            }
        }
    }

    public function plugins(): array
    {
        return $this->plugins;
    }
}
