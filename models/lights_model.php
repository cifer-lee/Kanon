<?php

class LightsModel extends Model {
    /**
     * @var array Stores the current panel
     */
    private $lights;

    /**
     * @var boolean The status specifies whether operation was succeed.
     *  
     */
    private $status;

    public function __construct() {
    }

    public function lights_read() {
        $this->lights = array('light_uuid1' => array(
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
        ), 'light_uuid2' => array(
            'name' => 'light name 2',
            'type' => 2,
            'rssi' => 190,
            'hwversion' => '2.0.1',
            'state' => array(
                'bri' => 250,
                'r' => 255,
                'g' => 0,
                'b' => 0,
                'g2' => 255,
                'b2' => 0
            )
        ));
    }

    public function lights_search() {
        $this->lights = array('light_uuid1' => array(
            'name' => 'new founded light name',
            'type' => 1,
            'rssi' => 190,
            'hwversion' => '2.0.1',
            'state' => array(
                'bri' => 250,
                'r' => 255,
                'g' => 0,
                'b' => 0
            )
        ));
    }

    /**
     * Used by LightsView to get the current panel info
     *
     * @return array The panel info
     */
    public function get_lights() {
        return $this->lights;
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
