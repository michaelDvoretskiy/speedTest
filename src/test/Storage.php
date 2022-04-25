<?php

namespace Pendella\SpeedTest\Test;


use Pendella\SpeedTest\DB;
use Pendella\SpeedTest\Entity\CompanyProductURL;

abstract class Storage
{
    protected $em;

    function __construct()
    {
        $this->em = DB::getEntityManager();
    }

    public abstract function store(CompanyProductURL $url, array $res);
}
