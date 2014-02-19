<?php

require 'router.php';

$router = new \Kanon\Router();

$router->add_route('#^/$#', function() {
    echo 'hello index';
});
$router->add_route('#^/controllers$#', function() {
    echo 'hello controllers';
});
$router->add_route('#^/controllers/[0-9]+$#', function() {
    echo 'hello controllers number';
});

if(($route = $router->find_route($_SERVER['REQUEST_URI']))) {
    $route->dispatch();
} else {
    header('HTTP/1.1 404 Not Found');
    echo '404 Not Found';
}

/*
echo $_SERVER['REQUEST_URI'] . "<br />";
echo $_SERVER['SCRIPT_FILENAME'] . '<br />';
echo $_SERVER['SCRIPT_NAME'] . '<br />';
echo $_SERVER['PATH_INFO'];
 */
