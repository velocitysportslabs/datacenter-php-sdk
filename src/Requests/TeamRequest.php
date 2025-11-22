<?php

namespace VelocitySportsLabs\DataCenter\Requests;

use VelocitySportsLabs\DataCenter\DataObjects\Athlete;
use VelocitySportsLabs\DataCenter\DataObjects\Collection;
use VelocitySportsLabs\DataCenter\DataObjects\Team;

class TeamRequest extends AbstractRequest
{
    public function list(array $params = []): Collection
    {
        return new Collection(
            $this->get('v1/teams', $params),
            Team::class,
        );
    }

    public function retrieve(string $team, array $params = []): Team
    {
        /** @var array $data */
        $data = $this->get("v1/teams/{$team}", $params)['data'];

        return Team::fromArray($data);
    }

    public function retrieveAthletes(string $team, array $params = []): Collection
    {
        return new Collection(
            $this->get("v1/teams/{$team}/athletes", $params),
            Athlete::class,
        );
    }
}
