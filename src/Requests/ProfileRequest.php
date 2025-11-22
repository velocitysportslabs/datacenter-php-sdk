<?php

namespace VelocitySportsLabs\DataCenter\Requests;

use VelocitySportsLabs\DataCenter\DataObjects\Profile;

class ProfileRequest extends AbstractRequest
{
    public function create(array $data = []): Profile
    {
        /** @var array $data */
        $data = $this->post('v1/profiles', $data)['data'];

        return Profile::fromArray($data);
    }

    public function update(string $profile, array $data = []): Profile
    {
        /** @var array $data */
        $data = $this->patch("v1/profiles/{$profile}", $data)['data'];

        return Profile::fromArray($data);
    }
}
