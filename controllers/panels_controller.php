<?php

class PanelsController extends Controller {
    /**
     * @var _object_ The model correspond to this controller
     */
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    /**
     * get all panels
     */
    public function get_panels() {
        echo 'hello world';
    }

    /**
     * create a panel
     */
    public function create_panel() {
    }
}
