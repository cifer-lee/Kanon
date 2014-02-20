<?php

class PanelsModel extends Model{
    private $panels;

    public function __construct() {
        $this->panels[] = array('controller1' => array('button1', 'button2', 'button3'));
        $this->panels[] = array('controller2' => array('button1', 'button2', 'button3', 'button4'));
    }

    public function get_all_panels() {
        return $this->panels;
    }
}
