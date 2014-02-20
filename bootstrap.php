<?php

/**
 * Set include path
 */
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR
. './controllers' . PATH_SEPARATOR
. './views' . PATH_SEPARATOR
. './models' . PATH_SEPARATOR
. './templates');

require 'controller.php';
require 'view.php';
require 'model.php';

define ('HTTP_METHOD_GET', 'GET');
define ('HTTP_METHOD_POST', 'POST');
define ('HTTP_METHOD_PUT', 'PUT');
define ('HTTP_METHOD_DELETE', 'DELETE');

error_reporting(E_ALL);
