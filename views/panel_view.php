<?php

class PanelView extends View {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function render_get() {
        $panel = $this->model->get_panel();
        $source = json_encode($panel);

        echo $source;
    }

    public function render_post() {
    }

    public function render_put($params) {
        $status = $this->model->get_status();

        if($status) {
            $resbody = array('success' => array('uri' => "/controllers/{$params[0]}", 'desc' => ""));
        } else {
            $resbody = array('failure' => array('uri' => "/controllers/{$params[0]}", 'desc' => ""));
        }

        $source = json_encode($resbody);
        echo $source;
    }
}
