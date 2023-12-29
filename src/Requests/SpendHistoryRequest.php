<?php

namespace FocusSportsLabs\FslDataCenter\Requests;

use FocusSportsLabs\FslDataCenter\DataObjects\SpendHistory;

class SpendHistoryRequest extends AbstractRequest
{
    public function create(array $data = []): SpendHistory
    {
        /** @var array */
        $data = $this->post('v1/spend-histories', $data)['data'];

        return SpendHistory::fromArray($data);
    }

    public function update(string $id, array $data = []): SpendHistory
    {
        /** @var array */
        $data = $this->patch("v1/spend-histories/{$id}", $data)['data'];

        return SpendHistory::fromArray($data);
    }

    public function remove(string $id): array
    {
        /** @var array */
        return $this->delete("v1/spend-histories/{$id}");
    }
}
