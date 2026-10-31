<?php

use VelocitySportsLabs\DataCenter\DataObjects\OrganizationRequest;
use VelocitySportsLabs\DataCenter\DataObjects\Team;

it('builds a team organization request with its team model', function (): void {
    $request = OrganizationRequest::fromArray([
        'uuid' => 'f1b2c3d4-0000-4000-8000-000000000001',
        'organization_name' => 'Accra Lions U19',
        'model_type' => 'team',
        'type' => 'team',
        'location' => null,
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'status' => 'approved',
        'reasons' => [],
        'created_at' => '2026-10-31T10:00:00.000000Z',
        'model' => [
            'uuid' => 'f1b2c3d4-0000-4000-8000-000000000002',
            'name' => 'Accra Lions U19',
            'gender' => 'male',
        ],
    ]);

    expect($request->modelType)->toBe('team')
        ->and($request->model)->toBeInstanceOf(Team::class)
        ->and($request->model?->uuid)->toBe('f1b2c3d4-0000-4000-8000-000000000002')
        ->and($request->toArray()['model']['name'])->toBe('Accra Lions U19');
});

it('still refuses an unknown model type', function (): void {
    OrganizationRequest::fromArray([
        'uuid' => 'f1b2c3d4-0000-4000-8000-000000000001',
        'organization_name' => 'Somewhere',
        'model_type' => 'venue',
        'type' => 'team',
        'location' => null,
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'reasons' => [],
        'created_at' => '2026-10-31T10:00:00.000000Z',
        'model' => ['uuid' => 'x'],
    ]);
})->throws(Exception::class, 'Invalid model type');

it('accepts a request without a type', function (): void {
    $request = OrganizationRequest::fromArray([
        'uuid' => 'f1b2c3d4-0000-4000-8000-000000000001',
        'organization_name' => 'Accra Lions',
        'model_type' => null,
        'location' => null,
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'reasons' => [],
        'created_at' => '2026-10-31T10:00:00.000000Z',
    ]);

    expect($request->type)->toBeNull();
});
