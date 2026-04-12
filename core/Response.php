<?php

/**
 * Lecture Web Engineering
 */

namespace Bukubuku\Core;

/**
 * The class Response handles HTTP response-related operations.
 */
class Response
{

    /**
     * Determine the currently running script.
     */
    public function getScriptName(): string
    {
        return $_SERVER['SCRIPT_NAME'];
    }

    /**
     * Redirect the client to a different path.
     */
    public function redirect(string $path): void
    {
        header('Location: ' . $this->getScriptName() . $path);
    }

    /**
     * Set the HTTP response code
     */
    public function setResponseCode(int $code): void
    {
        http_response_code($code);
    }
}
