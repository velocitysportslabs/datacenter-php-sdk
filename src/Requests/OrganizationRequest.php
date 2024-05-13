<?php

namespace FocusSportsLabs\FslDataCenter\Requests;

use FocusSportsLabs\FslDataCenter\DataObjects\Club;
use FocusSportsLabs\FslDataCenter\DataObjects\Collection;
use FocusSportsLabs\FslDataCenter\DataObjects\Organization;

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
        /** @var array */
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
