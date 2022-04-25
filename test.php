<?php

use Pendella\SpeedTest\DB;
use Pendella\SpeedTest\Test\GoogleApiTest;
use Pendella\SpeedTest\Test\Test;
use Pendella\SpeedTest\Test\GoogleApiStorage;
use Pendella\SpeedTest\Entity\CompanyProductURL;

require_once "./vendor/autoload.php";

$em = DB::getEntityManager();
//$urlList = $em->getRepository(CompanyProductURL::class)->findAll();
$criteria = new \Doctrine\Common\Collections\Criteria();
$criteria->where(\Doctrine\Common\Collections\Criteria::expr()->gt('id', 61));
$urlList = $em->getRepository(CompanyProductURL::class)->matching($criteria);
$apiTest = new GoogleApiTest();
$apiStorage = new GoogleApiStorage();
foreach ($urlList as $url) {
    /** @var CompanyProductURL $url */
    if ($url->getUrl() != '') {
        $res = $apiTest->getResults($url->getUrl(), Test::TYPE_BOTH);
        $apiStorage->store($url, $res);
        echo implode(" ", [
                $url->getCompany()->getName(),
                $url->getProduct()->getName(),
                $url->getUrl()
            ]) . " completed\r\n";
    }
}
