<?php

namespace VelocitySportsLabs\DataCenter\Requests;

use VelocitySportsLabs\DataCenter\DataObjects\Association;
use VelocitySportsLabs\DataCenter\DataObjects\Club;
use VelocitySportsLabs\DataCenter\DataObjects\Collection;

class AssociationRequest extends AbstractRequest
{
    public function list(array $params = []): Collection
    {
        return new Collection(
            $this->get('v1/associations', $params),
            Association::class,
        );
    }

    public function retrieve(string $association, array $params = []): Association
    {
        /** @var array $data */
        $data = $this->get("v1/associations/{$association}", $params)['data'];

        return Association::fromArray($data);
    }

    public function retrieveClubs(string $association, array $params = []): Collection
    {
        return new Collection(
            $this->get("v1/associations/{$association}/clubs", $params),
            Club::class,
        );
    }
}
