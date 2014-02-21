<?php

class ConfigurationController extends Controller {
    public $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function get_configuration() {
    }
}
