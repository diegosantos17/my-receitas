<?php
namespace app\infrastructure\contracts\models;

interface ModelInterface {
    public function create($model);
    public function read($filtros);
    public function view($id);
    public function update($id, $model):bool;
    public function delete($id):bool;
}