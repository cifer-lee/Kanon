<?php

require 'bootstrap.php';
require 'router.php';
require 'routestrap.php';

/*
if (! isset($_SERVER['PATH_INFO'])) {
    echo 'hello';
}
 */

/*
echo 'SCRIPT_NAME=' . $_SERVER['SCRIPT_NAME'] . '<br />';
echo 'SCRIPT_FILENAME=' . $_SERVER['SCRIPT_FILENAME'] . '<br />';
echo 'PATH_INFO=' . $_SERVER['PATH_INFO'] . '<br />';
echo 'PATH_INFO=' . getenv('REQUEST_URI') . '<br />';
echo 'REQUEST_URI=' . $_SERVER['REQUEST_URI'] . '<br />';
echo 'QUERY_STRING=' . $_SERVER['QUERY_STRING'] . '<br />';
 */

//echo '<pre>';
//var_export($_SERVER);
//echo '</pre>';

file_put_contents('/tmp/dump', file_get_contents('php://input'));

exit;
if(($route = $router->find_route())) {
    $route->dispatch();
} else {
    header('HTTP/1.1 404 Not Found');
    echo '404 Not Found';
}
