<?php

namespace VelocitySportsLabs\DataCenter\DataObjects;

use Safe\DateTime;

class Profile extends AbstractDataObject
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $profileID,
        public readonly string $name,
        public readonly DateTime $createdAt,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['uuid'],
            profileID: $data['profile_id'],
            name: $data['name'],
            createdAt: DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['created_at']),
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'profile_id' => $this->profileID,
            'name' => $this->name,
            'created_at' => $this->createdAt,
        ];
    }
}
