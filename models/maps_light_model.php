<?php

class MapsLightModel extends Model {
    /**
     * @var array Stores the current light
     */
    private $maps_light;

    /**
     * @var boolean The status specifies whether operation was succeed.
     *  
     */
    private $status;

    public function __construct() {
    }

    public function maps_light_read() {
        $this->maps_light = array(
            'x' => '1', 
            'y' => '2'
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
    public function get_maps_light() {
        return $this->maps_light;
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
