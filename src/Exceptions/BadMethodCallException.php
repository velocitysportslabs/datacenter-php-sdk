<?php

namespace VelocitySportsLabs\DataCenter\Exceptions;

use VelocitySportsLabs\DataCenter\Exceptions\Contracts\ExceptionContract;

class BadMethodCallException extends \BadMethodCallException implements ExceptionContract {}
