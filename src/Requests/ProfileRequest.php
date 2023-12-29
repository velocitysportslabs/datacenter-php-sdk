<?php

namespace FocusSportsLabs\FslDataCenter\Requests;

use FocusSportsLabs\FslDataCenter\DataObjects\Profile;

class ProfileRequest extends AbstractRequest
{
    public function create(array $data = []): Profile
    {
        /** @var array */
        $data = $this->post('v1/profiles', $data)['data'];

        return Profile::fromArray($data);
    }

    public function update(string $profile, array $data = []): Profile
    {
        /** @var array */
        $data = $this->patch("v1/profiles/{$profile}", $data)['data'];

        return Profile::fromArray($data);
    }
}
