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
    }

    public function scenes_read($map_uuid) {
        $db = new SQLite3('lighting-server.db');
        $res = $db->query("select * from scenes where map_uuid = {$map_uuid}");

        while(($scene = $res->fetchArray(SQLITE3_ASSOC))) {
            $this->scenes[] = $scene;
        }
    }

    public function scene_create($scene) {
        $db = new SQLite3('lighting-server.db');
        $source = <<<EOD
insert into scenes (name, map_uuid) values ('{$scene['name']}', {$scene['map_uuid']});
EOD;
        $ret = $db->exec($source);
        if(! $ret) {
            $this->status = array(
                array(
                    'failure' => array(
                        'uri' => '/scenes',
                        'desc' => ""
                    )
                ));

        }

        $uuid = $db->lastInsertRowID();

        $source = <<<EOD
insert into scene_lights (scene_uuid, light_uuid, type, bri, r, g, b, g2, b2) select {$uuid}, uuid, type, bri, r, g, b, g2, b2 from lights where map_uuid = {$scene['map_uuid']};
EOD;
        $ret = $db->exec($source);

        if($ret) {
            $this->status = array(
                array(
                    'success' => array(
                        'uri' => '/scenes',
                        'desc' => "{$uuid}"
                    )
                )
            );
        }

        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if(! $socket) {
            return ;
        }

        $ret = socket_connect($socket, 'localhost', 10003);
        if(! $ret) {
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
