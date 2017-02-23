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
    'action' => 'index',
    'renderer' => 'index')
);

$router->add_route('/order/:timestamp', 'GET',
    array(
        'controller' => 'index',
        'action' => 'get_order',
        'renderer' => 'index'),
    array(
        'timestamp' => '[0-9]+'
    )
);

$router->add_route('/index.php', 'GET', array(
    'controller' => 'index',
    'action' => 'index',
    'renderer' => 'index')
);

/**
 * action, method of controller to handler this request
 * renderer, method of view to render result
 */
$router->add_route('/foos/:foo_id', 'GET',
    array(
        'controller' => 'index',
        'action' => 'index',
        'renderer' => 'index'),
    array(
        'foo_id' => '[0-9]+'
    )
);
