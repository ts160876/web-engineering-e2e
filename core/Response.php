<?php

namespace Bukubuku\Core;

class Response
{

    public function getScriptName(): string
    {
        return $_SERVER['SCRIPT_NAME'];
    }

    public function setResponseCode($code)
    {
        http_response_code($code);
    }

    public function redirect(string $path)
    {
        header('Location: ' . $this->getScriptName() . $path);
    }
}
