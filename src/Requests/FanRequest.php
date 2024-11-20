<?php

namespace VelocitySportsLabs\DataCenter\Requests;

use VelocitySportsLabs\DataCenter\DataObjects\Fan;

class FanRequest extends AbstractRequest
{
    public function create(array $data = []): Fan
    {
        /** @var array */
        $data = $this->post('v1/fans', $data)['data'];

        return Fan::fromArray($data);
    }
}
