<?php

namespace Bukubuku\Core;

class Response
{
    public function setResponseCode($code)
    {
        http_response_code($code);
    }
}
