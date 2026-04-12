<?php

/**
 * Lecture Web Engineering
 */

namespace Bukubuku\Core;

/**
 * The class Controller represents a controller. It cannot be instantiated.
 * All concrete controllers can be found in the /controllers folder.
 */
abstract class Controller
{
    //Create a new view and render it.
    public function renderView($view, $parameters = []): string
    {
        return (new View())->render($view, $parameters);
    }
}
