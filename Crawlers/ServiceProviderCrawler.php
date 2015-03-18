<?php
namespace Broadlog\Crawlers;
require_once '../Config.php';
require_once BROADWORKS_OCIP_PATH . '/common.php';

use Broadworks_OCIP\api\Rel_17_sp4_1_197_OCISchemaAS\OCISchemaServiceProvider\ServiceProviderAccessDeviceGetListRequest;
use Broadworks_OCIP\api\Rel_17_sp4_1_197_OCISchemaAS\OCISchemaServiceProvider\ServiceProviderAdminGetListRequest14;
use Broadworks_OCIP\api\Rel_17_sp4_1_197_OCISchemaAS\OCISchemaUser\UserGetListInServiceProviderRequest;
use Broadworks_OCIP\core\Client\Client;


class ServiceProviderCrawler
{
    private $client;

    public function __construct(Client &$client)
    {
        $this->client = $client;
    }

    public function getUserList($serviceProvider)
    {
        $list = [];
        $request = new UserGetListInServiceProviderRequest($serviceProvider);
        if ($response = $request->get($this->client)) {
            foreach ($response->getUserTable()->getAllRows() as $row) {
                $list[] = $row[0];
            }
        }
        return $list;
    }

    public function getAdminList($serviceProvider)
    {
        $list = [];
        $request = new ServiceProviderAdminGetListRequest14($serviceProvider);
        if ($response = $request->get($this->client)) {
            foreach ($response->getServiceProviderAdminTable()->getAllRows() as $row) {
                $list[] = $row[0];
            }
        }
        return $list;
    }

    public function getAccessDeviceList($serviceProvider)
    {
        $list = [];
        $request = new ServiceProviderAccessDeviceGetListRequest($serviceProvider);
        if ($response = $request->get($this->client)) {
            foreach ($response->getAccessDeviceTable()->getAllRows() as $row) {
                $list[] = $row[0];
            }
        }
        return $list;
    }
}


