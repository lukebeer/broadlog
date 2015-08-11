<?php
namespace Broadlog\Metrics;

use Broadlog\Crawlers\ServiceProviderCrawler;
use Broadlog\Crawlers\SystemCrawler;
use Broadlog\Controllers\MetricController;
use Broadworks_OCIP\CoreFactory;



$controller = new MetricController();
$systemCrawler = new SystemCrawler($client);
$serviceProviderCrawler = new ServiceProviderCrawler($client);

foreach ($systemCrawler->getServiceProviderList() as $sp) {
    $controller->setMetric('broadworks.' . OCIP_NAME . ".enterprises.{$sp}.admins");
    $count = count($serviceProviderCrawler->getAdminList($sp));
    $controller->send($count);
    echo "Admins: $sp $count \n";
}