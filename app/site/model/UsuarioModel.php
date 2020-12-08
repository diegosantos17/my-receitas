<?php

namespace app\site\model;

use app\core\Model;
use app\crosscuting\EncryptionTrait;
use app\infrastructure\contracts\models\ModelInterface;
use app\infrastructure\repositories\UsuarioRepository;
use Exception;

class UsuarioModel implements ModelInterface
{
    use EncryptionTrait;

    private $usuarioRepository;

    public function __construct()
    {
        $this->usuarioRepository = new UsuarioRepository();
    }

    public function create($usuario)
    {
        try{
            $this->isValid($usuario);
            $isExists = $this->usuarioExiste($usuario);
            
            if($isExists){
                throw new Exception("Email já cadastrado.");
            }

            $usuario->setSenha($this->encryption($usuario->getSenha(), PRIVATE_KEY));
            $usuarioNovo = $this->usuarioRepository->create($usuario);
            
            return $usuarioNovo;
        } catch (Exception $ex){
            throw $ex;
        }
    }

    public function read($filtros = [])
    {
        $lista = $this->usuarioRepository->read($filtros);

        return $lista;
    }

    public function update($usuario): bool
    {
        return $this->usuarioRepository->executeNonQuery($usuario);
    }

    public function view($id)
    {
        $usuario = $this->usuarioRepository->view($id);
        return $usuario;
    }

    public function delete($id): bool
    {
        $sucesso = $this->usuarioRepository->delete($id);
        return $sucesso;
    }

    public function resetPassword($id, $senha): bool
    {
        $sucesso = $this->usuarioRepository->resetPassword($id, $senha);
        return $sucesso;
    }

    private function isValid($usuario)
    {
        if(strlen($usuario->getNome()) < 3){
            throw new Exception("Nome deve conter pelo menos 3 carateres.");
        }

        if(strlen($usuario->getSenha()) < 4){
            throw new Exception("Senha deve possuir no mínimo 4 caracteres.");
        }
    }    

    private function usuarioExiste($usuario){
        $filtros["email"] = $usuario->getEmail();
        $retorno = $this->usuarioRepository->read($filtros);

        $existe = count($retorno) > 0;

        return $existe;
    }
}
