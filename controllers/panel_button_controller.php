<?php

class PanelButtonController extends Controller {
    /**
     * @var _object_ The model correspond to this controller
     */
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function button_active() {
        $args = func_get_args();
        $params = $args[0];

        if(isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] == 'application/json') {
            $button = array('controller_id' => $params[0], 'button_id' => $params[1]);

            $this->model->button_active($button);
        } else {
            header('HTTP/1.1 415 Unsupported Media Type');
            die();
        }
    }
}
