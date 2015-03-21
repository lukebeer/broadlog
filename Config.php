<?php
namespace Broadlog;

define('BROADLOG_PATH', dirname(__DIR__));
set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . PATH_SEPARATOR . BROADLOG_PATH);
spl_autoload_register(function ($c) {
    require_once preg_replace('#\\\|_(?!.*\\\)#', '/', $c) . '.php';
});

define('BROADWORKS_OCIP_PATH', '/Path/To/Broadworks_OCIP');
define('OCIP_HOST', 'ocip.exampe.com');
define('OCIP_USER', 'username');
define('OCIP_PASS', 'password');
define('OCIP_NAME', 'live');

define('BL_METRIC_HOST', '127.0.0.1');
define('BL_METRIC_PORT', 2003);
