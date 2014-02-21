<?php

class LightsView extends View {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function render_get() {
        $lights = $this->model->get_lights();
        $source = json_encode($lights);

        echo $source;
    }

    public function render_post() {
        $status = $this->model->get_status();
        $source = json_encode($status);

        echo $source;
    }
}
