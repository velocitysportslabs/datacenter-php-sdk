<?php

namespace VelocitySportsLabs\DataCenter\Requests;

use Exception;
use VelocitySportsLabs\DataCenter\DataObjects\SpendHistory;

class SpendHistoryRequest extends AbstractRequest
{
    /**
     * @throws Exception
     */
    public function create(array $data = []): SpendHistory
    {
        /** @var array $data */
        $data = $this->post('v1/spend-histories', $data)['data'];

        return SpendHistory::fromArray($data);
    }

    /**
     * @throws Exception
     */
    public function update(string $id, array $data = []): SpendHistory
    {
        /** @var array $data */
        $data = $this->patch("v1/spend-histories/{$id}", $data)['data'];

        return SpendHistory::fromArray($data);
    }

    public function remove(string $id): array
    {
        /** @var array */
        return $this->delete("v1/spend-histories/{$id}");
    }
}
