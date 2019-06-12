<?php

namespace Draguo\Ip\Contracts;

interface Transform
{
    /**
     * transform ip to location
     * @param string $ip
     *
     * @return array
     */
    public function toLocation($ip);

    /**
     * @param        $ip
     *
     * @return json
     */
    public function toLocationRaw($ip);

}