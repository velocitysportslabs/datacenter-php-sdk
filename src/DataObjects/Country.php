<?php

namespace FocusSportsLabs\FslDataCenter\DataObjects;

use Safe\DateTime;

class Country extends AbstractDataObject
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $name,
        public readonly string $alpha2Code,
        public readonly string $alpha3Code,
        public readonly string $nationality,
        public readonly DateTime $createdAt,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['uuid'],
            name: $data['name'],
            alpha2Code: $data['alpha_2_code'],
            alpha3Code: $data['alpha_3_code'],
            nationality: $data['nationality'],
            createdAt: DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['created_at']),
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'alpha_2_code' => $this->alpha2Code,
            'alpha_3_code' => $this->alpha3Code,
            'nationality' => $this->nationality,
            'created_at' => $this->createdAt,
        ];
    }
}
