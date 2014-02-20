<?php

class View {

    public function render() {
        header('Content-type: application/json');

        $args = func_get_args();
        $params = $args[0];

        $method = strtoupper($_SERVER['REQUEST_METHOD']);
        switch($method) {
        case HTTP_METHOD_GET:
            $this->render_get($params);
            break;
        case HTTP_METHOD_POST:
            $this->render_post($params);
            break;
        case HTTP_METHOD_PUT:
            $this->render_put($params);
            break;
        case HTTP_METHOD_DELETE:
            $this->render_delete($params);
            break;
        default:
            break;
        }
    }

    public function render_get() {
    }

    public function render_post() {
    }

    public function render_put() {
    }

    public function render_delete() {
    }
}
