<?php

require 'router.php';

$router = new \Kanon\Router();

$router->add_route('#/controllers#', function() {
    echo 'hello controllers';
});

$router->find_route($_SERVER['REQUEST_URI'])->dispatch();

/*
echo $_SERVER['REQUEST_URI'] . "<br />";
echo $_SERVER['SCRIPT_FILENAME'] . '<br />';
echo $_SERVER['SCRIPT_NAME'] . '<br />';
echo $_SERVER['PATH_INFO'];
 */
