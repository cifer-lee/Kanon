<?php

class IndexView extends \Kanon\View {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function index() {
        $args = func_get_args();
        $params = $args[0];

        $status = $this->model->get_status();

        ob_start();
        include 'index.tpl.php';
        ob_get_flush();
    }

    public function render_put() {
        $status = $this->model->get_status();
        $source = json_encode($status);

        echo $source;
    }

    public function render_delete() {
        $status = $this->model->get_status();
        $source = json_encode($status);

        echo $source;
    }
}
