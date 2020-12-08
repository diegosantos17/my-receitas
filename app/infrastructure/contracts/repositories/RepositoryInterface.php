<?php

namespace app\infrastructure\contracts\repositories;

interface RepositoryInterface{
    public function create($entity);
    public function read($filtros = []);
    public function view($id);
    public function update($entity): bool;
    public function delete($id):bool;
}