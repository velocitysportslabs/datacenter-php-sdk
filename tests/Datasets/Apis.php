<?php

use VelocitySportsLabs\DataCenter\Requests;

dataset('apis', [
    ['associations', Requests\AssociationRequest::class],
    ['clubs', Requests\ClubRequest::class],
    ['countries', Requests\CountryRequest::class],
    ['currencies', Requests\CurrencyRequest::class],
    ['disciplines', Requests\DisciplineRequest::class],
    ['divisions', Requests\DivisionRequest::class],
    ['fans', Requests\FanRequest::class],
    ['organizations', Requests\OrganizationRequest::class],
    ['organizationRequests', Requests\OrganizationRequestRequest::class],
    ['players', Requests\PlayerRequest::class],
    ['profiles', Requests\ProfileRequest::class],
    ['spendHistories', Requests\SpendHistoryRequest::class],
    ['teams', Requests\TeamRequest::class],
]);
