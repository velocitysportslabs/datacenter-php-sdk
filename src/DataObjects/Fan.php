<?php

namespace VelocitySportsLabs\DataCenter\DataObjects;

use Exception;
use Safe\DateTime;

class Fan extends AbstractDataObject
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $modelType,
        public readonly DateTime $joinedAt,
        public readonly DateTime $createdAt,
        public readonly ?Profile $profile = null,
        public readonly Club|Organization|null $model = null,
    ) {}

    public static function fromArray(array $data): self
    {
        $model = null;
        if (array_key_exists('model', $data) && ! empty($data['model'])) {
            $model = match ($data['model_type']) {
                'club' => Club::fromArray($data['model']),
                'organization' => Organization::fromArray($data['model']),
                default => throw new Exception('Invalid model type'),
            };
        }

        return new self(
            uuid: $data['uuid'],
            modelType: $data['model_type'],
            joinedAt: DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['joined_at']),
            createdAt: DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['created_at']),
            profile: array_key_exists('profile', $data) && ! empty($data['profile']) ? Profile::fromArray($data['profile']) : null,
            model: $model,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'model_type' => $this->modelType,
            'joined_at' => $this->joinedAt,
            'created_at' => $this->createdAt,
            'profile' => $this->profile?->toArray(),
            'model' => $this->model?->toArray(),
        ];
    }
}
