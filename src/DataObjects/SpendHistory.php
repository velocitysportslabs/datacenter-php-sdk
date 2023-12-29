<?php

namespace FocusSportsLabs\FslDataCenter\DataObjects;

use Exception;
use Safe\DateTime;

class SpendHistory extends AbstractDataObject
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $modelType,
        public readonly string $referenceNo,
        public float|int $amount,
        public ?array $extraDetails,
        public readonly DateTime $purchasedAt,
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
            referenceNo: $data['reference_no'],
            amount: $data['amount'],
            extraDetails: $data['extra_details'],
            purchasedAt: DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['purchased_at']),
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
            'reference_no' => $this->referenceNo,
            'amount' => $this->amount,
            'extra_details' => $this->extraDetails,
            'purchased_at' => $this->purchasedAt,
            'created_at' => $this->createdAt,
            'profile' => $this->profile?->toArray(),
            'model' => $this->model?->toArray(),
        ];
    }
}
