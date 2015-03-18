<?php
namespace Broadlog\Metrics;
require_once '../Config.php';
require_once BROADWORKS_OCIP_PATH  . '/common.php';

use Broadlog\Crawlers\ServiceProviderCrawler;
use Broadlog\Crawlers\SystemCrawler;
use Broadlog\Controllers\MetricController;
use Broadworks_OCIP\CoreFactory;


$client = CoreFactory::getTCPClient(OCIP_HOST);
$client->login(OCIP_USER, OCIP_PASS);

$controller = new MetricController();
$systemCrawler = new SystemCrawler($client);
$serviceProviderCrawler = new ServiceProviderCrawler($client);

foreach ($systemCrawler->getServiceProviderList() as $sp) {
    $controller->setMetric('broadworks.' . OCIP_NAME . ".enterprises.{$sp}.admins");
    $count = count($serviceProviderCrawler->getAdminList($sp));
    $controller->send($count);
    echo "Admins: $sp $count \n";
}