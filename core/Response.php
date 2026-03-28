<?php

namespace Bukubuku\Core;

class Response
{
    public function setResponseCode($code)
    {
        http_response_code($code);
    }

    public function redirect(string $url)
    {
        header('Location: ' . $url);
    }
}
