<?php

class ScenesModel extends Model {
    /**
     * @var array Stores the current light
     */
    private $scenes;

    /**
     * @var boolean The status specifies whether operation was succeed.
     *  
     */
    private $status;

    public function __construct() {
            $this->scenes = array();
    }

    public function scenes_read($map_uuid) {
        $db = Db::get_instance();
        $res = $db->query("select * from scenes where map_uuid = {$map_uuid}");

        while(($scene = $res->fetchArray(SQLITE3_ASSOC))) {
            $this->scenes[] = $scene;
        }
    }

    public function scene_create($scene) {
        $db = Db::get_instance();
        /**
         * begin a transication */
        $db->exec('begin;');

        $source = <<<EOD
insert into scenes (name, map_uuid) values ('{$scene['name']}', {$scene['map_uuid']});
EOD;
        $ret = $db->exec($source);
        if(! $ret) {
            $this->status = array(
                'status_code' => 1,
                'message' => "" 
            );

            $db->exec('rollback;');

            return ;
        }

        $uuid = $db->lastInsertRowID();

        $source = <<<EOD
insert into scene_lights (scene_uuid, light_uuid, type, bri, r, g, b, warm, r2, g2, b2) select {$uuid}, uuid, type, bri, r, g, b, warm, r2, g2, b2 from lights where map_uuid = {$scene['map_uuid']};
EOD;
        $ret = $db->exec($source);

        if($ret) {
            $this->status = array(
                'status_code' => 0,
                'message' => "{$uuid}" 
            );

            $db->exec('commit;');
        } else {
            $db->exec('rollback;');
            return ;
        }

        $socket = Socket::get_instance();
        if(! $socket) {
            return ;
        }

        $msg = sprintf("SAVE S%03s\n", $uuid);
        socket_send($socket, $msg, strlen($msg), MSG_EOF);
    }

    /**
     * Used by LightsView to get the current panel info
     *
     * @return array The panel info
     */
    public function get_scenes() {
        return $this->scenes;
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
