<?php

namespace FocusSportsLabs\FslDataCenter\DataObjects;

use Safe\DateTime;

class CareerInfo extends AbstractDataObject
{
    public function __construct(
        public readonly string $uuid,
        public readonly DateTime $startAt,
        public readonly ?DateTime $endAt = null,
        public readonly ?Club $club = null,
        public readonly ?Team $team = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['uuid'],
            startAt: DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['start_at']),
            endAt: array_key_exists('end_at', $data) && ! empty($data['end_at']) ? DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['end_at']) : null,
            club: array_key_exists('club', $data) && ! empty($data['club']) ? Club::fromArray($data['club']) : null,
            team: array_key_exists('team', $data) && ! empty($data['team']) ? Team::fromArray($data['team']) : null,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'start_at' => $this->startAt,
            'end_at' => $this->endAt,
            'club' => $this->club?->toArray(),
            'team' => $this->team?->toArray(),
        ];
    }
}
