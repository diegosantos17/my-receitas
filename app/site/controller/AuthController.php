<?php

namespace app\site\controller;
use app\core\Controller;

class AuthController extends Controller
{
    public function index()
    {
        $this->load("auth/main", [
            'response' =>
            [
                "pageTitle" => 'Login'
            ]
        ]);
    }

    public function login(){
        $_SESSION["SidebarMenu"] = [
            [
                "id" => "interface",
                "cabecalho" => "Interface",
                "subMenu1" =>
                [
                    [
                        "id" => "Componentes",
                        "cabecalho" => "Componentes",
                        "icon" => "fas fa-fw fa-cog",
                        "subTitulo" => "CUSTOM COMPONENTS:",
                        "subMenu2" =>
                        [
                            [
                                "nome" => "Buttons",
                                "class" => "collapse-item",
                                "url" => "buttons.html"
                            ],
                            [
                                "nome" => "Cards",
                                "class" => "collapse-item",
                                "url" => "cards.html"
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $_SESSION["Usuario"] = [
            "nome" => "Diego Rodrigues"
        ];

        header('Location: ' . BASE);        
    }

    public function logout(){
        unset($_SESSION["SidebarMenu"]);
        unset($_SESSION["Usuario"]);

        session_destroy();

        header('Location: ' . BASE . "auth");        
    }
}