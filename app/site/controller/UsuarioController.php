<?php

namespace app\site\controller;

use app\core\Controller;
use app\crosscuting\Email;
use app\crosscuting\Log;
use app\infrastructure\contracts\controllers\ControllerInterface;
use app\crosscuting\EncryptionTrait;
use app\crosscuting\UploadFiles;
use app\site\entities\Usuario;
use app\site\model\UsuarioModel;

class UsuarioController extends Controller implements ControllerInterface
{
    use EncryptionTrait;

    private $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function create()
    {
        // ETAPA 1: Receber informação (CONTROLLER)
        $usuario = new Usuario();
        $message = [];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            Log::debug("> Criando usuario " . $_POST["nome"] . " " . $_POST["nome"]);

            $usuario->setNome($_POST["nome"]);
            $usuario->setSobrenome($_POST["sobrenome"]);
            $usuario->setEmail($_POST["email"]);
            $usuario->setSenha($_POST["senha"]);
            $usuario->setToken($_POST["email"]);

            // ETAPA 2: Delegar gravação no banco para MODEL
            $usuario = $this->usuarioModel->create($usuario);

            $message = [
                "success" => $usuario ?? false,
                "description" => "Usuário salvo com sucesso"
            ];

            Log::debug("< Criando usuario " . $_POST["nome"] . " " . $_POST["email"] . " SUCESSO");
        }

        // ETAPA 3: Delegar reenderização do HTML para VIEW
        $this->load("usuario/create", [
            'response' =>
            [
                "pageTitle" => "Criar conta",
                "data" => $usuario,
                "message" => $message
            ]
        ]);
    }

    public function read()
    {
        $filtros = [];

        if (!empty($_POST["email"])) {
            $filtros["email"] = $_POST["email"];
        }

        $usuarios = $this->usuarioModel->read($filtros);

        $this->load("usuario/read", [
            'response' =>
            [
                "pageTitle" => "Gestão de Usuários: Listar",
                "data" => [
                    "usuarios" => $usuarios
                ]
            ]
        ]);
    }

    public function update($id)
    {
        $usuario = new Usuario();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario->setNome($_POST["nome"]);
            $usuario->setSobrenome($_POST["sobrenome"]);
            $usuario->setEmail($_POST["email"]);
            $usuario->setToken($_POST["email"]);

            $fotoPerfil = UploadFiles::uploadImage(PATH_IMAGEM_USUARIO, 'fotoPerfil');

            $usuario->setFoto(UPLOAD_IMAGE_USUARIO . $fotoPerfil);

            $usuario = $this->usuarioModel->update($id, $usuario);
        }

        header("Location: " . BASE . "usuario");
    }

    public function create2()
    {
        $usuario = new Usuario();
        $message = [];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {            

            $usuario->setNome($_POST["nome"]);
            $usuario->setSobrenome($_POST["sobrenome"]);
            $usuario->setEmail($_POST["email"]);
            $usuario->setToken($_POST["email"]);
            $usuario->setSenha($_POST["senha"]);

            $fotoPerfil = UploadFiles::uploadImage(PATH_IMAGEM_USUARIO, 'fotoPerfil');

            $usuario->setFoto(UPLOAD_IMAGE_USUARIO . $fotoPerfil);

            $usuario = $this->usuarioModel->create($usuario);
            header("Location: " . BASE . "usuario");
        } else {
            $this->load("usuario/create2", [
                'response' =>
                [
                    "pageTitle" => "Novo usuário",
                    "data" => $usuario,
                    "message" => $message
                ]
            ]);
        }
    }

    public function view($id)
    {
        $usuario = $this->usuarioModel->view($id);

        $this->load("usuario/view", [
            'response' =>
            [
                "pageTitle" => "Usuários: editando " . $usuario->nome,
                "data" => [
                    "usuario" => $usuario
                ]
            ]
        ]);
    }

    public function delete($id)
    {
        $sucesso = $this->usuarioModel->delete($id);

        header("Location: " . BASE . "usuario");
    }


    public function forgot()
    {
        $this->load("usuario/forgot", [
            'response' =>
            [
                "pageTitle" => "Esqueci a senha"
            ]
        ]);
    }

    public function recuperar()
    {
        $filtros["email"] = $_POST["email"];

        $usuarios = $this->usuarioModel->read($filtros);

        if (count($usuarios) > 0) {

            $emailEnviado = Email::enviarEmail(
                $usuarios[0]->email, 
                $usuarios[0]->nome . " " . $usuarios[0]->sobrenome, 
                $usuarios[0]->token
            );

            Log::debug("Recuperando senha");

            $this->load("usuario/forgot", [
                'response' =>
                [
                    "pageTitle" => "Esqueci a senha",
                    "message" => [
                        "success" => $emailEnviado,
                        "description" => $emailEnviado ? "Senha enviada para seu email." : 'Falha no envio'
                    ]
                ]
            ]);
        }
    }

    public function resetPassword($token)
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $filtros["token"] = $token;

            $usuarios = $this->usuarioModel->read($filtros);

            if (count($usuarios) > 0) {
                $this->load("usuario/resetPassword", [
                    'response' =>
                    [
                        "pageTitle" => "Redefinir senha",
                        "data" => [
                            "usuario" => [
                                "id" => $usuarios[0]->id,
                                "token" => $usuarios[0]->token
                            ]
                        ]
                    ]
                ]);
            }
        } else {

            $sucesso = $this->usuarioModel->resetPassword($_POST["id"], $_POST["senha"]);

            if ($sucesso) {
                Log::debug("Senha recuperada");
                header("Location: " . BASE . "auth");
            }
        }
    }
}
