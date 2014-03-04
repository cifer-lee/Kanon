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

    public function lights_check_new() {
        $this->model->lights_check_new();
    }

    /**
     * Replace light
     */
    public function lights_replace() {
        $args = func_get_args();
        $params = $args[0];

        if(isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] == 'application/json') {
            $reqbody = file_get_contents('php://input');
            $lightids = json_decode($reqbody, true);

            $this->model->lights_replace($lightids);
        } else {
            header('HTTP/1.1 415 Unsupported Media Type');
            die();
        }
    }
}
