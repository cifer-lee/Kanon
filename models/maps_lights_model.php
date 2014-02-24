<?php

class MapsLightsModel extends Model {
    /**
     * @var array Stores the current light
     */
    private $maps_lights;

    /**
     * @var boolean The status specifies whether operation was succeed.
     *  
     */
    private $status;

    public function __construct() {
    }

    public function maps_lights_read() {
        $this->maps_lights = array(
            'lightUuid1' => array('x' => '1', 'y' => '2'),
            'lightUuid2' => array('x' => '1', 'y' => '1')
        );
    }

    public function light_update($light) {
        $this->status = array(
            array(
                'success' => array(
                    'uri' => "/lights/{$light['uuid']}/name",
                    'desc' => "{$light['name']}"
            )
        ), array(
            'success' => array(
                'uri' => "lights/{$light['uuid']}/type",
                'desc' => "{$light['type']}"
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
    public function get_maps_lights() {
        return $this->maps_lights;
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
