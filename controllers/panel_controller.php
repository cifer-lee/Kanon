<?php

class PanelController extends Controller {
    /**
     * @var _object_ The model correspond to this controller
     */
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function panel_read() {
        $args = func_get_args();
        $params = $args[0];

        $this->model->panel_info($params[0]);
    }

    public function panel_update() {
    }
}
