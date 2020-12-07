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

    public function login()
    {
        $sidebarMenu = [];

        $filtros = [];

        if (!empty($_POST["email"])) {
            $filtros["email"] = $_POST["email"];
        }

        if (!empty($_POST["senha"])) {
            $filtros["senha"] = $_POST["senha"];
        }

        $usuarios = $this->usuarioModel->read($filtros);

        if (count($usuarios) > 0) {
            $usuario = $usuarios[0];

            $sidebarMenu = [
                [
                    "id" => "pessoas",
                    "cabecalho" => "Pessoas",
                    "subMenu1" =>
                    [
                        [
                            "id" => "usuarios",
                            "cabecalho" => "Usuários",
                            "icon" => "fas fa-fw fa-cog",
                            "subTitulo" => "Gestão de Usuários",
                            "subMenu2" =>
                            [
                                [
                                    "nome" => "Listar",
                                    "class" => "collapse-item",
                                    "url" => BASE . "usuario"
                                ],
                                [
                                    "nome" => "Criar",
                                    "class" => "collapse-item",
                                    "url" => BASE . "usuario/create2"
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    "id" => "receitas",
                    "cabecalho" => "Receitas",
                    "subMenu1" =>
                    [
                        [
                            "id" => "categorias",
                            "cabecalho" => "Categorias",
                            "icon" => "fas fa-fw fa-cog",
                            "subTitulo" => "Gestão de Categorias",
                            "subMenu2" =>
                            [
                                [
                                    "nome" => "Listar",
                                    "class" => "collapse-item",
                                    "url" => "buttons.html"
                                ],
                                [
                                    "nome" => "Criar",
                                    "class" => "collapse-item",
                                    "url" => "cards.html"
                                ]
                            ]
                        ],
                        [
                            "id" => "receitas",
                            "cabecalho" => "Receitas",
                            "icon" => "fas fa-fw fa-cog",
                            "subTitulo" => "Gestão de Receitas",
                            "subMenu2" =>
                            [
                                [
                                    "nome" => "Listar",
                                    "class" => "collapse-item",
                                    "url" => "buttons.html"
                                ],
                                [
                                    "nome" => "Criar",
                                    "class" => "collapse-item",
                                    "url" => "cards.html"
                                ]
                            ]
                        ]
                    ]
                ]
            ];

            $_SESSION["SidebarMenu"] = $sidebarMenu;

            $_SESSION["Usuario"] = [
                "nome" => $usuario->nome,
                "sobrenome" => $usuario->sobrenome,
            ];

            header('Location: ' . BASE);
        } else {
            $this->load("auth/main", [
                'response' =>
                [
                    "pageTitle" => "Autenticação",
                    "message" => [
                        "success" => false,
                        "description" => "Usuário e/ou senha inválidos."
                    ]
                ]
            ]);
        }         
    }

    public function logout()
    {
        unset($_SESSION["SidebarMenu"]);
        unset($_SESSION["Usuario"]);

        session_destroy();

        header('Location: ' . BASE . "auth");
    }
}
