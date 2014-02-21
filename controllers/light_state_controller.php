<?php

class LightStateController extends Controller {
    /**
     * @var _object_ The model correspond to this controller
     */
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function light_state_read() {
        $args = func_get_args();
        $params = $args[0];

        $this->model->light_state_read($params[0]);
    }

    public function light_state_update() {
        $args = func_get_args();
        $params = $args[0];

        if(isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] == 'application/json') {
            $reqbody = file_get_contents('php://input');
            $light_state = json_decode($reqbody, true);

            $light_state['uuid'] = $params[0];

            $this->model->light_state_update($light_state);
        } else {
            header('HTTP/1.1 415 Unsupported Media Type');
            die();
        }
    }
}
