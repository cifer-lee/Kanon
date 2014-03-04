<?php

class LightModel extends Model {
    /**
     * @var array Stores the current light
     */
    private $light;

    /**
     * @var boolean The status specifies whether operation was succeed.
     *  
     */
    private $status;

    public function __construct() {
    }

    public function light_read($light_uuid) {
        $db =& Db::get_instance();
        $res = $db->query("select * from lights where uuid = $light_uuid");
        if(($light = $res->fetchArray(SQLITE3_ASSOC))) {
            $this->light = $light;
        } else {
            $this->light = array();
        }
    }

    public function light_update($light) {
        $db =& Db::get_instance();
        $res = $db->query("select * from lights where uuid = {$light['uuid']}");

        if(($origin = $res->fetchArray(SQLITE3_ASSOC))) {
            $origin = array_merge($origin, $light);

            $source = <<<EOD
update lights set name='{$origin['name']}', bri={$origin['bri']}, r={$origin['r']}, g={$origin['g']}, b={$origin['b']}, g2={$origin['g2']}, b2={$origin['b2']}, map_uuid={$origin['map_uuid']}, loc_x={$origin['loc_x']}, loc_y={$origin['loc_y']} where uuid={$origin['uuid']};
EOD;
            $db->exec($source);

            $sta = array(
                'status_code' => 0,
                'message' => ''
            );
        } else {
            $sta = array(
                'status_code' => 1,
                'message' => 'no such light'
            );

            return ;
        }

        $this->status = $sta;

        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if(! $socket) {
            return ;
        }

        $ret = socket_connect($socket, 'localhost', 10003);
        if(! $ret) {
            return ;
        }

        if($origin['type'] == 1) {
            $msg = "C {$origin['mac']},{$origin['r']},{$origin['g']},{$origin['b']},{$origin['bri']},1\n";
        } else {
            $msg = "C {$origin['mac']},{$origin['r']},{$origin['g']},{$origin['b']},{$origin['bri']},2\n";
            $msg .= "C {$origin['mac']},0,{$origin['g2']},{$origin['b2']},{$origin['bri']},1\n";
        }
        socket_send($socket, $msg, strlen($msg), MSG_EOF);
    }

    public function light_delete($light_uuid) {
        $db =& Db::get_instance();
        $ret = $db->exec("delete from lights where uuid = {$light_uuid}");

        if($ret) {
            $this->status = array(
                'status_code' => 0,
                'message' => ''
            );
        } else {
            $error_code = $db->lastErrorCode();
            $this->status = array(
                'status_code' => $error_code,
                'message' => ''
            );
        }
    }

    /**
     * Used by LightsView to get the current panel info
     *
     * @return array The panel info
     */
    public function get_light() {
        return $this->light;
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
