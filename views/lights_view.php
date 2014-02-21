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
}
