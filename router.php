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

namespace Kanon;

require 'route.php';

class Router {

    /**
     * @var array The routes maintained in this router
     */
    private $routes;

    public function __construct() {
        $routes = array();
    }

    /*
    public function add_route($pattern, $callable) {
        $route = new \Kanon\Route($pattern, $callable);
        $this->routes[] = $route;
    }
     */


    /**
     * Add a new route to this router. 
     *
     * Parameters:
     *
     * First:   string  The URL pattern (required)
     * Second:  string  The HTTP method supported by the new route (required)
     * Third:   array   The controller and action associated (optional)
     * Forth:   array   The parameters's pattern in URL pattern (optional)
     *
     */
    public function add_route() {
        $args = func_get_args();

        $pattern = $args[0];
        $method = strtoupper($args[1]);
        $handler = $args[2];

        $handler_default = array('controller' => 'index', 'action' => 'index');
        $handler = array_merge($handler_default, $handler);

        if(isset($args[3])) {
            $pattern = convert_url_pattern($pattern, ':', $args[3]);
        }

        $pattern = '#^' . $pattern . '$#';

        $route = new \Kanon\Route($pattern, $method, $handler);
        $this->routes[] = $route;
    }

    public function find_route($source, $method) {
        foreach ($this->routes as $route) {
            if ($route->matches($source) && !strcasecmp($route->http_method(), $method)) {
                return $route;
            }
        }

        return NULL;
    }

    /**
     * Convert a URL parameter (e.g. ":id", ":id+") into a regular expression
     *
     * @param   source          string
     * @param   marker          string
     * @param   replacements    array
     *
     * @return  string          
     */ 
    private function convert_url_pattern($source, $marker, $replacements) {
        foreach($replacements as $key => $value) {
            $source = str_replace($marker . $key, '(' . $value . ')', $source);
        }

        return $source;
    }
}
