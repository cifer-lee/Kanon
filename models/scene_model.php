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

    public function scene_read() {
        $this->scene = array(
            'name' => 'scene name 1'
        );
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
    public function get_scene() {
        return $this->scene;
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
