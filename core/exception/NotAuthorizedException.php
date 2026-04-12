<?php

/**
 * Lecture Web Engineering
 */

namespace Bukubuku\Core\exception;

/**
 * The class NotAuthorizedException is used for exception handling.
 * It is thrown when the user is not authorized to access a path.
 */
class NotAuthorizedException extends \Exception
{
    protected $message = 'Not authorized';
    protected $code = 403;
}
