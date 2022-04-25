<?php

use Pendella\SpeedTest\DB;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

$em = DB::getEntityManager();
return ConsoleRunner::createHelperSet($em);
