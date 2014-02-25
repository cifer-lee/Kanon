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

$router->add_route('/api/lights/replace', 'POST',
    array(
        'controller' => 'lights',
        'action' => 'lights_replace'
    )
);

$router->add_route('/api/lights/:light_uuid', 'GET',
    array(
        'controller' => 'light',
        'action' => 'light_read'
    ),
    array(
        'light_uuid' => '[0-9]+'
    )
);

$router->add_route('/api/lights/:light_uuid', 'PUT',
    array(
        'controller' => 'light',
        'action' => 'light_update'
    ),
    array(
        'light_uuid' => '[0-9]+'
    )
);

$router->add_route('/api/lights/:light_uuid/state', 'GET',
    array(
        'controller' => 'light_state',
        'action' => 'light_state_read'
    ),
    array(
        'light_uuid' => '[0-9]+'
    )
);

$router->add_route('/api/lights/:light_uuid/state', 'PUT',
    array(
        'controller' => 'light_state',
        'action' => 'light_state_update'
    ),
    array(
        'light_uuid' => '[0-9]+'
    )
);

$router->add_route('/api/lights/:light_uuid', 'DELETE',
    array(
        'controller' => 'light',
        'action' => 'light_delete'
    ),
    array(
        'light_uuid' => '[0-9]+'
    )
);

$router->add_route('/api/maps', 'GET',
    array(
        'controller' => 'maps',
        'action' => 'maps_read'
    )
);

$router->add_route('/api/maps/:map_uuid/lights', 'GET',
    array(
        'controller' => 'maps_lights',
        'action' => 'maps_lights_read'
    ),
    array(
        'map_uuid' => '[0-9]+'
    )
);

$router->add_route('/api/maps/:map_uuid/lights/:light_uuid', 'GET',
    array(
        'controller' => 'maps_light',
        'action' => 'maps_light_read'
    ),
    array(
        'map_uuid' => '[0-9]+',
        'light_uuid' => '[0-9]+'
    )
);

$router->add_route('/api/maps/:map_uuid/lights/:light_uuid', 'PUT',
    array(
        'controller' => 'maps_light',
        'action' => 'maps_light_update'
    ),
    array(
        'map_uuid' => '[0-9]+',
        'light_uuid' => '[0-9]+'
    )
);

$router->add_route('/api/scenes', 'GET',
    array(
        'controller' => 'scenes',
        'action' => 'scenes_read'
    )
);

$router->add_route('/api/scenes', 'POST',
    array(
        'controller' => 'scenes',
        'action' => 'create_scene'
    )
);

$router->add_route('/api/scenes/:scene_uuid', 'GET',
    array(
        'controller' => 'scene',
        'action' => 'scene_read'
    ),
    array(
        'scene_uuid' => '[0-9]+'
    )
);

$router->add_route('/api/scenes/:scene_uuid/on', 'POST',
    array(
        'controller' => 'scene',
        'action' => 'scene_active'
    ),
    array(
        'scene_uuid' => '[0-9]+'
    )
);

$router->add_route('/api/scenes/:scene_uuid/lights', 'GET',
    array(
        'controller' => 'scenes_lights',
        'action' => 'scenes_lights_read'
    ),
    array(
        'scene_uuid' => '[0-9]+'
    )
);

/*
 * lights and scenes are all in map
 */
