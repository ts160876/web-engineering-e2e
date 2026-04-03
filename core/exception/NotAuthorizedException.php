<?php

namespace Bukubuku\Core\exception;

class NotAuthorizedException extends \Exception
{
    protected $message = 'Not authorized';
    protected $code = 403;
}
