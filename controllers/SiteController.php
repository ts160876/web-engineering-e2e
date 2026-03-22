<?php

namespace Bukubuku\Controllers;

use Bukubuku\Core\Controller;

class SiteController extends Controller
{
    public function home(): string
    {
        $parameters = ['name' => 'BukuBuku'];
        return $this->renderView('home', $parameters);
    }

    public function contact(): string
    {
        return $this->renderView('contact');
    }

    public function handleContact(): string
    {
        return 'Processing your contact request.';
    }
}
