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

class Route {

    /**
     * @var string The route pattern
     */
    private $pattern;

    /**
     * @var string The route controller
     */
    private $controller_name;

    /**
     * @var string The route action in controller
     */
    private $action_name;

    /**
     * @var string The route view 
     */
    private $view_name;

    /**
     * \var string The route renderer name
     */
    private $renderer_name;

    /**
     * @var string The route model
     */
    private $model_name;

    /**
     * @var string The http_method supported by this route
     */
    private $http_method;

    /**
     * @var array The parameters extracted from the url
     */
    private $params;

    public function __construct($pattern, $method, $handler) {
        $this->pattern = $pattern;
        $this->http_method = $method;
        $this->controller_name = $handler['controller'];
        $this->view_name = $handler['controller'];
        $this->model_name = $handler['controller'];
        $this->action_name = $handler['action'];
        $this->renderer_name = $handler['renderer'];
    }

    public function matches($url) {
        if (preg_match($this->pattern, $url, $this->params)) {
            /** 
             * pop the first param which is the url passed in 
             */
            array_shift($this->params);

            /**
             * if not specify request format, default to json
             */
            if (! in_array('json', $this->params, false) &&
                ! in_array('xml', $this->params, false)) {
                    $this->params[] = 'json';
                }

            return TRUE;
        }
    }

    public function http_method() {
        return $this->http_method;
    }

    /**
     * Dispatch this route
     */
    public function dispatch() {
        require "{$this->controller_name}_controller.php";
        require "{$this->view_name}_view.php";
        require "{$this->model_name}_model.php";

        $controller_class_name = $this->underscore_to_camelcase($this->controller_name) . 'Controller';
        $view_class_name = $this->underscore_to_camelcase($this->view_name) . 'View';
        $model_class_name = $this->underscore_to_camelcase($this->model_name) . 'Model';

        $model = new $model_class_name();
        $controller = new $controller_class_name($model);
        $view = new $view_class_name($model);

        /**
         * 将 $_GET 合并到 $this->params, 一并传给 controller 和 view
         *
         * 你可能会担心, 如此一来, 如果 querystring 里有数字命名的参数
         * (比如 name=cifer&2=22)的话, array_merge 时这个数字会不会被 
         * renumber, 不会的, 因为 $_GET 中的 key 都是字符串类型的, 即
         * 使是数字. 而 $this->params 里面的 key 都是整数的.
         *
         * 另外, array_merge 时, $_GET 在前, $this->params 在后, 这个
         * 顺序不要变, 因为请求格式在 $this->params 的最后, 在 view 里
         * 我们需要将最后一个值 pop 出来以确定请求格式.
         */
        $this->params = array_merge($_GET, $this->params);

        $controller->{$this->action_name}($this->params);
        $view->{$this->renderer_name}($this->params);
    }

    public function underscore_to_camelcase($source) {
        $source = ucfirst($source);
        $pos = 0;
        while(($pos = strpos($source, '_', $pos))) {
            $source[$pos + 1] = strtoupper($source[$pos + 1]);
            $pos++;
        }

        $source = str_replace('_', '', $source);
        return $source;
    }
}
