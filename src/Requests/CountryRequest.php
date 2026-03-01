<?php

namespace VelocitySportsLabs\DataCenter\Requests;

use Throwable;
use VelocitySportsLabs\DataCenter\DataObjects\Contracts\DataObjectContract;
use VelocitySportsLabs\DataCenter\DataObjects\Country;

class CountryRequest extends AbstractRequest
{
    /**
     * @throws Throwable
     */
    public function list(array $params = []): array
    {
        $data = $this->get('v1/countries', $params);

        return array_map(
            callback: fn(array $item): DataObjectContract => Country::fromArray($item),
            array: $data['data'],
        );
    }
}
