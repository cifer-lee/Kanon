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
        $args = func_get_args();
        $params = $args[0];

        if(isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] == 'application/json') {
            $reqbody = file_get_contents('php://input');
            $panel = json_decode($reqbody, true);

            $panel['uuid'] = $params[0];

            $this->model->panel_update($panel);
        } else {
            header('HTTP/1.1 415 Unsupported Media Type');
            die();
        }
    }

    /**
     * Build relationships between panel buttons and scenes.
     */
    public function panel_configure() {
        $args = func_get_args();
        $params = $args[0];

        if(isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] == 'application/json') {
            $reqbody = file_get_contents('php://input');
            $configure = json_decode($reqbody, true);

            $configure['panel_uuid'] = $params[0];

            $this->model->panel_configure($configure);
        } else {
            header('HTTP/1.1 415 Unsupported Media Type');
            die();
        }
    }
}
