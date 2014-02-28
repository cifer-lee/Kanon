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
        $this->status = array(
            'status_code' => 0,
            'message' => ''
        );
    }

    public function get_status() {
        return $this->status;
    }
}
