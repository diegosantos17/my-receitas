<?php

namespace app\site\controller;

use app\core\Controller;
use app\site\crosscuting\Email;
use app\site\crosscuting\Log;
use app\infrastructure\contracts\controllers\ControllerInterface;
use app\site\crosscuting\EncryptionTrait;
use app\site\entities\Usuario;
use app\site\model\UsuarioModel;
use stdClass;

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
        $usuario = new Usuario();
        $message = [];

        if ($_SERVER["REQUEST_METHOD"] =="POST") {
            $usuario->setNome($_POST["nome"]);
            $usuario->setSobrenome($_POST["sobrenome"]);
            $usuario->setEmail($_POST["email"]);
            $usuario->setSenha($_POST["senha"]);

            $usuario = $this->usuarioModel->create($usuario);
            $message = [
                "success" => $usuario ?? false,
                "description" => "Usuário salvo com sucesso"
            ];
        } 

        $this->load("usuario/create", [
            'response' =>
            [
                "pageTitle" => "Criar conta",
                "data" => $usuario,
                "message"=> $message
            ]
        ]);
    }

    public function read()
    {
        $filtros = [];

        if(!empty($_POST["email"])){
            $filtros["email"] = $_POST["email"];
        } 

        if(!empty($_POST["senha"])){
            $filtros["senha"] = $this->encryption($_POST["senha"], PRIVATE_KEY);
        } 

        $usuarios = $this->usuarioModel->read($filtros);

        $this->load("usuario/create", [
            'response' =>
            [
                "pageTitle" => "Criar conta",
                "data" => $usuarios
            ]
        ]);
    }

    public function update($id)
    {        
        $usuario = new Usuario();

        if ($_SERVER["REQUEST_METHOD"] =="POST") {
            $usuario->setNome($_POST["nome"]);
            $usuario->setSobrenome($_POST["sobrenome"]);
            $usuario->setEmail($_POST["email"]);
            $usuario->setSenha($_POST["senha"]);

            $usuario = $this->usuarioModel->update($id, $usuario);
        }

        $this->load("usuario/create", [
            'response' =>
            [
                "pageTitle" => "Alterar conta",
                "data" => $usuario
            ]
        ]);
    }

    public function view($id)
    {
        $usuario = $this->usuarioModel->view($id);

        $this->load("usuario/main", [
            'response' =>
            [
                "pageTitle" => "Criar conta",
                "data" => $usuario
            ]
        ]);
    }

    public function delete($id)
    {
        $sucesso = $this->usuarioModel->delete($id);

        $this->load("usuario/main", [
            'response' =>
            [
                "pageTitle" => "Deletar conta",
                "data" => $sucesso
            ]
        ]);
    }


    public function esqueci()
    {
        $this->load("usuario/esqueci", [
            'response' =>
            [
                "pageTitle" => "Esqueci a senha"
            ]
        ]);
    }

    public function recuperar()
    {

        $emailEnviado = Email::enviarEmail();
        Log::debug("Recuperando senha");

        $this->load("usuario/esqueci", [
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
