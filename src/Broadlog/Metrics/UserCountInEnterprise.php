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
    $controller->setMetric('broadworks.'.OCIP_NAME.".enterprises.{$sp}.users");
    $count = count($serviceProviderCrawler->getUserList($sp));
    $controller->send($count);
    echo "Users: $sp $count \n";
}