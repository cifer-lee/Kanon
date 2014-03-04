<?php

class ScenesLightsModel extends Model {
    /**
     * @var array Stores the current light
     */
    private $scenes_lights;

    /**
     * @var boolean The status specifies whether operation was succeed.
     *  
     */
    private $status;

    public function __construct() {
        $this->scenes_lights = array();
    }

    public function scenes_lights_read($scene_uuid) {
        $db =& Db::get_instance();
        $res = $db->query("select * from scene_lights where scene_uuid = {$scene_uuid};");

        while(($light = $res->fetchArray(SQLITE3_ASSOC))) {
            if($light['type'] == 1) {
                $this->scenes_lights[] = array(
                    'uuid' => $light['light_uuid'],
                    'type' => $light['type'],
                    'r' => $light['r'],
                    'g' => $light['g'],
                    'b' => $light['b'],
                    'bri' => $light['bri']
                );
            } else {
                $this->scenes_lights[] = array(
                    'uuid' => $light['light_uuid'],
                    'type' => $light['type'],
                    'r' => $light['r'],
                    'g' => $light['g'],
                    'b' => $light['b'],
                    'warm' => $light['warm'],
                    'bri' => $light['bri']
                );
            }
        }
    }

    /**
     * Used by LightsView to get the current panel info
     *
     * @return array The panel info
     */
    public function get_scenes_lights() {
        return $this->scenes_lights;
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
