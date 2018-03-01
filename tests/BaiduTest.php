<?php

namespace Draguo\Ding\Tests;

use Draguo\Ip\Ip;

class BaiduTest extends TestCase
{
    private function app()
    {
        $config = [
            'driver' => 'Baidu',
            'key' => 'TdRp7Cso9R1u7d0mc3GP1nNuF2OoA7X0'
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
