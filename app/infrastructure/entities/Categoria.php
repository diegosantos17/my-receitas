<?php

namespace app\infrastructure\entities;

use app\infrastructure\contracts\entities\EntityBase;
use app\crosscuting\EncryptionTrait;

class Categoria extends EntityBase{

    use EncryptionTrait;

    private $titulo;
    private $descricao;
    private $imagem;
    
    public function getTitulo(){
        return $this->titulo;
    }

    public function setTitulo($titulo){
        $this->titulo = $titulo;
    }

    public function getDescricao(){
        return $this->descricacao;
    }

    public function setDescricao($descricao){
        $this->descricao = $descricao;
    }

    public function getImagem(){
        return $this->imagem;
    }

    public function setImagem($imagem){
        $this->imagem = $imagem;
    }
}