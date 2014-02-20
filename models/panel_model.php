<?php

class PanelModel extends Model {
    private $panel;

    public function __construct() {
    }

    public function panel_info($panel_uuid) {
        $this->panel = array('controller1' => array('button1', 'button2', 'button3'));
    }

    public function create_panel($panel) {
        $this->new_panel_uuid = 1;
    }

    public function get_panel() {
        return $this->panel;
    }
}
