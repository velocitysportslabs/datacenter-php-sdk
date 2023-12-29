<?php

namespace FocusSportsLabs\FslDataCenter\DataObjects;

use Safe\DateTime;

class Club extends AbstractDataObject
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $name,
        public readonly ?string $shortName,
        public readonly DateTime $createdAt,
        public readonly ?Organization $organization = null,
        public readonly ?Association $association = null,
        public readonly ?Discipline $discipline = null,
        public readonly ?Team $team = null,
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
            organization: array_key_exists('organization', $data) && ! empty($data['organization']) ? Organization::fromArray($data['organization']) : null,
            association: array_key_exists('association', $data) && ! empty($data['association']) ? Association::fromArray($data['association']) : null,
            discipline: array_key_exists('discipline', $data) && ! empty($data['discipline']) ? Discipline::fromArray($data['discipline']) : null,
            team: array_key_exists('team', $data) && ! empty($data['team']) ? Team::fromArray($data['team']) : null,
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
            'organization' => $this->organization?->toArray(),
            'association' => $this->association?->toArray(),
            'discipline' => $this->discipline?->toArray(),
            'team' => $this->team?->toArray(),
            'logo' => $this->logo?->toArray(),
            'banner' => $this->banner?->toArray(),
        ];
    }
}
