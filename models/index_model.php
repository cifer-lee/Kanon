<?php

class IndexModel extends \Kanon\Model {
    /**
     * @var string The status specifies whether operation was succeed.
     *  
     */
    private $status;

    public function __construct() {
    }

    public function status_read($status) {
      $this->status = $status;
    }

    public function light_update($light) {
    }

    /**
     * Used by LightsView to get the last operation's status
     *
     * @return boolean The last operation's status
     */
    public function get_status() {
        return $this->status;
    }
}
