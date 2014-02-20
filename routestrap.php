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

$router->add_route('/api/controllers', 'POST', array(
    'controller' => 'panels',
    'action' => 'create_panel')
);

$router->add_route('/api/controllers/:controller_id', 'GET', 
    array(
        'controller' => 'panel',
        'action' => 'panel_read'), 
    array(
        'controller_id' => '[0-9]+'
    )
);
