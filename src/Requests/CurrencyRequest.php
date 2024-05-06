<?php

namespace FocusSportsLabs\FslDataCenter\Requests;

use FocusSportsLabs\FslDataCenter\DataObjects\Collection;
use FocusSportsLabs\FslDataCenter\DataObjects\Currency;

class CurrencyRequest extends AbstractRequest
{
    public function all(): Collection
    {
        return new Collection(
            $this->get('v1/currencies'),
            Currency::class,
        );
    }
}
