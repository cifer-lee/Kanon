<?php

class LightView extends View {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function render_get() {
        $light = $this->model->get_light();
        $source = json_encode($light);

        echo $source;
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
