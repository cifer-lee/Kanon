<?php

class LightStateModel extends Model {
    /**
     * @var array Stores the current light
     */
    private $light_state;

    /**
     * @var boolean The status specifies whether operation was succeed.
     *  
     */
    private $status;

    public function __construct() {
    }

    public function light_state_read($light_uuid) {
        $this->light_state = array(
            'bri' => 250,
            'r' => 255,
            'g' => 0,
            'b' => 0
        );
    }

    public function light_state_update($light_state) {
        $this->status = array();

        foreach($light_state as $key => $value) {
            if($key == 'uuid') continue;

            $this->status[] = array(
                'success' => array(
                    'uri' => "/lights/{$light_state['uuid']}/state/{$key}",
                    'desc' => "{$value}"
            ));
        }
    }

    /**
     * Used by LightsView to get the current panel info
     *
     * @return array The panel info
     */
    public function get_light_state() {
        return $this->light_state;
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
