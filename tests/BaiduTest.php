<?php

namespace Draguo\Ding\Tests;

use Draguo\Ip\Ip;

class BaiduTest extends TestCase
{
    private function app()
    {
        return new Ip();
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
