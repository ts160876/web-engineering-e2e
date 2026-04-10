<?php

namespace Bukubuku\Core\exception;

class InternalErrorException extends \Exception
{
    protected $message = 'Internal Server Error';
    protected $code = 500;
}
