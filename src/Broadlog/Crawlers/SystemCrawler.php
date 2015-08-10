<?php
namespace Broadlog\Crawlers;
require_once '../Config.php';
require_once BROADWORKS_OCIP_PATH . '/common.php';

use Broadworks_OCIP\api\Rel_17_sp4_1_197_OCISchemaAS\OCISchemaSystem\SystemLicensingGetRequest14sp3;
use Broadworks_OCIP\api\Rel_17_sp4_1_197_OCISchemaAS\OCISchemaServiceProvider\ServiceProviderGetListRequest;
use Broadworks_OCIP\core\Client\Client;


class SystemCrawler
{
    private $client;
    private $sps = [];

    public function __construct(Client &$client)
    {
        $this->client = $client;
    }

    public function getServiceProviderList()
    {
        if (count($this->sps) > 0) {
            return $this->sps;
        }
        $spListRequest = new ServiceProviderGetListRequest();
        $spListResponse = $spListRequest->get($this->client);
        foreach ($spListResponse->getServiceProviderTable()->getAllRows() as $spRow) {
            $this->sps[] = $spRow[0];
        }
        return $this->sps;
    }

    public function getSystemLicensing()
    {
        $request = new SystemLicensingGetRequest14sp3();
        $response = $request->get($this->client);
        return $response;
    }
}


