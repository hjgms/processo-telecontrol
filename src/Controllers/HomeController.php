<?php

namespace App\Controllers;

use App\Utils\Navigation;
use App\Core\Request;
use App\Core\Response;

class HomeController
{
    public function login(Request $request, Response $response)
    {
      $response->view('login');
    }

    public function dashboard(Request $request, Response $response)
    {
      $response->view('dashboard');
    }
}