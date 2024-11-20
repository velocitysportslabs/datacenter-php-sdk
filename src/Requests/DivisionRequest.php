<?php

namespace VelocitySportsLabs\DataCenter\Requests;

use VelocitySportsLabs\DataCenter\DataObjects\Collection;
use VelocitySportsLabs\DataCenter\DataObjects\Division;

class DivisionRequest extends AbstractRequest
{
    public function list(array $params = []): Collection
    {
        return new Collection(
            $this->get('v1/divisions', $params),
            Division::class,
        );
    }
}
