<?php

namespace Uxicodev\UnifiAccessApi\Exceptions;

use Exception;
use Illuminate\Contracts\Support\MessageBag;
use Throwable;

class ValidationException extends Exception
{
    public function __construct(public MessageBag $errors, string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
