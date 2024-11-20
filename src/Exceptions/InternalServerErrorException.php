<?php

namespace VelocitySportsLabs\DataCenter\Exceptions;

use Exception;
use VelocitySportsLabs\DataCenter\Exceptions\Contracts\ExceptionContract;

final class InternalServerErrorException extends Exception implements ExceptionContract {}
