<?php

namespace VelocitySportsLabs\DataCenter\DataObjects;

use Safe\DateTime;

class Athlete extends AbstractDataObject
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $name,
        public readonly ?string $legalName,
        public readonly ?array $nicknames,
        public readonly string $gender,
        public readonly DateTime $dateOfBirth,
        public readonly array $age,
        public readonly float $height,
        public readonly float $weight,
        public readonly string $dominantSide,
        public readonly ?string $bio,
        public readonly ?DateTime $startAt,
        public readonly ?DateTime $endAt,
        public readonly ?string $status,
        public readonly DateTime $createdAt,
        public readonly ?Country $countryOfBirth = null,
        public readonly ?Country $nationality = null,
        public readonly ?Club $currentClub = null,
        public readonly ?Team $team = null,
        public readonly ?Media $logo = null,
        public readonly ?Media $banner = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['uuid'],
            name: $data['name'],
            legalName: $data['legal_name'] ?? null,
            nicknames: $data['nicknames'] ?? [],
            gender: $data['gender'],
            dateOfBirth: DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['date_of_birth']),
            age: $data['age'],
            height: $data['height'],
            weight: $data['weight'],
            dominantSide: $data['dominant_side'],
            bio: $data['bio'] ?? null,
            startAt: array_key_exists('start_at', $data) && null !== $data['start_at'] ? DateTime::createFromFormat('Y-m-d H:i:s', $data['start_at']) : null,
            endAt: array_key_exists('end_at', $data) && null !== $data['end_at'] ? DateTime::createFromFormat('Y-m-d H:i:s', $data['end_at']) : null,
            status: $data['status'] ?? null,
            createdAt: DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['created_at']),
            countryOfBirth: array_key_exists('country_of_birth', $data) && ! empty($data['country_of_birth']) ? Country::fromArray($data['country_of_birth']) : null,
            nationality: array_key_exists('nationality', $data) && ! empty($data['nationality']) ? Country::fromArray($data['nationality']) : null,
            currentClub: array_key_exists('current_club', $data) && ! empty($data['current_club']) ? Club::fromArray($data['current_club']) : null,
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
            'legal_name' => $this->legalName,
            'nicknames' => $this->nicknames,
            'gender' => $this->gender,
            'date_of_birth' => $this->dateOfBirth,
            'age' => $this->age,
            'height' => $this->height,
            'weight' => $this->weight,
            'dominant_side' => $this->dominantSide,
            'bio' => $this->bio,
            'start_at' => $this->startAt,
            'end_at' => $this->endAt,
            'status' => $this->status,
            'created_at' => $this->createdAt,
            'country_of_birth' => $this->countryOfBirth?->toArray(),
            'nationality' => $this->nationality?->toArray(),
            'current_club' => $this->currentClub?->toArray(),
            'team' => $this->team?->toArray(),
            'logo' => $this->logo?->toArray(),
            'banner' => $this->banner?->toArray(),
        ];
    }
}
