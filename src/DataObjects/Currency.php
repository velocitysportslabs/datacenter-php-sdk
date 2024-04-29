<?php

namespace FocusSportsLabs\FslDataCenter\DataObjects;

class Currency extends AbstractDataObject
{
    public function __construct(
        public readonly string $code,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'],
        );
    }

    public function toArray(): array
    {
        return [
            'code' => $this->code,
        ];
    }
}
