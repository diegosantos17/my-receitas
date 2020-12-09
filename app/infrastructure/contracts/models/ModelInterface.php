<?php
namespace app\infrastructure\contracts\models;

interface ModelInterface {
    public function create($model);
    public function read($filtros = []);
    public function view($id);
    public function update($model):bool;
    public function delete($model):bool;
}