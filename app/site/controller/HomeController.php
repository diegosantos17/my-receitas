<?php

namespace app\site\controller;

use app\core\Controller;


class HomeController extends Controller
{
    public function read()
    {
        $this->load("home/main", [
            'response' =>
            [
                "pageTitle" => "Home Page"
            ]
        ]);
    }
}