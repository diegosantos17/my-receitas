<?php
namespace app\infrastructure\contracts\entities;

abstract class EntityBase {
    private $id;
    private $createdAt;
    private $updatedAt;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getCreatedAt(){
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt){
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(){
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt){
        $this->updateAt = $updatedAt;
    }
}