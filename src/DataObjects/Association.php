<?php

namespace VelocitySportsLabs\DataCenter\DataObjects;

use Safe\DateTime;

class Association extends AbstractDataObject
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $name,
        public readonly ?string $shortName,
        public readonly DateTime $createdAt,
        public readonly ?Association $parent = null,
        public readonly ?Country $country = null,
        public readonly ?Discipline $discipline = null,
        public readonly ?Media $logo = null,
        public readonly ?Media $banner = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['uuid'],
            name: $data['name'],
            shortName: $data['short_name'] ?? null,
            createdAt: DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['created_at']),
            parent: array_key_exists('parent', $data) && ! empty($data['parent']) ? Association::fromArray($data['parent']) : null,
            country: array_key_exists('country', $data) && ! empty($data['country']) ? Country::fromArray($data['country']) : null,
            discipline: array_key_exists('discipline', $data) && ! empty($data['discipline']) ? Discipline::fromArray($data['discipline']) : null,
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
            'created_at' => $this->createdAt,
            'parent' => $this->parent?->toArray(),
            'country' => $this->country?->toArray(),
            'discipline' => $this->discipline?->toArray(),
            'logo' => $this->logo?->toArray(),
            'banner' => $this->banner?->toArray(),
        ];
    }
}
