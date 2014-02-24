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
    }

    public function scenes_lights_read() {
        $this->scenes_lights = array(
            'lightUuid1' => array(
                'name' => 'light name 1',
                'type' => 1,
                'state' => array(
                    'r' => 255,
                    'g' => 0,
                    'b' => 255,
                    'bri' => 255
                )
            ), 
            'lightUuid2' => array(
                'name' => 'light name 2',
                'type' => 2,
                'state' => array(
                    'r' => 255,
                    'g' => 0,
                    'b' => 255,
                    'g2' => 255,
                    'b2' => 0,
                    'bri' => 255
                )
            )
        );
    }

    public function maps_light_update($loc) {
        $this->status = array(
            array(
                'success' => array(
                    'uri' => "/maps/{$loc['map_uuid']}/lights/{$loc['light_uuid']}",
                    'desc' => ""
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
