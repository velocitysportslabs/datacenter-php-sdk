<?php

namespace FocusSportsLabs\FslDataCenter\Requests;

use FocusSportsLabs\FslDataCenter\DataObjects\CareerInfo;
use FocusSportsLabs\FslDataCenter\DataObjects\Club;
use FocusSportsLabs\FslDataCenter\DataObjects\Collection;
use FocusSportsLabs\FslDataCenter\DataObjects\Player;

class PlayerRequest extends AbstractRequest
{
    public function list(array $params = []): Collection
    {
        return new Collection(
            $this->get('v1/players', $params),
            Player::class
        );
    }

    public function retrieve(string $player, array $params = []): Player
    {
        /** @var array */
        $data = $this->get("v1/players/{$player}", $params)['data'];

        return Player::fromArray($data);
    }

    public function retrieveClubs(string $player, array $params = []): Collection
    {
        return new Collection(
            $this->get("v1/players/{$player}/clubs", $params),
            Club::class
        );
    }

    public function retrieveCareerPath(string $player, array $params = []): Collection
    {
        return new Collection(
            $this->get("v1/players/{$player}/career-path", $params),
            CareerInfo::class
        );
    }
}
