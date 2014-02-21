<?php

class LightStateView extends View {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function render_get() {
        $light_state = $this->model->get_light_state();
        $source = json_encode($light_state);

        echo $source;
    }

    public function render_put() {
        $status = $this->model->get_status();
        $source = json_encode($status);

        echo $source;
    }
}
