<?php

namespace FocusSportsLabs\FslDataCenter\Requests;

use FocusSportsLabs\FslDataCenter\DataObjects\Association;
use FocusSportsLabs\FslDataCenter\DataObjects\Club;
use FocusSportsLabs\FslDataCenter\DataObjects\Collection;

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
        /** @var array */
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
