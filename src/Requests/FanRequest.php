<?php

namespace VelocitySportsLabs\DataCenter\Requests;

use Exception;
use VelocitySportsLabs\DataCenter\DataObjects\Fan;

class FanRequest extends AbstractRequest
{
    /**
     * @throws Exception
     */
    public function create(array $data = []): Fan
    {
        /** @var array $data */
        $data = $this->post('v1/fans', $data)['data'];

        return Fan::fromArray($data);
    }
}
