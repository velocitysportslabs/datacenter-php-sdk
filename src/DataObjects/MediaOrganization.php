<?php

namespace VelocitySportsLabs\DataCenter\DataObjects;

use Safe\DateTime;

class MediaOrganization extends AbstractDataObject
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $name,
        public readonly DateTime $createdAt,
        public readonly ?string $description = null,
        public readonly ?string $website = null,
        public readonly ?string $email = null,
        public readonly ?string $phone = null,
        public readonly ?array $types = null,
        public readonly ?Country $country = null,
        public readonly ?string $region = null,
        public readonly ?string $headquarters = null,
        public readonly ?array $socialMedia = null,
        public readonly ?Media $logo = null,
        public readonly ?Media $banner = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['uuid'],
            name: $data['name'],
            createdAt: DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['created_at']),
            description: $data['description'] ?? null,
            website: $data['website'] ?? null,
            email: $data['email'] ?? null,
            phone: $data['phone'] ?? null,
            types: $data['types'] ?? null,
            country: array_key_exists('country', $data) && ! empty($data['country']) ? Country::fromArray($data['country']) : null,
            region: $data['region'] ?? null,
            headquarters: $data['headquarters'] ?? null,
            socialMedia: $data['social_media'] ?? null,
            logo: array_key_exists('logo', $data) && ! empty($data['logo']) ? Media::fromArray($data['logo']) : null,
            banner: array_key_exists('banner', $data) && ! empty($data['banner']) ? Media::fromArray($data['banner']) : null,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'description' => $this->description,
            'website' => $this->website,
            'email' => $this->email,
            'phone' => $this->phone,
            'types' => $this->types,
            'region' => $this->region,
            'headquarters' => $this->headquarters,
            'social_media' => $this->socialMedia,
            'created_at' => $this->createdAt,
            'country' => $this->country?->toArray(),
            'logo' => $this->logo?->toArray(),
            'banner' => $this->banner?->toArray(),
        ];
    }
}
