<?php

namespace Bukubuku\Core\exception;

class DatabaseException extends \Exception
{
    protected $message = 'Database Error';
    protected $code = 500;
}
