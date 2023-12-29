<?php

namespace FocusSportsLabs\FslDataCenter;

use FocusSportsLabs\FslDataCenter\Exceptions\BadMethodCallException;
use FocusSportsLabs\FslDataCenter\Exceptions\InvalidArgumentException;
use FocusSportsLabs\FslDataCenter\HttpClient\Builder;
use FocusSportsLabs\FslDataCenter\HttpClient\Options;
use FocusSportsLabs\FslDataCenter\HttpClient\Plugin\ExceptionHandlerPlugin;
use FocusSportsLabs\FslDataCenter\Requests\Contracts\RequestContract;
use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin\BaseUriPlugin;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Discovery\Psr17FactoryDiscovery;

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
                Psr17FactoryDiscovery::findUriFactory()->createUri($options->getUri())
            )
        );

        $version = null;

        if (\Composer\InstalledVersions::isInstalled('focus-sports-labs/fsl-data-center')) {
            $version = \Composer\InstalledVersions::getPrettyVersion('focus-sports-labs/fsl-data-center');
        }

        $this->httpClient->addPlugin(
            new HeaderDefaultsPlugin(
                [
                    'User-Agent' => $options->getUserAgent() . ' (PHP SDK ' . $version . ')',
                    'Origin' => $options->getOrigin(),
                    'X-Authorization' => $options->getAuthToken(),
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ]
            )
        );
    }

    /**
     * @param string $name
     * @param array  $args
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
