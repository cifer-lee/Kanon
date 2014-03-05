<?php

class Db {
    const DATABASE = '/tmp/yeebox.db';

    private static $_db;

    private function __construct() {
    }

    public static function &get_instance() {
        if(! isset(self::$_db)) {
            self::$_db = new SQLite3(self::DATABASE);
        }

        return self::$_db;
    }
}
