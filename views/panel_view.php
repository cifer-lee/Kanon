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

    public function render_put() {
        $new_panel_uuid = $this->model->get_new_panel_uuid();
        $resbody = array('success' => array('uri' => "/controllers", 'desc' => "$new_panel_uuid"));

        $source = json_encode($resbody);
        echo $source;
    }
}
