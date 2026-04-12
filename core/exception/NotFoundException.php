<?php

/**
 * Lecture Web Engineering
 */

namespace Bukubuku\Core\exception;

/**
 * The class NotFoundException is used for exception handling.
 * It is thrown when a path cannot be executed.
 */
class NotFoundException extends \Exception
{
    protected $message = 'Not found';
    protected $code = 404;
}
