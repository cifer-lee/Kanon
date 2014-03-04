<?php

class ConfigurationView extends View {
    public $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function render_get() {
        $configuration = $this->model->get_configuration();

        $source = json_encode($configuration);
        echo $source;
    }

    public function render_post() {
        $status = $this->model->get_status();

        $source = json_encode($status);
        echo $source;
    }
}
