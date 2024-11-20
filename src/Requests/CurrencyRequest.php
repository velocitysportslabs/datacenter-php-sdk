<?php

namespace VelocitySportsLabs\DataCenter\Requests;

use VelocitySportsLabs\DataCenter\DataObjects\Collection;
use VelocitySportsLabs\DataCenter\DataObjects\Currency;

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
