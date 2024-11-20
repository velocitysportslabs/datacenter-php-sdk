<?php

namespace VelocitySportsLabs\DataCenter\Exceptions;

use Exception;
use VelocitySportsLabs\DataCenter\Exceptions\Contracts\ExceptionContract;

final class RateLimitExceededException extends Exception implements ExceptionContract
{
    public function __construct(
        string $message,
        int $code,
        public readonly int $rateLimitLimit,
        public readonly int $rateLimitRemaining,
        public readonly int $rateLimitRetryAfter,
    ) {
        parent::__construct(
            message: $message,
            code: $code,
        );
    }
}
