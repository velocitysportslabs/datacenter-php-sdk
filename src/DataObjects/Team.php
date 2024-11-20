<?php

namespace VelocitySportsLabs\DataCenter\DataObjects;

use Safe\DateTime;

class Team extends AbstractDataObject
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $name,
        public readonly ?string $shortName,
        public readonly string $gender,
        public readonly ?DateTime $createdAt,
        public readonly ?Club $club = null,
        public readonly ?Division $division = null,
        public readonly ?Media $logo = null,
        public readonly ?Media $banner = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['uuid'],
            name: $data['name'],
            shortName: $data['short_name'] ?? null,
            gender: $data['gender'],
            createdAt: array_key_exists('created_at', $data) && ! empty($data['created_at']) ? DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['created_at']) : null,
            club: array_key_exists('club', $data) && ! empty($data['club']) ? Club::fromArray($data['club']) : null,
            division: array_key_exists('division', $data) && ! empty($data['division']) ? Division::fromArray($data['division']) : null,
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
            'gender' => $this->gender,
            'created_at' => $this->createdAt,
            'club' => $this->club?->toArray(),
            'division' => $this->division?->toArray(),
            'logo' => $this->logo?->toArray(),
            'banner' => $this->banner?->toArray(),
        ];
    }
}
