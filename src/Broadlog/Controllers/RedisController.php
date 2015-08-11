<?php
namespace Broadlog\Controllers;


/**
 * Class RedisController
 * @namespace Broadlog\Controllers
 */
class RedisController
{
    /**
     * @var resource
     */
    private $sock;
    /**
     * @var
     */
    private $metric;
    /**
     * @var bool
     */
    private $useTCP;

    /**
     * @param bool|false $useTCP
     */
    public function __construct($useTCP = false)
    {
        $this->useTCP = $useTCP;
        $this->sock = ($useTCP)
            ? fsockopen(BL_METRIC_HOST, BL_METRIC_PORT)
            : socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
    }

    /**
     * @param $metric
     */
    public function setMetric($metric)
    {
        $this->metric = $metric;
    }

    /**
     * @return mixed
     */
    public function getMetric()
    {
        return $this->metric;
    }

    /**
     * @param $value
     * @param null $metric
     * @param null $date
     * @return int
     */
    public function send($value, $metric = null, $date = null)
    {
        if ($value) {
            $metric = ($metric) ?: $this->getMetric();
            $stamp = new \DateTime();
            $stamp = $stamp->getTimestamp();
            $stamp = ($date) ?: $stamp;
            $message = "$metric $value $stamp\n";
            return ($this->useTCP)
                ? fwrite($this->sock, $message, strlen($message))
                : socket_sendto($this->sock, $message, strlen($message), 0, BL_METRIC_HOST, BL_METRIC_PORT);
        }
    }

    /**
     *
     */
    public function __destruct()
    {
        @fclose($this->sock);
    }
}