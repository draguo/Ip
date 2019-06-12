<?php

namespace Draguo\Ip\Drives;

use Draguo\Ip\Contracts\Transform;

abstract class Driver implements Transform
{
    protected $transformResult = [];
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    protected function getResultFormat()
    {
        return [
            'country'  => '',
            'province' => '',
            'city'     => '',
            'adcode'   => '',
            'lng'      => '',
            'lat'      => '',
            'isp'      => ''
        ];
    }

}