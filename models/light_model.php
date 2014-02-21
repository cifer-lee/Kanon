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
        $this->light = array(
            'name' => 'light name 1',
            'type' => 1,
            'rssi' => 190,
            'hwversion' => '2.0.1',
            'state' => array(
                'bri' => 250,
                'r' => 255,
                'g' => 0,
                'b' => 0
            )
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
