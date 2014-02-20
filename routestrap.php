<?php

$router = new \Kanon\Router();

$router->add_route('/', 'GET', array(
    'controller' => 'index',
    'action' => 'index')
);

$router->add_route('/api/controllers', 'GET', array(
    'controller' => 'panels',
    'action' => 'get_panels')
);
