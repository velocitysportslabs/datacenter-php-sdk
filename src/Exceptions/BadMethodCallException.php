<?php

namespace FocusSportsLabs\FslDataCenter\Exceptions;

use FocusSportsLabs\FslDataCenter\Exceptions\Contracts\ExceptionContract;

class BadMethodCallException extends \BadMethodCallException implements ExceptionContract {}
