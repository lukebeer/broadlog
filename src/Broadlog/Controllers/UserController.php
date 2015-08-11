<?php

/*
 * This file is part of the Broadworks OCIP package https://github.com/LukeBeer/BroadworksOCIP
 *
 * Copyright (c) 2015 Luke Berezynskyj (aka Luke Beer)
 *
 * @author Luke Berezynskyj <eat.lemons@gmail.com>
 */

namespace Broadlog\Controllers;


use BroadworksOCIP\Client\Client;
use BroadworksOCIP\api\Rel_17_sp4_1_197_OCISchemaAS\OCISchemaUser as OCISchemaUser;


/**
 * Class UserController
 * @namespace Broadlog\Controllers
 */
class UserController
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
     * @param $userId
     * @param null $responseOutput
     * @return OCISchemaUser\UserGetResponse17sp4
     */
    public function getProfile($userId, $responseOutput = null)
    {
        $request = new OCISchemaUser\UserGetRequest17sp4($userId);
        return $request->get($this->client, $responseOutput);
    }

    /**
     * @param $userId
     * @param null $responseOutput
     * @return bool|\BroadworksOCIP\Builder\Types\TableType
     */
    public function getUserLinePortTable($userId, $responseOutput = null)
    {
        $request = new OCISchemaUser\UserLinePortGetListRequest($userId);
        return ($response = $request->get($this->client))
            ? $response->getLinePortTable()
            : false;
    }
}


