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
        $this->light = array();
    }

    public function light_read($light_uuid) {
        $db =& Db::get_instance();

        $source = <<<EOD
select uuid, name, type, rssi, online, bri, r, g, b, bri2, warm, map_uuid, loc_x, loc_y from lights where map_uuid = 1 and uuid = {$light_uuid};
EOD;
        $res = $db->query($source);

        if(($light = $res->fetchArray(SQLITE3_ASSOC))) {
            $state = array(
                'uuid' => $light['uuid'],
                'type' => $light['type'],
                'r' => $light['r'],
                'g' => $light['g'],
                'b' => $light['b'],
                'bri' => $light['bri'],
                'loc_x' => $light['loc_x'],
                'loc_y' => $light['loc_y']
            );

            if($light['type'] == 2) {
                $state['warm'] = $light['warm'];
                $state['bri2'] = $light['bri2'];
            }

            $this->light = $state;
        }
    }

    public function light_update($light) {
        $db =& Db::get_instance();

        /**
         * default map_uuid to 1 */
        $res = $db->query("select * from lights where map_uuid = 1 and uuid = {$light['uuid']}");

        /**
         * filter the read only resource, not allow user to change */
        unset($light['type']);
        unset($light['rssi']);
        unset($light['map_uuid']);

        if(($origin = $res->fetchArray(SQLITE3_ASSOC))) {
            $origin = array_merge($origin, $light);

            /**
             * caculate the r2, g2 and b2 according to warm field */
            list($origin['b2'], $origin['g2'], $origin['r2']) = array_values(Utils::warm_convert($origin['warm']));

            $source = <<<EOD
update lights set name='{$origin['name']}', bri={$origin['bri']}, r={$origin['r']}, g={$origin['g']}, b={$origin['b']}, r2={$origin['r2']}, g2={$origin['g2']}, b2={$origin['b2']}, bri2={$origin['bri2']}, warm={$origin['warm']}, loc_x={$origin['loc_x']}, loc_y={$origin['loc_y']} where map_uuid = 1 and uuid={$origin['uuid']};
EOD;

            $db->exec($source);

            $this->status = array(
                'status_code' => 0,
                'message' => ''
            );
        } else {
            $this->status = array(
                'status_code' => 1,
                'message' => 'no such light'
            );

            return ;
        }

        $socket = Socket::get_instance();
        if(! $socket) {
            return ;
        }

        if($origin['type'] == 1) {
            $msg = "C {$origin['mac']},{$origin['r']},{$origin['g']},{$origin['b']},{$origin['bri']},1\n";
        } else {
            $msg = "C {$origin['mac']},{$origin['r']},{$origin['g']},{$origin['b']},{$origin['bri']},2\n";
            $msg .= "C {$origin['mac']},{$origin['r2']},{$origin['g2']},{$origin['b2']},{$origin['bri2']},1\n";
        }
        socket_send($socket, $msg, strlen($msg), MSG_EOF);
    }

    public function light_delete($light_uuid) {
        $db =& Db::get_instance();

        $res = $db->query("select mac from lights where map_uuid = 1 and uuid = {$light_uuid}");

        if(($light = $res->fetchArray(SQLITE3_ASSOC))) {
            $ret = $db->exec("delete from lights where map_uuid = 1 and uuid = {$light_uuid}");

            $this->status = array(
                'status_code' => 0,
                'message' => ''
            );

            $socket = Socket::get_instance();
            if(! $socket) {
                return ;
            }

            $msg = "DEL {$light['mac']}\n";
            socket_send($socket, $msg, strlen($msg), MSG_EOF);
        } else {
            $this->status = array(
                'status_code' => 1,
                'message' => 'no such light'
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
