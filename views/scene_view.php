<?php

class SceneView extends View {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function render_get() {
        $scene = $this->model->get_scene();
        $source = json_encode($scene);

        echo $source;
    }

    public function render_post() {
        $status = $this->model->get_status();
        $source = json_encode($status);

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
