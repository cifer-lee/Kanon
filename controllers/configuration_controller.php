<?php

class ConfigurationController extends Controller {
    public $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function get_configuration() {
        $this->model->get_configuration();
    }

    public function configuration_reset() {
        $this->model->configuration_reset();
    }
}
