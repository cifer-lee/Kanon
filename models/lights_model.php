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
        $this->lights = array();
    }

    public function lights_read() {
        $db =& Db::get_instance();

        // there is only one map, so here restrict the map_uuid to 1
        $source = <<<EOD
select uuid, name, type, rssi, online, bri, r, g, b, warm, map_uuid, loc_x, loc_y from lights where map_uuid = 1;
EOD;
        $res = $db->query($source);

        if(! $res) {
            return ;
        }

        while(($light = $res->fetchArray(SQLITE3_ASSOC))) {
            $this->lights[] = $light;
        }
    }

    public function lights_search() {
        $db =& Db::get_instance();

        // there is only one map, so here restrict the map_uuid to 1
        $source = <<<EOD
select uuid, name, type, rssi, online, bri, r, g, b, warm, map_uuid, loc_x, loc_y from lights where map_uuid = 1 and loc_x = -1; 
EOD;
        $res = $db->query($source);

        while(($light = $res->fetchArray(SQLITE3_ASSOC))) {
            $this->lights[] = $light;
        }
    }

    public function lights_check_new() {
        $this->status = array(
            'status_code' => '0',
            'message' => ''
        );

        $socket = Socket::get_instance();
        if(! $socket) {
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
