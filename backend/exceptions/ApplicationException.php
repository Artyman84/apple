<?php

namespace backend\exceptions;

use Exception;
use Throwable;

class ApplicationException extends Exception
{
    public function __construct($message = "", Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }

    public function getName(): string
    {
        return substr(static::class, strrpos(static::class, '\\') + 1);
    }
}
