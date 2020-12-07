<?php

namespace app\site\controller;
use app\core\Controller;
use app\site\model\UsuarioModel;
use app\site\entities\Usuario;

class AuthController extends Controller
{
    private $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function read()
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

        $filtros = [];

        if(!empty($_POST["email"])){
            $filtros["email"] = $_POST["email"];
        } 

        if(!empty($_POST["senha"])){
            $filtros["senha"] = $_POST["senha"];
        } 

        $usuarios = $this->usuarioModel->read($filtros);

        if(count($usuarios) > 0){
            $usuario = $usuarios[0];

            $_SESSION["Usuario"] = [
                "nome" => $usuario->nome,
                "sobrenome" => $usuario->sobrenome,
            ];
        }       

        header('Location: ' . BASE);        
    }

    public function logout(){
        unset($_SESSION["SidebarMenu"]);
        unset($_SESSION["Usuario"]);

        session_destroy();

        header('Location: ' . BASE . "auth");        
    }
}