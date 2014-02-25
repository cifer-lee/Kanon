<?php

class PanelsView extends View {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function render_get() {
        $source = json_encode($this->model->get_all_panels());
        echo $source;
    }

    public function render_post() {
        $status = $this->model->get_status();
        $source = json_encode($status);

        echo $source;
    }
}
