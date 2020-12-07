<?php
namespace app\infrastructure\contracts\controllers;

interface ControllerInterface {
    public function create();
    public function read();
    public function view($id);
    public function update($id);
    public function delete($id);
}