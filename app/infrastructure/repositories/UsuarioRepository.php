<?php

namespace app\infrastructure\repositories;

use app\crosscuting\EncryptionTrait;
use app\infrastructure\contracts\repositories\RepositoryInterface;
use app\infrastructure\entities\Usuario;
use Exception;

class UsuarioRepository extends RepositoryBase implements RepositoryInterface
{
    use EncryptionTrait;

    public function create($usuario)
    {
        try {
            $sql  = 'INSERT INTO usuario 
                    (
                        nome, 
                        sobrenome, 
                        email, 
                        senha, 
                        token, 
                        foto
                    ) 
                    VALUES      
                    (
                        :nome, 
                        :sobrenome, 
                        :email, 
                        :senha, 
                        :token, 
                        :foto
                    )';

            $params = [
                ':nome' => $usuario->getNome(),
                ':sobrenome' => $usuario->getSobrenome(),
                ':email' => $usuario->getEmail(),
                ':senha' => $usuario->getSenha(),
                ':token' => $usuario->getToken(),
                ':foto' => $usuario->getFoto(),
            ];

            if (!$this->executeNonQuery($sql, $params))
                return -1; //Erro

            $id = $this->getLastID();
            $usuario = $this->view($id);
            return $usuario;
        } catch (Exception $ex) {
            throw new Exception("Erro interno, contate o administrador");
        }
    }

    public function read($filtros = [])
    {
        try {
            $sql = 'SELECT * FROM usuario WHERE 1 = 1';

            if (isset($filtros) && !empty($filtros["email"])) {
                $sql .= ' AND email = "' . $filtros["email"] . '"';
            }

            if (isset($filtros) && !empty($filtros["senha"])) {
                $sql .= ' AND senha = "' . $this->encryption($filtros["senha"], PRIVATE_KEY) . '"';
            }

            if (isset($filtros) && !empty($filtros["token"])) {
                $sql .= ' AND token = "' . $filtros["token"] . '"';
            }

            $sql .=  ' ORDER BY nome ASC';
            $dt = $this->executeQuery($sql);
            $lista = [];

            foreach ($dt as $dr)
                $lista[] =  $this->collection($dr);

            return $lista;
        } catch (Exception $ex) {
            throw new Exception("Erro interno, contate o administrador");
        }
    }

    public function update($usuario): bool
    {
        try {
            $sql  = 'UPDATE usuario 
                    SET    
                        nome = :nome, 
                        sobrenome = :sobrenome, 
                        email = :email, 
                        token = :token, 
                        foto = :foto 
                    WHERE  
                        id = :id ';
                        
            $params = [
                ':id' => $usuario->getId(),
                ':nome' => $usuario->getNome(),
                ':sobrenome' => $usuario->getSobrenome(),
                ':email' => $usuario->getEmail(),
                ':token' => $usuario->getToken(),
                ':foto' => $usuario->getFoto()
            ];

            return $this->executeNonQuery($sql, $params);
        } catch (Exception $ex) {
            throw new Exception("Erro interno, contate o administrador");
        }
    }

    public function view($id)
    {
        try {
            $sql = 'SELECT 
                        * 
                    FROM 
                        usuario 
                    WHERE 
                        id = :id';

            $dr = $this->executeQueryOneRow($sql, [':id' => $id]);

            return $this->collection($dr);
        } catch (Exception $ex) {
            throw new Exception("Erro interno, contate o administrador");
        }
    }

    public function delete($id): bool
    {
        try {
            $sql = 'DELETE 
                    FROM 
                        usuario 
                    WHERE 
                        id = :id';

            return $this->executeNonQuery($sql, [':id' => $id]);
        } catch (Exception $ex) {
            throw new Exception("Erro interno, contate o administrador");
        }
    }

    public function resetPassword($id, $senha): bool
    {
        try {
            $sql  = 'UPDATE 
                        usuario 
                    SET 
                        senha = :senha 
                    WHERE 
                        id = :id';
            $params = [
                ':id' => $id,
                ':senha' =>  $this->encryption($senha, PRIVATE_KEY)
            ];

            return $this->executeNonQuery($sql, $params);
        } catch (Exception $ex) {
            throw new Exception("Erro interno, contate o administrador");
        }
    }

    private function collection($arr)
    {
        try {
            $usuario = new Usuario();
            $usuario->id =  $arr['id'];
            $usuario->setNome($arr['nome']);
            $usuario->setSobrenome($arr['sobrenome']);
            $usuario->setEmail($arr['email']);
            $usuario->setFoto($arr['foto']);
            $usuario->setToken($arr['token']);

            return $usuario;
        } catch (Exception $ex) {
            throw new Exception("Erro interno, contate o administrador");
        }
    }
}