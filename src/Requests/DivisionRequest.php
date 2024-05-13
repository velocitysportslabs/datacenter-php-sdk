<?php

namespace FocusSportsLabs\FslDataCenter\Requests;

use FocusSportsLabs\FslDataCenter\DataObjects\Collection;
use FocusSportsLabs\FslDataCenter\DataObjects\Division;

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
