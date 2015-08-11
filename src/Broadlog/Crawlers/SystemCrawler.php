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
use BroadworksOCIP\api\Rel_17_sp4_1_197_OCISchemaAS\OCISchemaUser as OCISchemaUser;
use BroadworksOCIP\api\Rel_17_sp4_1_197_OCISchemaAS\OCISchemaGroup as OCISchemaGroup;
use BroadworksOCIP\api\Rel_17_sp4_1_197_OCISchemaAS\OCISchemaServiceProvider as OCISchemaServiceProvider;
use BroadworksOCIP\api\Rel_17_sp4_1_197_OCISchemaAS\OCISchemaSystem as OCISchemaSystem;


/**
 * Class SystemCrawler
 * @namespace Broadlog\Crawlers
 */
class SystemCrawler
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
     * @return bool|\BroadworksOCIP\Builder\Types\TableType
     */
    public function getServiceProviderTable()
    {
        $request = new OCISchemaServiceProvider\ServiceProviderGetListRequest();
        return ($response = $request->get($this->client))
            ? $response->getServiceProviderTable()
            : false;
    }

    /**
     * @return bool|OCISchemaSystem\SystemLicensingGetSystemLicenseListResponse
     */
    public function getSystemLicensing()
    {
        $request = new OCISchemaSystem\SystemLicensingGetSystemLicenseListRequest();
        return ($response = $request->get($this->client))
            ? $response
            : false;
    }
}


