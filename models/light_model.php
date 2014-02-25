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
        $db = new SQLite3('lighting-server.db');
        $res = $db->query("select * from lights where uuid = $light_uuid");
        if(($light = $res->fetchArray(SQLITE3_ASSOC))) {
            $this->light = $light;
        } else {
            $this->light = array();
        }
    }

    public function light_update($light) {
        $db = new SQLite3('lighting-server.db');
        $res = $db->query("select * from lights where uuid = {$light['uuid']}");

        if(($origin = $res->fetchArray(SQLITE3_ASSOC))) {
            $origin = array_merge($origin, $light);

            $source = <<<EOD
update lights set name='{$origin['name']}', bri={$origin['bri']}, r={$origin['r']}, g={$origin['g']}, b={$origin['b']}, g2={$origin['g2']}, b2={$origin['b2']}, map_uuid={$origin['map_uuid']}, loc_x={$origin['loc_x']}, loc_y={$origin['loc_y']} where uuid={$origin['uuid']};
EOD;

            $db->exec($source);

            $sta = array(
                'success' => array(
                    'uri' => "/lights/{$light['uuid']}",
                    'desc' => ""
                )
            );
        } else {
            $sta = array(
                'failure' => array(
                    'uri' => "/lights/{$light['uuid']}",
                    'desc' => "no such light"
                )
            );
        }

        $this->status = $sta;
    }

    public function light_delete($light_uuid) {
        $this->status = array(
            'success' => array(
                'uri' => "/lights/{$light_uuid}",
                'desc' => "{$light_uuid}"
            )
        );
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
