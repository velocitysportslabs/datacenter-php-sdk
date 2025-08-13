<?php

namespace VelocitySportsLabs\DataCenter\Requests;

use VelocitySportsLabs\DataCenter\DataObjects\Athlete;
use VelocitySportsLabs\DataCenter\DataObjects\Club;
use VelocitySportsLabs\DataCenter\DataObjects\Collection;
use VelocitySportsLabs\DataCenter\DataObjects\Team;

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

    public function retrieveAthletes(string $club, array $params = []): Collection
    {
        return new Collection(
            $this->get("v1/clubs/{$club}/athletes", $params),
            Athlete::class,
        );
    }
}
