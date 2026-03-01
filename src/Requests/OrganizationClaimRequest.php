<?php

namespace VelocitySportsLabs\DataCenter\Requests;

use Exception;
use SplFileInfo;
use VelocitySportsLabs\DataCenter\DataObjects\OrganizationClaim;

class OrganizationClaimRequest extends AbstractRequest
{
    /**
     * @throws Exception
     */
    public function create(array $data = [], string|SplFileInfo|null $file = null): OrganizationClaim
    {
        if (null !== $file) {
            $response = $this->postMultipart('v1/organization-claims', $data, ['verification_id_file' => $file]);
        } else {
            $response = $this->post('v1/organization-claims', $data);
        }

        /** @var array $responseData */
        $responseData = $response['data'];

        return OrganizationClaim::fromArray($responseData);
    }
}
