<?php

namespace FocusSportsLabs\FslDataCenter\Requests;

use FocusSportsLabs\FslDataCenter\DataObjects\Club;
use FocusSportsLabs\FslDataCenter\DataObjects\Collection;
use FocusSportsLabs\FslDataCenter\DataObjects\Player;
use FocusSportsLabs\FslDataCenter\DataObjects\Team;

class ClubRequest extends AbstractRequest
{
    public function list(array $params = []): Collection
    {
        return new Collection(
            $this->get('v1/clubs', $params),
            Club::class,
        );
    }

    public function retrieve(string $club, array $params = []): Club
    {
        /** @var array */
        $data = $this->get("v1/clubs/{$club}", $params)['data'];

        return Club::fromArray($data);
    }

    public function retrieveTeams(string $club, array $params = []): Collection
    {
        return new Collection(
            $this->get("v1/clubs/{$club}/teams", $params),
            Team::class,
        );
    }

    public function retrievePlayers(string $club, array $params = []): Collection
    {
        return new Collection(
            $this->get("v1/clubs/{$club}/players", $params),
            Player::class,
        );
    }
}
