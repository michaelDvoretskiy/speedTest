<?php

namespace Pendella\SpeedTest\Test;


abstract class Test
{
    const TYPE_BOTH = 0;
    const TYPE_DESKTOP = 1;
    const TYPE_MOBILE = 2;

    public abstract function getResults(string $url, int $type);
}
