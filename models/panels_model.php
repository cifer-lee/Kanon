<?php

class PanelsModel extends Model {
    private $panels;
    private $new_panel_id;

    public function __construct() {
    }

    public function get_all_panels() {
        $this->panels = array('controller1' => array('buttons' => array('button1' => '', 'button2' => '', 'button3' => '')), 'controller2' => array('buttons' => array('button1' => '', 'button2' => '')));
        return $this->panels;
    }

    public function create_panel($panel) {
        $this->new_panel_uuid = 1;
    }

    public function get_new_panel_uuid() {
        return $this->new_panel_uuid;
    }
}
