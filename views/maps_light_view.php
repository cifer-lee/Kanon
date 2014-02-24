<?php

class MapsLightView extends View {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function render_get() {
        $maps_light = $this->model->get_maps_light();
        $source = json_encode($maps_light);

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
