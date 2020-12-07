<?php

namespace app\site\model;

use app\core\Model;
use app\infrastructure\contracts\models\ModelInterface;
use app\site\crosscuting\EncryptionTrait;
use app\site\entities\Usuario;

class UsuarioModel implements ModelInterface
{
    use EncryptionTrait;

    private $pdo;

    public function __construct()
    {
        $this->pdo = new Model();
    }

    public function create($usuario)
    {
        $sql  = 'INSERT INTO usuario (nome, sobrenome, email, senha) VALUES (:nome, :sobrenome, :email, :senha)';
        $params = [
            ':nome' => $usuario->getNome(),
            ':sobrenome' => $usuario->getSobrenome(),
            ':email' => $usuario->getEmail(),
            ':senha' => $usuario->getSenha()
        ];

        if (!$this->pdo->executeNonQuery($sql, $params))
            return -1; //Erro

        $id = $this->pdo->getLastID();
        $usuario = $this->view($id);
        return $usuario;
    }

    public function read($filtros)
    {
        $sql = 'SELECT * FROM usuario WHERE 1 = 1';

        if(isset($filtros) && !empty($filtros["email"])){
            $sql .= ' AND email = "' . $filtros["email"] . '"';
        }

        if(isset($filtros) && !empty($filtros["senha"])){
            $sql .= ' AND senha = "' . $this->encryption($filtros["senha"], PRIVATE_KEY) . '"';
        }

        $sql .=  ' ORDER BY nome ASC';
        $dt = $this->pdo->executeQuery($sql);
        $lista = [];

        foreach ($dt as $dr)
            $lista[] =  $this->collection($dr);

        return $lista;
    }

    public function update($id, $usuario):bool
    {   
        $sql  = 'UPDATE usuario SET nome = :nome, sobrenome = :sobrenome, email = :email, senha = :senha WHERE id = :id';
        $params = [
            ':id' => $id,
            ':nome' => $usuario->getNome(),
            ':sobrenome' => $usuario->getSobrenome(),
            ':email' => $usuario->getEmail(),
            ':senha' => $usuario->getSenha()
        ];

        return $this->pdo->executeNonQuery($sql, $params);
    }

    public function view($id)
    {
        $sql = 'SELECT * FROM usuario WHERE id = :id';

        $dr = $this->pdo->executeQueryOneRow($sql, [':id' => $id]);

        return $this->collection($dr);
    }

    public function delete($id):bool
    {
        $sql = 'SELECT * FROM usuario WHERE id = :id';

        return $this->pdo->executeNonQuery($sql, [':id' => $id]);
    }    

    private function collection($arr)
    {
        return (object) [
            'id'     => $arr['id'] ?? null,
            'nome' => $arr['nome'] ?? null,
            'sobrenome'   => $arr['sobrenome'] ?? null,
            'email'   => $arr['email'] ?? null
        ];
    }
}
