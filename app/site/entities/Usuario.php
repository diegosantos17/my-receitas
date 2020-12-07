<?php

namespace app\site\entities;

use app\infrastructure\contracts\entities\EntityBase;
use app\crosscuting\EncryptionTrait;

class Usuario extends EntityBase{

    use EncryptionTrait;

    private $nome;
    private $sobrenome;
    private $email;
    private $senha;
    private $token;
    private $foto;

    public function getNome(){
        return $this->nome;
    }

    public function setNome($nome){
        $this->nome = $nome;
    }

    public function getSobrenome(){
        return $this->sobrenome;
    }

    public function setSobrenome($sobrenome){
        $this->sobrenome = $sobrenome;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function getFoto(){
        return $this->foto;
    }

    public function setFoto($foto){
        $this->foto = $foto;
    }

    public function getSenha(){
        return $this->senha;
    }

    public function setSenha($senha){
        $this->senha = $this->encryption($senha, PRIVATE_KEY);
    } 
    
    public function getToken(){
        return $this->token;
    }

    public function setToken($token){
        $this->token = $this->encryption($token, PRIVATE_KEY);
    }
}