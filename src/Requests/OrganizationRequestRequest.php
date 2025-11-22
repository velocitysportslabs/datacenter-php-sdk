<?php

namespace VelocitySportsLabs\DataCenter\Requests;

use VelocitySportsLabs\DataCenter\DataObjects\OrganizationRequest;

class OrganizationRequestRequest extends AbstractRequest
{
    public function create(array $data = []): OrganizationRequest
    {
        /** @var array $data */
        $data = $this->post('v1/organization-requests', $data)['data'];

        return OrganizationRequest::fromArray($data);
    }
}
