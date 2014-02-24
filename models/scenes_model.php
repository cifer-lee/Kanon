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

    public function scenes_read() {
        $this->scenes = array(
            'sceneUuid1' => array('name' => 'scene name 1'),
            'sceneUuid2' => array('name' => 'scene name 2')
        );
    }

    public function scene_create($scene) {
        $this->status = array(
            array(
                'success' => array(
                    'uri' => '/scenes',
                    'desc' => '1'
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
