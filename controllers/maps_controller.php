<?php

class MapsController extends Controller {
    /**
     * @var _object_ The model correspond to this controller
     */
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function maps_read() {
        $args = func_get_args();
        $params = $args[0];

        $this->model->maps_read($params[0]);
    }

    /**
     * Update a light
     */
    public function light_update() {
        $args = func_get_args();
        $params = $args[0];

        if(isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] == 'application/json') {
            $reqbody = file_get_contents('php://input');
            $light = json_decode($reqbody, true);

            $light['uuid'] = $params[0];

            $this->model->light_update($light);
        } else {
            header('HTTP/1.1 415 Unsupported Media Type');
            die();
        }
    }

    public function light_delete() {
        $args = func_get_args();
        $params = $args[0];

        $this->model->light_delete($params[0]);
    }
}
