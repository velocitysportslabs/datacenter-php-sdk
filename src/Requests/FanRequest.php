<?php

namespace FocusSportsLabs\FslDataCenter\Requests;

use FocusSportsLabs\FslDataCenter\DataObjects\Fan;

class FanRequest extends AbstractRequest
{
    public function create(array $data = []): Fan
    {
        /** @var array */
        $data = $this->post('v1/fans', $data)['data'];

        return Fan::fromArray($data);
    }
}
