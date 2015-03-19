<?php
$file = ((isset($argv[1]) && (file_exists($argv[1])))) ? $argv[1] : 'Config.php';

if (file_exists($file)) {
    chdir(__DIR__.'/Metrics');
    system('php AdminCountInEnterprise.php');
    system('php UserCountInEnterprise.php');
    system('php AccessDeviceCountInEnterprise.php');
    system('php SystemLicensingUsage.php');
}