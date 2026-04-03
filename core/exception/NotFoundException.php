<?php

namespace Bukubuku\Core\exception;

class NotFoundException extends \Exception
{
    protected $message = 'Not found';
    protected $code = 404;
}
