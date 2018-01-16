<?php

namespace Draguo\Ip\Contracts;

use Draguo\Ip\Support\Config;

interface Transform
{
    /**
     * transform ip to location
     * @param string $ip
     * @param Config $config
     *
     * @return array
     */
    public function toLocation($ip, Config $config);

    public function toLocationRaw($ip, Config $config);
}