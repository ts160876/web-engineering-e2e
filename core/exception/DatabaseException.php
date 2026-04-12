<?php

/**
 * Lecture Web Engineering
 */

namespace Bukubuku\Core\exception;

/**
 * The class DatabaseException is used for exception handling.
 * It captures unexpected errors during database access.
 */
class DatabaseException extends \Exception
{
    protected $message = 'Database Error';
    protected $code = 500;
}
