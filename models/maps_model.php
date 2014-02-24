<?php

class MapsModel extends Model {
    /**
     * @var array Stores the current light
     */
    private $maps;

    /**
     * @var boolean The status specifies whether operation was succeed.
     *  
     */
    private $status;

    public function __construct() {
    }

    public function maps_read() {
        $this->maps = array(
            'mapUuid1' => array('name' => 'map name 1'),
            'mapUuid2' => array('name' => 'map name 2')
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
    public function get_maps() {
        return $this->maps;
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
