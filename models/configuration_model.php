<?php

class ConfigurationModel extends Model {
    private $configuration;

    public function __construct() {
    }

    public function get_configuration() {
        $this->configuration = array('name' => 'bridge 1', 'type' => 'commercial', 'utc' => date('U'), 'mac' => 'FFFFFF', 'hwversion' => '2.0.1.4', 'manufacturer' => 'Yeelink');
        return $this->configuration;
    }
}
