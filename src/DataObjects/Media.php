<?php

namespace VelocitySportsLabs\DataCenter\DataObjects;

class Media extends AbstractDataObject
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $name,
        public readonly string $type,
        public readonly ?string $original = null,
        public readonly ?string $optimized = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['uuid'],
            name: $data['name'],
            type: $data['type'],
            original: $data['original'] ?? null,
            optimized: $data['optimized'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'type' => $this->type,
            'original' => $this->original,
            'optimized' => $this->optimized,
        ];
    }
}
