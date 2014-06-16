<?php

/**
 * Kanon --- A extremely light-weight PHP MVC framework
 *
 * @author      Cifer <mantianyu@gmail.com>
 * @copyright   2014 Cifer
 * @version     1.0
 *
 *  * MIT LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

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
        'button_id' => '[0-9a-zA-Z]+'
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

$router->add_route('/api/lights/check-new', 'POST',
    array(
        'controller' => 'lights',
        'action' => 'lights_check_new'
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
