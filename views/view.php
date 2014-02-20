<?php

class View {

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
}
