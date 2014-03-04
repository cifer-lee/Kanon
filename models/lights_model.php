<?php

class LightsModel extends Model {
    /**
     * @var array Stores lights
     */
    private $lights;

    /**
     * @var boolean The status specifies whether operation was succeed.
     *  
     */
    private $status;

    public function __construct() {
    }

    public function lights_read() {
        $db =& Db::get_instance();
        $res = $db->query('select * from lights');

        while(($light = $res->fetchArray(SQLITE3_ASSOC))) {
            $this->lights[] = $light;
        }
    }

    public function lights_search() {
        $db =& Db::get_instance();
        $res = $db->query('select * from lights where map_uuid = 0');

        while(($light = $res->fetchArray(SQLITE3_ASSOC))) {
            $this->lights[] = $light;
        }
    }

    public function lights_check_new() {
        $this->status = array(
            'status_code' => '0',
            'message' => ''
        );

        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if(! $socket) {
            return ;
        }

        $ret = socket_connect($socket, 'localhost', 10003);
        if(! $ret) {
            return ;
        }

        $msg = "R\n";
        socket_send($socket, $msg, strlen($msg), MSG_EOF);
    }

    public function lights_replace($lightids) {
        $this->status = array(
            'status_code' => 0,
            'message' => ''
        );
    }

    /**
     * Used by LightsView to get the current panel info
     *
     * @return array The panel info
     */
    public function get_lights() {
        return $this->lights;
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
