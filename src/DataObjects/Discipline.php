<?php

namespace VelocitySportsLabs\DataCenter\DataObjects;

use Safe\DateTime;

class Discipline extends AbstractDataObject
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $name,
        public readonly ?string $description,
        public readonly DateTime $createdAt,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['uuid'],
            name: $data['name'],
            description: $data['description'] ?? null,
            createdAt: DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['created_at']),
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'description' => $this->description,
            'created_at' => $this->createdAt,
        ];
    }
}
