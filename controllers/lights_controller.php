<?php

class LightsController extends Controller {
    /**
     * @var _object_ The model correspond to this controller
     */
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function lights_read() {
        $this->model->lights_read();
    }

    /**
     * Search for new lights
     */
    public function lights_search() {
        $this->model->lights_search();
    }
}
