<?php

class ScenesController extends Controller {
    /**
     * @var _object_ The model correspond to this controller
     */
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    /**
     * Get scene list
     */
    public function scenes_read() {
        $args = func_get_args();
        $params = $args[0];

        // default map_uuid
        // $map_uuid = $params[0]
        $map_uuid = 1;  //$params[0]

        $this->model->scenes_read($map_uuid);
    }

    /**
     * Create a scene
     */
    public function create_scene() {
        $args = func_get_args();
        $params = $args[0];

        if(isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] == 'application/json') {
            $reqbody = file_get_contents('php://input');
            $scene = json_decode($reqbody, true);

            // only one map now, defaults to map_uuid 1
            $scene['map_uuid'] = 1;

            $this->model->scene_create($scene);
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
