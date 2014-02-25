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
        $db = new SQLite3('lighting-server.db');
        $res = $db->query("select * from scenes where uuid = {$scene_uuid}");

        if(($scene = $res->fetchArray(SQLITE3_ASSOC))) {
            $this->scene = $scene;
        } else {
            // no such scene
        }
    }

    public function scene_active($scene_uuid) {
        $this->status = array(
            array(
                'success' => array(
                    'uri' => "/scenes/{$scene_uuid}/on",
                    'desc' => "{$scene_uuid}"
            )
        ));
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
