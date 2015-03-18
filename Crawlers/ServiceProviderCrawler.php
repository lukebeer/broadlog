<?php
namespace Broadlog\Crawlers;
require_once '../Config.php';
require_once BROADWORKS_OCIP_PATH . '/common.php';

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

    public function getUserListList($serviceProvider)
    {
        $users = [];
        $request = new UserGetListInServiceProviderRequest($serviceProvider);
        if ($response = $request->get($this->client)) {
            foreach ($response->getUserTable()->getAllRows() as $row) {
                $users[] = $row[0];
            }
        }
        return $users;
    }

    public function getAdminList($serviceProvider)
    {
        $admins = [];
        $request = new ServiceProviderAdminGetListRequest14($serviceProvider);
        if ($response = $request->get($this->client)) {
            foreach ($response->getServiceProviderAdminTable()->getAllRows() as $row) {
                $admins[] = $row[0];
            }
        }
        return $admins;
    }
}


