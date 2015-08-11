<?php

/*
 * This file is part of the Broadlog package https://github.com/lukebeer/broadlog
 *
 * Copyright (c) 2015 Luke Berezynskyj (aka Luke Beer)
 *
 * @author Luke Berezynskyj <mail@luke.beer>
 */

namespace Broadlog\Reports;


use Broadlog\Controllers\UserController;
use Broadlog\Crawlers\ServiceProviderCrawler;
use Broadlog\Crawlers\SystemCrawler;
use Broadlog\Storage\OutputInterface;
use BroadworksOCIP\Client\Client;
use BroadworksOCIP\Client\Transport\TCPTransport;
use BroadworksOCIP\Response\ResponseOutput;
use Elasticsearch\Client as ESClient;
use Symfony\Component\Config\Definition\Exception\Exception;
use Predis; Predis\Autoloader::register();

/**
 * Class UserReport
 * @namespace Broadlog\Reports
 */
class UserReport
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
        $this->client                 = $client;
        $this->userController         = new UserController($this->client);
        $this->systemCrawler          = new SystemCrawler($this->client);
        $this->serviceProviderCrawler = new ServiceProviderCrawler($this->client);
    }

    /**
     * @param null $output
     */
    public function runAllUsersInSystemReport(OutputInterface $output = null)
    {
        foreach ($this->systemCrawler->getServiceProviderTable()->getColumn(0) as $serviceProviderId) {
            foreach ($this->serviceProviderCrawler->getUserList($serviceProviderId)->getColumn(0) as $user) {
                $userProfile = json_decode($this->userController->getProfile($user, ResponseOutput::JSON));
                if ($linePortTable = $this->userController->getUserLinePortTable($user)) {
                    foreach ($linePortTable->getAllRows() as $row) {
                        $userProfile->linePortTable[] = array_combine($linePortTable->getColHeadings(), $row);
                    }
                }
                try {
                    $output->write(json_encode($userProfile));
                } catch (Exception $e) {
                    print_r($e);
                    continue;
                }
            }
        }
    }
}
