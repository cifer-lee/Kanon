<?php

class SceneController extends Controller {
    /**
     * @var _object_ The model correspond to this controller
     */
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function scene_read() {
        $args = func_get_args();
        $params = $args[0];

        $this->model->scene_read($params[0]);
    }

    public function scene_update() {
        $args = func_get_args();
        $params = $args[0];

        if(isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] == 'application/json') {
            $reqbody = file_get_contents('php://input');
            $scene = json_decode($reqbody, true);

            $scene['uuid'] = $params[0];

            $this->model->scene_update($scene);
        } else {
            header('HTTP/1.1 415 Unsupported Media Type');
            die();
        }
    }

    public function scene_remove() {
        $args = func_get_args();
        $params = $args[0];

        $this->model->scene_remove($params[0]);
    }

    public function scene_active() {
        $args = func_get_args();
        $params = $args[0];

        if(isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] == 'application/json') {
            $scene_uuid = $params[0];

            $this->model->scene_active($scene_uuid);
        } else {
            header('HTTP/1.1 415 Unsupported Media Type');
            die();
        }
    }

    /**
     * Update a light
     */
    public function maps_light_update() {
        $args = func_get_args();
        $params = $args[0];

        if(isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] == 'application/json') {
            $reqbody = file_get_contents('php://input');
            $loc = json_decode($reqbody, true);

            $loc['map_uuid'] = $params[0];
            $loc['light_uuid'] = $params[1];

            $this->model->maps_light_update($loc);
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
