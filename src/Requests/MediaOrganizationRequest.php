<?php

namespace VelocitySportsLabs\DataCenter\Requests;

use VelocitySportsLabs\DataCenter\DataObjects\Collection;
use VelocitySportsLabs\DataCenter\DataObjects\MediaOrganization;

class MediaOrganizationRequest extends AbstractRequest
{
    public function list(array $params = []): Collection
    {
        return new Collection(
            $this->get('v1/media-organizations', $params),
            MediaOrganization::class,
        );
    }

    public function retrieve(string $mediaOrganization, array $params = []): MediaOrganization
    {
        /** @var array $data */
        $data = $this->get("v1/media-organizations/{$mediaOrganization}", $params)['data'];

        return MediaOrganization::fromArray($data);
    }
}
