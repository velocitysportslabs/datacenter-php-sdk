<?php

namespace FocusSportsLabs\FslDataCenter\HttpClient;

use Symfony\Component\OptionsResolver\OptionsResolver;

class Options
{
    private array $options;

    public function __construct(
        array $options = []
    ) {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($options);
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getUri(): string
    {
        return $this->options['uri'];
    }

    public function getUserAgent(): string
    {
        return $this->options['user_agent'];
    }

    public function getAuthToken(): string
    {
        return $this->options['auth_token'];
    }

    public function getOrigin(): string
    {
        return $this->options['origin'];
    }

    private function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->define('uri')
            ->required()
            ->default('http://fsl-data-center.test') // TODO: change this url to use the production url by default
            ->allowedTypes('string')
            ->info('The base uri of the api');

        $resolver->define('user_agent')
            ->default('')
            ->allowedTypes('string')
            ->info('The user agent to associate to requests');

        $resolver->define('origin')
            ->required()
            ->allowedTypes('string')
            ->info('The origin of the api request');

        $resolver->define('auth_token')
            ->required()
            ->allowedTypes('string')
            ->info('The api token from FSL');
    }
}
