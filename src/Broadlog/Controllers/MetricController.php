<?php
namespace Broadlog\Controllers;
require_once '../Config.php';


class MetricController
{
    private $sock;
    private $metric;

    public function __construct()
    {
        $this->sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
    }

    public function setMetric($metric)
    {
        $this->metric = $metric;
    }

    public function getMetric()
    {
        return $this->metric;
    }

    public function send($value, $metric = null, $date = null)
    {
        if (($value) && ($this->getMetric())) {
            $metric = ($metric) ?: $this->getMetric();
            $stamp = new \DateTime();
            $stamp = $stamp->getTimestamp();
            $stamp = ($date) ?: $stamp;
            $message = "$metric $value $stamp\n";
            socket_sendto($this->sock, $message, strlen($message), 0, BL_METRIC_HOST, BL_METRIC_PORT);
        }
    }
}