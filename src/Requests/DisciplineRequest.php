<?php

namespace VelocitySportsLabs\DataCenter\Requests;

use VelocitySportsLabs\DataCenter\DataObjects\Collection;
use VelocitySportsLabs\DataCenter\DataObjects\Discipline;

class DisciplineRequest extends AbstractRequest
{
    public function list(array $params = []): Collection
    {
        return new Collection(
            $this->get('v1/disciplines', $params),
            Discipline::class,
        );
    }
}
