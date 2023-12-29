<?php

namespace FocusSportsLabs\FslDataCenter\Exceptions;

use Exception;
use FocusSportsLabs\FslDataCenter\Exceptions\Contracts\ExceptionContract;

final class InternalServerErrorException extends Exception implements ExceptionContract {}
