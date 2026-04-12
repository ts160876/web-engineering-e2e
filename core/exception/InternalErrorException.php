<?php

/**
 * Lecture Web Engineering
 */

namespace Bukubuku\Core\exception;

/**
 * The class InternalErrorException is used for exception handling.
 * It captures unexpected errors not captured by any other more specific exception.
 */
class InternalErrorException extends \Exception
{
    protected $message = 'Internal Server Error';
    protected $code = 500;
}
