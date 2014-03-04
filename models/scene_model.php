<?php

class SceneModel extends Model {
    /**
     * @var array Stores the current light
     */
    private $scene;

    /**
     * @var boolean The status specifies whether operation was succeed.
     *  
     */
    private $status;

    public function __construct() {
            $this->scene = array();
    }

    public function scene_read($scene_uuid) {
        $db =& Db::get_instance();
        $res = $db->query("select * from scenes where map_uuid = 1 and uuid = {$scene_uuid}");

        if(($scene = $res->fetchArray(SQLITE3_ASSOC))) {
            $this->scene = $scene;
        }
    }

    public function scene_update($scene) {
        $db = Db::get_instance();
        $db->exec('begin;');
        $ret = $db->exec("update scenes set name = '{$scene['name']}' where map_uuid = 1 and uuid = {$scene['uuid']};");

        if(! $ret) {
            $this->status = array(
                'status_code' => 1,
                'message' => ''
            );

            $db->exec('rollback;');
            return ;
        }

        foreach($scene['lights'] as $light) {
            if($light['type'] == 1) {
                $source = <<<EOD
update scene_lights set r = {$light['r']}, g = {$light['g']}, b = {$light['b']}, bri = {$light['bri']} where scene_uuid = {$scene['uuid']} and light_uuid = {$light['uuid']};
EOD;
            } else {
                /**
                 * caculate the g2 and b2 according to warm field */
                $light['g2'] = $light['warm'];
                $light['b2'] = $light['warm'];
                $source = <<<EOD
update scene_lights set r = {$light['r']}, g = {$light['g']}, b = {$light['b']}, warm = {$light['warm']}, g2 = {$light['g2']}, b2 = {$light['b2']}, bri = {$light['bri']} where scene_uuid = {$scene['uuid']} and light_uuid = {$light['uuid']};
EOD;
            }

            $ret = $db->exec($source);

            if(! $ret) {
                $this->status = array(
                    'status_code' => 1,
                    'message' => ''
                );

                $db->exec('rollback;');
                return ;
            }
        }

        $db->exec('commit;');
        $this->status = array(
            'status_code' => 0,
            'message' => ''
        );
    }

    public function scene_remove($scene_uuid) {
        $db = Db::get_instance();

        $db->exec('begin;');
        $ret = $db->exec("delete from scenes where uuid = {$scene_uuid}");

        if(! $ret) {
            $error_msg = $db->lastErrorMsg();
            $this->status = array(
                'status_code' => 1,
                'message' => "$error_msg"
            );

            $db->exec('rollback;');
            return ;
        }

        $ret = $db->exec("delete from scene_lights where scene_uuid = {$scene_uuid}");

        if($ret) {
            $this->status = array(
                'status_code' => 0,
                'message' => ''
            );

            $db->exec('commit;');
        }
    }

    public function scene_active($scene_uuid) {
        $this->status = array(
            'status_code' => 0,
            'message' => "{$scene_uuid}" 
        );

        $socket = Socket::get_instance();
        if(! $socket) {
            return ;
        }

        $msg = sprintf("C S%03s\n", $scene_uuid);
        socket_send($socket, $msg, strlen($msg), MSG_EOF);
    }

    /**
     * Used by SceneView to get the current scene info
     *
     * @return array The scene info
     */
    public function get_scene() {
        return $this->scene;
    }

    /**
     * Used by SceneView to get the last operation's status
     *
     * @return boolean The last operation's status
     */
    public function get_status() {
        return $this->status;
    }
}
