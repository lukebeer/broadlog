<?php
namespace Broadlog\Metrics;

use Broadlog\Controllers\MetricController;


$controller = new MetricController();
$controller->setMetric('broadworks.live.appserver.ASActiveCalls');

if ($stat = snmp2_get('', '', '.1.3.6.1.4.1.6431.1.2.7.1.10.0')) {
    $controller->send($stat);
}