<?php

require 'bootstrap.php';
require 'router.php';
require 'routestrap.php';

if(($route = $router->find_route($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']))) {
    $route->dispatch();
} else {
    header('HTTP/1.1 404 Not Found');
    echo '404 Not Found';
}
