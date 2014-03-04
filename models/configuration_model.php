<?php

class ConfigurationModel extends Model {
    private $configuration;

    private $status;

    public function __construct() {
    }

    public function get_configuration() {
        $this->configuration = array('name' => 'bridge 1', 'type' => 'commercial', 'utc' => date('U'), 'mac' => 'FFFFFF', 'hwversion' => '2.0.1.4', 'manufacturer' => 'Yeelink');
        return $this->configuration;
    }

    public function configuration_reset() {
        $db =& Db::get_instance();

        $db->exec('delete from lights where 1 = 1;');
        $db->exec('delete from scenes where 1 = 1;');
        $db->exec('delete from scene_lights where 1 = 1;');

        $this->status = array(
            'status_code' => 0,
            'message' => ''
        );

        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if(! $socket) {
            return ;
        }

        $ret = socket_connect($socket, 'localhost', 10003);
        if(! $ret) {
            return ;
        }

        $msg = "CLRNWK\n";
        socket_send($socket, $msg, strlen($msg), MSG_EOF);
    }

    public function get_status() {
        return $this->status;
    }
}
