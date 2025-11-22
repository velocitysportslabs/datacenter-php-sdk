<?php

namespace VelocitySportsLabs\DataCenter\Requests;

use VelocitySportsLabs\DataCenter\DataObjects\Club;
use VelocitySportsLabs\DataCenter\DataObjects\Collection;
use VelocitySportsLabs\DataCenter\DataObjects\Organization;

class OrganizationRequest extends AbstractRequest
{
    public function list(array $params = []): Collection
    {
        return new Collection(
            $this->get('v1/organizations', $params),
            Organization::class,
        );
    }

    public function retrieve(string $organization, array $params = []): Organization
    {
        /** @var array $data */
        $data = $this->get("v1/organizations/{$organization}", $params)['data'];

        return Organization::fromArray($data);
    }

    public function retrieveClubs(string $organization, array $params = []): Collection
    {
        return new Collection(
            $this->get("v1/organizations/{$organization}/clubs", $params),
            Club::class,
        );
    }
}
