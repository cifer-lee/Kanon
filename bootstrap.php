<?php

/**
 * Set path macro
 */
if('/' === dirname(__FILE__)) {
    define('ROOT', '');
} else {
    define('ROOT', dirname(__FILE__));
}

define('CONTROLLERS', ROOT . '/controllers');
define('VIEWS', ROOT . '/views');
define('MODELS', ROOT . '/models');
define('DB', ROOT . '/models/sqlite');
define('TEMPLATES', ROOT . '/templates');

/**
 * Set include path
 */
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR
. CONTROLLERS . PATH_SEPARATOR
. VIEWS . PATH_SEPARATOR
. MODELS . PATH_SEPARATOR
. DB . PATH_SEPARATOR
. TEMPLATES);

require 'controller.php';
require 'view.php';
require 'model.php';
require 'db.php';

define ('HTTP_METHOD_GET', 'GET');
define ('HTTP_METHOD_POST', 'POST');
define ('HTTP_METHOD_PUT', 'PUT');
define ('HTTP_METHOD_DELETE', 'DELETE');
