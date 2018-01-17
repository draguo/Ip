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

    /**
     * @param        $ip
     * @param Config $config
     *
     * @return json
     */
    public function toLocationRaw($ip, Config $config);

}