<?php

namespace VelocitySportsLabs\DataCenter\DataObjects;

use Safe\DateTime;

class Organization extends AbstractDataObject
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $name,
        public readonly DateTime $createdAt,
        public readonly ?string $shortName,
        public readonly ?array $types = null,
        public readonly ?Country $country = null,
        public readonly ?Media $logo = null,
        public readonly ?Media $banner = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['uuid'],
            name: $data['name'],
            createdAt: DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['created_at']),
            shortName: $data['short_name'] ?? null,
            types: $data['types'] ?? null,
            country: array_key_exists('country', $data) && ! empty($data['country']) ? Country::fromArray($data['country']) : null,
            logo: array_key_exists('logo', $data) && ! empty($data['logo']) ? Media::fromArray($data['logo']) : null,
            banner: array_key_exists('banner', $data) && ! empty($data['banner']) ? Media::fromArray($data['banner']) : null,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'short_name' => $this->shortName,
            'types' => $this->types,
            'created_at' => $this->createdAt,
            'country' => $this->country?->toArray(),
            'logo' => $this->logo?->toArray(),
            'banner' => $this->banner?->toArray(),
        ];
    }
}
