<?php

namespace VelocitySportsLabs\DataCenter;

use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin\BaseUriPlugin;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Discovery\Psr17FactoryDiscovery;
use VelocitySportsLabs\DataCenter\Exceptions\BadMethodCallException;
use VelocitySportsLabs\DataCenter\Exceptions\InvalidArgumentException;
use VelocitySportsLabs\DataCenter\HttpClient\Builder;
use VelocitySportsLabs\DataCenter\HttpClient\Options;
use VelocitySportsLabs\DataCenter\HttpClient\Plugin\ExceptionHandlerPlugin;
use VelocitySportsLabs\DataCenter\Requests\Contracts\RequestContract;

/**
 * @method Requests\AssociationRequest associations()
 * @method Requests\ClubRequest clubs()
 * @method Requests\CountryRequest countries()
 * @method Requests\CurrencyRequest currencies()
 * @method Requests\DisciplineRequest disciplines()
 * @method Requests\DivisionRequest divisions()
 * @method Requests\FanRequest fans()
 * @method Requests\OrganizationRequest organizations()
 * @method Requests\PlayerRequest players()
 * @method Requests\ProfileRequest profiles()
 * @method Requests\SpendHistoryRequest spendHistory()
 * @method Requests\TeamRequest teams()
 */
class Client
{
    private Builder $httpClient;

    public function __construct(
        Options $options,
        ?Builder $clientBuilder = null,
    ) {
        $this->httpClient = $clientBuilder ?? new Builder();

        $this->httpClient->addPlugin(new ExceptionHandlerPlugin());

        $this->httpClient->addPlugin(
            new BaseUriPlugin(
                Psr17FactoryDiscovery::findUriFactory()->createUri($options->getUri()),
            ),
        );

        $version = null;

        if (\Composer\InstalledVersions::isInstalled('velocity-sports-labs/datacenter-php-sdk')) {
            $version = \Composer\InstalledVersions::getPrettyVersion('velocity-sports-labs/datacenter-php-sdk');
        }

        $this->httpClient->addPlugin(
            new HeaderDefaultsPlugin(
                [
                    'User-Agent' => $options->getUserAgent() . ' (PHP SDK ' . $version . ')',
                    'Origin' => $options->getOrigin(),
                    'X-Authorization' => $options->getAuthToken(),
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
            ),
        );
    }

    /**
     * @param  string  $name
     * @param  array  $args
     */
    public function __call($name, $args): RequestContract
    {
        try {
            return $this->request($name);
        } catch (InvalidArgumentException $e) {
            throw new BadMethodCallException($e->getMessage());
        }
    }

    public function getClient(): HttpMethodsClientInterface
    {
        return $this->httpClient->getClient();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function request(string $name): RequestContract
    {
        return match ($name) {
            'associations' => new Requests\AssociationRequest($this),
            'clubs' => new Requests\ClubRequest($this),
            'countries' => new Requests\CountryRequest($this),
            'currencies' => new Requests\CurrencyRequest($this),
            'disciplines' => new Requests\DisciplineRequest($this),
            'divisions' => new Requests\DivisionRequest($this),
            'fans' => new Requests\FanRequest($this),
            'organizations' => new Requests\OrganizationRequest($this),
            'players' => new Requests\PlayerRequest($this),
            'profiles' => new Requests\ProfileRequest($this),
            'spendHistories' => new Requests\SpendHistoryRequest($this),
            'teams' => new Requests\TeamRequest($this),
            default => throw new InvalidArgumentException(sprintf('Undefined api instance called: "%s"', $name)),
        };
    }
}
