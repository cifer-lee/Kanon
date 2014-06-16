<?php

class IndexController extends \Kanon\Controller {
    /**
     * @var _object_ The model correspond to this controller
     */
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function index() {
      $this->model->status_read("Hello, world.");
    }
}
