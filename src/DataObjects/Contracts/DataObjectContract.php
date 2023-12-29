<?php

namespace FocusSportsLabs\FslDataCenter\DataObjects\Contracts;

interface DataObjectContract
{
    public static function fromArray(array $data): self;

    public function toArray(): array;
}
