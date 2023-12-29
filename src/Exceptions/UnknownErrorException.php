<?php

namespace FocusSportsLabs\FslDataCenter\Exceptions;

use Exception;
use FocusSportsLabs\FslDataCenter\Exceptions\Contracts\ExceptionContract;

final class UnknownErrorException extends Exception implements ExceptionContract
{
    public function __construct(
        string $message,
        int $code,
        public readonly array $jsonData,
    ) {
        parent::__construct(
            message: $message,
            code: $code,
        );
    }
}
