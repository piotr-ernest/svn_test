<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../../library'),
    get_include_path(),
)));

set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

defined('ROOT') ||
define('ROOT', dirname(APPLICATION_PATH));

defined('ADMIN_ROOT') ||
define('ADMIN_ROOT', dirname(APPLICATION_PATH).'/admin');

defined('FRONTEND_PATH') ||
define('FRONTEND_PATH', APPLICATION_PATH . '/modules/frontend');

defined('ADMIN_PATH') ||
define('ADMIN_PATH', APPLICATION_PATH . '/modules/admin');

defined('REPORTS_PATH') ||
define('REPORTS_PATH', dirname(APPLICATION_PATH) . '/reports');

//echo get_include_path();

/** Zend_Application */
require_once 'Zend/Application.php';
include 'rnest/functions.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/admin.php'
);
$application->bootstrap()
                  ->run();