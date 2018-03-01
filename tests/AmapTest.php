<?php

namespace Draguo\Ding\Tests;

use Draguo\Ip\Ip;

class AmapTest extends TestCase
{
    private function app()
    {
        $config = [
            'driver' => 'amap',
            'key' => 'f4ba346f41afbdc1d3f7b277a3db7ff4'
        ];

        return new Ip($config);
    }

    public function testTransform()
    {
        $this->app()->toLocation($this->testIp);
    }

    public function testTransformRaw()
    {
        $this->app()->toLocationRaw($this->testIp);
    }
}
