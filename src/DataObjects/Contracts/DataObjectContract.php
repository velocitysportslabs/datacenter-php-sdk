<?php

namespace VelocitySportsLabs\DataCenter\DataObjects\Contracts;

interface DataObjectContract
{
    public static function fromArray(array $data): self;

    public function toArray(): array;
}
