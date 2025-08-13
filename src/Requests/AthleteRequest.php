<?php

namespace VelocitySportsLabs\DataCenter\Requests;

use VelocitySportsLabs\DataCenter\DataObjects\Athlete;
use VelocitySportsLabs\DataCenter\DataObjects\CareerInfo;
use VelocitySportsLabs\DataCenter\DataObjects\Club;
use VelocitySportsLabs\DataCenter\DataObjects\Collection;

class AthleteRequest extends AbstractRequest
{
    public function list(array $params = []): Collection
    {
        return new Collection(
            $this->get('v1/athletes', $params),
            Athlete::class,
        );
    }

    public function retrieve(string $athlete, array $params = []): Athlete
    {
        /** @var array */
        $data = $this->get("v1/athletes/{$athlete}", $params)['data'];

        return Athlete::fromArray($data);
    }

    public function retrieveClubs(string $athlete, array $params = []): Collection
    {
        return new Collection(
            $this->get("v1/athletes/{$athlete}/clubs", $params),
            Club::class,
        );
    }

    public function retrieveCareerPath(string $athlete, array $params = []): Collection
    {
        return new Collection(
            $this->get("v1/athletes/{$athlete}/career-path", $params),
            CareerInfo::class,
        );
    }
}
