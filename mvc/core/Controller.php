<?php
class Controller {
    public function model($model) {
        require_once "./mvc/models/" . $model . ".php";
        return new $model;
    }

    public function view($view, $data = []) {
        require_once "./mvc/views/" . $view . ".php";
    }

    public function redirect($url) {
        header("Location: " . "index.php?url=" . $url);
        exit();
    }
}