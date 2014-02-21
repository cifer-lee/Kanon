<?php

class PanelButtonModel extends Model {

    /**
     * @var boolean The status specifies whether operation was succeed.
     *  
     */
    private $status;

    public function __construct() {
    }

    public function button_active($button) {
        $this->status = array('success' => array('uri' => "/controllers/{$button['controller_id']}/buttons/{$button['button_id']}/active", 'desc' => 'active'));
    }

    public function get_status() {
        return $this->status;
    }
}
