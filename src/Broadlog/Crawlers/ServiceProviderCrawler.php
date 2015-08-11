<?php

/*
 * This file is part of the Broadlog package https://github.com/lukebeer/broadlog
 *
 * Copyright (c) 2015 Luke Berezynskyj (aka Luke Beer)
 *
 * @author Luke Berezynskyj <mail@luke.beer>
 */

namespace Broadlog\Crawlers;


use BroadworksOCIP\Client\Client;
use BroadworksOCIP\Builder\Types\TableType;
use BroadworksOCIP\api\Rel_17_sp4_1_197_OCISchemaAS\OCISchemaUser as OCISchemaUser;
use BroadworksOCIP\api\Rel_17_sp4_1_197_OCISchemaAS\OCISchemaGroup as OCISchemaGroup;
use BroadworksOCIP\api\Rel_17_sp4_1_197_OCISchemaAS\OCISchemaServiceProvider as OCISchemaServiceProvider;


/**
 * Class ServiceProviderCrawler
 * @namespace Broadlog\Crawlers
 */
class ServiceProviderCrawler
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @param Client $client
     */
    public function __construct(Client &$client)
    {
        $this->client = $client;
    }

    /**
     * @param $serviceProvider
     * @return bool|TableType
     */
    public function getUserList($serviceProvider)
    {
        $request = new OCISchemaUser\UserGetListInServiceProviderRequest($serviceProvider);
        return ($response = $request->get($this->client))
            ? $response->getUserTable()
            : false;
    }

    /**
     * @param $serviceProvider
     * @return bool|TableType
     */
    public function getAdminList($serviceProvider)
    {
        $request = new OCISchemaServiceProvider\ServiceProviderAdminGetListRequest14($serviceProvider);
        return ($response = $request->get($this->client))
            ? $response->getServiceProviderAdminTable()
            : false;
    }

    /**
     * @param $serviceProvider
     * @return bool|TableType
     */
    public function getAccessDeviceList($serviceProvider)
    {
        $request = new OCISchemaServiceProvider\ServiceProviderAccessDeviceGetListRequest($serviceProvider);
        return ($response = $request->get($this->client))
            ? $response->getAccessDeviceTable()
            : false;
    }

    /**
     * @param $serviceProvider
     * @return bool|TableType
     */
    public function getServicePackAuthorizationList($serviceProvider)
    {
        $request = new OCISchemaServiceProvider\ServiceProviderServiceGetAuthorizationListRequest($serviceProvider);
        return ($response = $request->get($this->client))
            ? $response->getGroupServicesAuthorizationTable()
            : false;
    }
}


