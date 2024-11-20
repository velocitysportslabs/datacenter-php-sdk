<?php

namespace VelocitySportsLabs\DataCenter\Exceptions;

use Exception;
use VelocitySportsLabs\DataCenter\Exceptions\Contracts\ExceptionContract;

final class ForbiddenException extends Exception implements ExceptionContract {}
