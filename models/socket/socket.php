<?php

class Socket {
    const HOST = 'localhost';
    const PORT = 10003;

    private static $_socket;

    private function __construct() {
    }

    public static function &get_instance() {
        if(! isset(self::$_socket)) {
            self::$_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            if(! self::$_socket) {
                return NULL;
            }

            $ret = socket_connect(self::$_socket, self::HOST, self::PORT);
            if(! $ret) {
                return NULL;
            }
        }

        return self::$_socket;
    }
}
