<?php

class Utils {
    private static $warm_map = array(
        '10000' => array('b' => 100, 'g' => 61, 'r' => 0),
        '9000' => array('b' => 100, 'g' => 66, 'r' => 0),
        '8500' => array('b' => 100, 'g' => 69, 'r' => 0),
        '8000' => array('b' => 100, 'g' => 72, 'r' => 0),
        '7500' => array('b' => 100, 'g' => 75, 'r' => 0),
        '7000' => array('b' => 100, 'g' => 80, 'r' => 0),
        '6500' => array('b' => 97, 'g' => 83, 'r' => 0),
        '6000' => array('b' => 85, 'g' => 77, 'r' => 0),
        '5800' => array('b' => 81, 'g' => 75, 'r' => 0),
        '5500' => array('b' => 73, 'g' => 72, 'r' => 0),
        '5000' => array('b' => 60, 'g' => 63, 'r' => 0),
        '4500' => array('b' => 45, 'g' => 53, 'r' => 0),
        '4000' => array('b' => 31, 'g' => 39, 'r' => 0),
        '3400' => array('b' => 12, 'g' => 16, 'r' => 0),
        '3200' => array('b' => 7,  'g' => 6, 'r' => 0),
        '3000' => array('b' => 4,  'g' => 0, 'r' => 0),
        '2700' => array('b' => 0,  'g' => 32, 'r' => 100),
        '2400' => array('b' => 0,  'g' => 33, 'r' => 100),
        '2200' => array('b' => 0,  'g' => 31, 'r' => 100),
        '2000' => array('b' => 0,  'g' => 30, 'r' => 100),
        '1700' => array('b' => 0,  'g' => 26, 'r' => 100)
    );

    public static function warm_convert($warm) {
        $delta = 10000;
        foreach(self::$warm_map as $key => $value) {
            if(abs($warm - $key) <= $delta) {
                $delta = abs($warm - $key);
                $retkey = $key;
            }
        }

        return self::$warm_map[$retkey];
    }
}
