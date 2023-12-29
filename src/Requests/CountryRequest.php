<?php

namespace FocusSportsLabs\FslDataCenter\Requests;

use FocusSportsLabs\FslDataCenter\DataObjects\Contracts\DataObjectContract;
use FocusSportsLabs\FslDataCenter\DataObjects\Country;
use Throwable;

class CountryRequest extends AbstractRequest
{
    public function list(array $params = []): array
    {
        try {
            $data = $this->get('v1/countries', $params);
        } catch (Throwable $th) {
            throw $th;
        }

        return array_map(
            callback: fn(array $item): DataObjectContract => Country::fromArray($item),
            array: $data['data'],
        );
    }
}
