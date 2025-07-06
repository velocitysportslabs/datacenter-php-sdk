<?php

namespace VelocitySportsLabs\DataCenter\DataObjects;

use Exception;
use Safe\DateTime;

class OrganizationRequest extends AbstractDataObject
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $organizationName,
        public readonly ?string $modelType,
        public readonly ?string $type,
        public readonly string $location,
        public readonly string $name,
        public readonly string $email,
        public readonly string $phone,
        public readonly ?string $status,
        public readonly ?array $reasons,
        public readonly DateTime $createdAt,
        public readonly Club|Organization|Association|null $model = null,
    ) {}

    public static function fromArray(array $data): self
    {
        $model = null;
        if (array_key_exists('model', $data) && ! empty($data['model'])) {
            $model = match ($data['model_type']) {
                'association' => Association::fromArray($data['model']),
                'club' => Club::fromArray($data['model']),
                'organization' => Organization::fromArray($data['model']),
                default => throw new Exception('Invalid model type'),
            };
        }

        return new self(
            uuid: $data['uuid'],
            organizationName: $data['organization_name'],
            modelType: $data['model_type'] ?? null,
            type: $data['type'] ?? [],
            location: $data['location'],
            name: $data['name'],
            email: $data['email'],
            phone: $data['phone'],
            status: $data['status'] ?? null,
            reasons: $data['reasons'] ?? null,
            createdAt: DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['created_at']),
            model: $model,
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'organization_name' => $this->organizationName,
            'model_type' => $this->modelType,
            'type' => $this->type,
            'location' => $this->location,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'reasons' => $this->reasons,
            'created_at' => $this->createdAt,
            'model' => $this->model?->toArray(),
        ];
    }
}
