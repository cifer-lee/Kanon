<?php

$router = new \Kanon\Router();

$router->add_route('/', 'GET', array(
    'controller' => 'index',
    'action' => 'index')
);

$router->add_route('/panels', 'GET', array(
    'controller' => 'panels',
    'action' => 'get_panels')
);

