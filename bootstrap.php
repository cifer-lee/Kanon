<?php

/**
 * Set include path
 */
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR
. './controllers' . PATH_SEPARATOR
. './views' . PATH_SEPARATOR
. './models');

require 'controller.php';
require 'view.php';
require 'model.php';
