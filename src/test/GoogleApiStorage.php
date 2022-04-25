<?php

namespace Pendella\SpeedTest\Test;


use Pendella\SpeedTest\Entity\CompanyProductURL;
use Pendella\SpeedTest\Entity\TestResult;

class GoogleApiStorage extends Storage
{
    public function store(CompanyProductURL $url, array $res) {
        foreach ($res as $testTypeKey => $testType) {
            foreach ($testType as $indicatorKey => $indicator) {
                $testResult = (new TestResult())
                    ->setTestDate(new \DateTime())
                    ->setTestType($testTypeKey)
                    ->setResTitle($indicatorKey)
                    ->setUrl($url)
                    ->setScore($indicator['score'])
                    ->setDisplayValue($indicator['displayValue']);
                $this->em->persist($testResult);
                $this->em->flush();
            }
        }
    }
}
