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

        $res_lights = $db->query("select uuid, type from lights;");
        if(! $res_lights) {
            $this->status = array(
                'status_code' => 1,
                'message' => "{$db->lastErrorMsg()}"
            );

            $db->exec('rollback;');
            return ;
        }

        $all_light_uuids = array();
        while(($light = $res_lights->fetchArray(SQLITE3_ASSOC))) {
            $all_light_uuids[] = array('uuid' => $light['uuid'], 'type' => $light['type']);
        }

        foreach($scene['lights'] as $light) {
            unset($light['type']);

            if(isset($light['warm'])) {
                /**
                 * caculate the g2 and b2 according to warm field */
                list($light['b2'], $light['g2'], $light['r2']) = array_values(Utils::warm_convert($light['warm']));
            }

            $res = $db->query("select * from scene_lights where scene_uuid = {$scene['uuid']} and light_uuid = {$light['uuid']}");

            if(! $res) {
                $this->status = array(
                    'status_code' => 1,
                    'message' => "{$db->lastErrorMsg()}"
                );
                $db->exec('rollback;');
                return ;
            }

            if(($scene_light = $res->fetchArray(SQLITE3_ASSOC))) {
                $scene_light = array_merge($scene_light, $light);

                $source = <<<EOD
update scene_lights set r = {$scene_light['r']}, g = {$scene_light['g']}, b = {$scene_light['b']}, warm = {$scene_light['warm']}, r2 = {$scene_light['r2']}, g2 = {$scene_light['g2']}, b2 = {$scene_light['b2']}, bri = {$scene_light['bri']} where scene_uuid = {$scene['uuid']} and light_uuid = {$scene_light['uuid']};
EOD;
            } else {
                $source = '';
                foreach($all_light_uuids as $value) {
                    if($value['uuid'] == $light['uuid']) {
                        $source = <<<EOD
insert into scene_lights (scene_uuid, light_uuid, type, r, g, b, warm, r2, g2, b2, bri) values ({$scene['uuid']}, {$light['uuid']}, {$value['type']}, {$light['r']}, {$light['g']}, {$light['b']}, {$light['warm']}, {$light['r2']}, {$light['g2']}, {$light['b2']}, {$light['bri']});
EOD;
                    }
                }
            }

            $ret = $db->exec($source);

            if(! $ret) {
                var_dump($source);
                $this->status = array(
                    'status_code' => 1,
                    'message' => "{$db->lastErrorMsg()}"
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
        $db =& Db::get_instance();

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
        $db =& Db::get_instance();
        $db->exec('begin;');

        $ret = $db->exec("update scenes set active = 0 where 1 = 1;");
        if(! $ret) {
            $this->status = array(
                'status_code' => 1,
                'message' => '' 
            );

            $db->exec('rollback;');
            return ;
        }

        $ret = $db->exec("update scenes set active = 1 where uuid = {$scene_uuid}");
        if($ret) {
            $db->exec('commit;');

            $this->status = array(
                'status_code' => 0,
                'message' => "{$scene_uuid}" 
            );
        } else {
            $db->exec('rollback;');
            return ;
        }

        $socket = Socket::get_instance();
        if(! $socket) {
            return ;
        }

        $msg = sprintf("C S%03s,,,,\n", $scene_uuid);
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
