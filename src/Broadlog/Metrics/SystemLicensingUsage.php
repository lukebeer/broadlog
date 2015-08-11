<?php
namespace Broadlog\Metrics;


use Broadlog\Crawlers\SystemCrawler;
use Broadlog\Controllers\MetricController;


$client = Factory::getTCPClient(OCIP_HOST);
$client->login(OCIP_USER, OCIP_PASS);

$controller = new MetricController();
$systemCrawler = new SystemCrawler($client);

$response = $systemCrawler->getSystemLicensing();

$controller->setMetric('broadworks.' . OCIP_NAME . '.users.trunk');
$controller->send($response->getNumberOfTrunkUsers());

$subscriberLicense = $response->getSubscriberLicenseTable();
foreach ($subscriberLicense->getAllRows() as $row) {
    $name = lcfirst(str_replace(' ', '', ucwords(strtr($row[0], '_ -', ' '))));
    $controller->setMetric('broadworks.' . OCIP_NAME . '.licensing.subscriber.'.$name);
    $controller->send($row[2]);
}

$groupLicense = $response->getGroupServiceLicenseTable();
foreach ($groupLicense->getAllRows() as $row) {
    $name = lcfirst(str_replace(' ', '', ucwords(strtr($row[0], '_ -', ' '))));
    $controller->setMetric('broadworks.' . OCIP_NAME . '.licensing.group.' . $name);
    $controller->send($row[2]);
}

$virtualLicense = $response->getVirtualServiceLicenseTable();
foreach ($virtualLicense->getAllRows() as $row) {
    $name = lcfirst(str_replace(' ', '', ucwords(strtr($row[0], '_ -', ' '))));
    $controller->setMetric('broadworks.' . OCIP_NAME . '.licensing.virtual.' . $name);
    $controller->send($row[2]);
}

$userLicense = $response->getUserServiceLicenseTable();
foreach ($userLicense->getAllRows() as $row) {
    $name = lcfirst(str_replace(' ', '', ucwords(strtr($row[0], '_ -', ' '))));
    $controller->setMetric('broadworks.' . OCIP_NAME . '.licensing.user.' . $name);
    $controller->send($row[2]);
    $controller->setMetric('broadworks.' . OCIP_NAME . '.licensing.user.hosted.' . $name);
    $controller->send($row[3]);
    $controller->setMetric('broadworks.' . OCIP_NAME . '.licensing.user.trunk.' . $name);
    $controller->send($row[4]);
}

$systemLicense = $response->getSystemParamLicenseTable();
foreach ($systemLicense->getAllRows() as $row) {
    $name = lcfirst(str_replace(' ', '', ucwords(strtr($row[0], '_ -', ' '))));
    $controller->setMetric('broadworks.' . OCIP_NAME . '.licensing.params.' . $name);
    $controller->send($row[2]);
}