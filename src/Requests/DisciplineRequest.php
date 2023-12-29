<?php

namespace FocusSportsLabs\FslDataCenter\Requests;

use FocusSportsLabs\FslDataCenter\DataObjects\Collection;
use FocusSportsLabs\FslDataCenter\DataObjects\Discipline;

class DisciplineRequest extends AbstractRequest
{
    public function list(array $params = []): Collection
    {
        return new Collection(
            $this->get('v1/disciplines', $params),
            Discipline::class
        );
    }
}
