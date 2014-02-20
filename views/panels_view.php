<?php

class PanelsView extends View {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function render() {
        header('Content-type: application/json');

        $method = strtoupper($_SERVER['REQUEST_METHOD']);
        switch($method) {
        case HTTP_METHOD_GET:
            $this->render_get();
            break;
        case HTTP_METHOD_POST:
            $this->render_post();
            break;
        default:
            break;
        }
    }

    public function render_get() {
        $source = json_encode($this->model->get_all_panels());
        echo $source;
    }

    public function render_post() {
        $new_panel_uuid = $this->model->get_new_panel_uuid();
        $resbody = array('success' => array('uri' => "/controllers", 'desc' => "$new_panel_uuid"));

        $source = json_encode($resbody);
        echo $source;
    }
}
