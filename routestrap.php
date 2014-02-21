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

$router->add_route('/api/controllers/:controller_id', 'PUT', 
    array(
        'controller' => 'panel',
        'action' => 'panel_update'), 
    array(
        'controller_id' => '[0-9]+'
    )
);

$router->add_route('/api/controllers/:controller_id/configure', 'POST',
    array(
        'controller' => 'panel',
        'action' => 'panel_configure'),
    array(
        'controller_id' => '[0-9]+'
    )
);

$router->add_route('/api/controllers/:controller_id/buttons/:button_id/active', 'POST',
    array(
        'controller' => 'panel_button',
        'action' => 'button_active'
    ),
    array(
        'controller_id' => '[0-9]+',
        'button_id' => '[0-9]+'
    )
);

$router->add_route('/api/bridge', 'GET', 
    array(
        'controller' => 'configuration',
        'action' => 'get_configuration'
    )
);

$router->add_route('/api/lights', 'GET',
    array(
        'controller' => 'lights',
        'action' => 'lights_read'
    )
);

$router->add_route('/api/lights/search', 'GET',
    array(
        'controller' => 'lights',
        'action' => 'lights_search'
    )
);
