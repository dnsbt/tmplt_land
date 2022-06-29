<?php

namespace App\Exceptions;

use Exception;

class FileRelationException extends Exception
{
    public function __construct($message = "File used!", $code = 500, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
