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
    }

    public function scene_read($scene_uuid) {
        $db =& Db::get_instance();
        $res = $db->query("select * from scenes where uuid = {$scene_uuid}");

        if(($scene = $res->fetchArray(SQLITE3_ASSOC))) {
            $this->scene = $scene;
        } else {
            // no such scene
        }
    }

    public function scene_update($scene) {
        $db = Db::get_instance();
        $ret = $db->exec("update scenes set name = '{$scene['name']}' where uuid = {$scene['uuid']};");

        if(! $ret) {
            $this->status = array(
                'status_code' => 1,
                'message' => ''
            );

            return ;
        }

        foreach($scene['lights'] as $light) {
            if($light['type'] == 1) {
                $source = <<<EOD
update scene_lights set r = {$light['r']}, g = {$light['g']}, b = {$light['b']}, bri = {$light['bri']} where scene_uuid = {$scene['uuid']} and light_uuid = {$light['uuid']};
EOD;
            } else {
                $source = <<<EOD
update scene_lights set r = {$light['r']}, g = {$light['g']}, b = {$light['b']}, g2 = {$light['g2']}, b2 = {$light['b2']}, bri = {$light['bri']} where scene_uuid = {$scene['uuid']} and light_uuid = {$light['uuid']};
EOD;
            }

            $ret = $db->exec($source);
        }

        if($ret) {
            $this->status = array(
                'status_code' => 0,
                'message' => ''
            );
        }
    }

    public function scene_remove($scene_uuid) {
        $db = Db::get_instance();

        $ret = $db->exec("delete from scenes where uuid = {$scene_uuid}");

        if(! $ret) {
            $error_msg = $db->lastErrorMsg();
            $this->status = array(
                'status_code' => 1,
                'message' => "$error_msg"
            );

            return ;
        }

        $ret = $db->exec("delete from scene_lights where scene_uuid = {$scene_uuid}");

        if($ret) {
            $this->status = array(
                'status_code' => 0,
                'message' => ''
            );
        }
    }

    public function scene_active($scene_uuid) {
        $this->status = array(
            'status_code' => 0,
            'message' => "{$scene_uuid}" 
        );

        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if(! $socket) {
            return ;
        }

        $ret = socket_connect($socket, 'localhost', 10003);
        if(! $ret) {
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
