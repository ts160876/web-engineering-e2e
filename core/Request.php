<?php

/**
 * Lecture Web Engineering
 */

namespace Bukubuku\Core;

/**
 * The class Request handles HTTP request-related operations.
 */
class Request
{

    /**
     * Get all parameters which were sent via HTTP. Depending on the HTTP method,
     * the respective superglobal is used.
     */
    public function getParameters(): array
    {
        $parameters = [];

        if ($this->getRequestMethod() === 'GET') {
            foreach ($_GET as $key => $value) {
                $parameters[$key] = filter_input(INPUT_GET, $key);
            }
        } else {
            foreach ($_POST as $key => $value) {
                $parameters[$key] = filter_input(INPUT_POST, $key);
            }
        }
        return $parameters;
    }

    /**
     * Get one specific parameter which was sent via HTTP.
     */
    public function getParameter($key): mixed
    {
        return $this->getParameters()[$key] ?? null;
    }

    /**
     * Determine the path of the request. Example:
     * http://localhost/web-engineering-e2e/public/index.php/books/page?page=2
     * Script: /web-engineering-e2e/public/index.php
     * Request URI: /web-engineering-e2e/public/index.php/books/page?page=2
     * Path: /books/page
     */
    public function getPath(): string
    {
        //Remove the script name from the URI.
        $a = $this->getRequestUri();
        $b = $this->getScriptName();
        $path = substr($this->getRequestUri(), strlen($this->getScriptName()));

        /*Remove the query string. Thereto, split the path into an array using '?' as delimiter.
        Use the substring at index 0 of the array.*/
        $path = explode('?', $path)[0];

        //If the path is empty, consider '/' to be the path.
        $path = $path !== '' ? $path : '/';

        return $path;
    }

    /**
     * Determine the request method (GET or POST).
     */
    public function getRequestMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Determine the currently running script.
     * Example: /web-engineering-e2e/public/index.php/books/page?page=2
     */
    public function getRequestUri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * Determine the currently running script.
     */
    public function getScriptName(): string
    {
        return $_SERVER['SCRIPT_NAME'];
    }
}
