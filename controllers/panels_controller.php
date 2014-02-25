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
    }

    /**
     * create a panel
     */
    public function create_panel() {
        if(isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] == 'application/json') {
            $reqbody = file_get_contents('php://input');
            $panel = json_decode($reqbody, true);

            // default map 1
            $panel['map_uuid'] = 1;

            $this->model->create_panel($panel);
        } else {
            header('HTTP/1.1 415 Unsupported Media Type');
            die();
        }
    }
}
