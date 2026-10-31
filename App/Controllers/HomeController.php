<?php

namespace App\Controllers;

use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

// AI-assisted integration of existing pages into Vaiicko MVC.
class HomeController extends BaseController
{
    public function index(Request $request): Response
    {
        return $this->html();
    }

    public function detail(Request $request): Response
    {
        return $this->html();
    }
}
