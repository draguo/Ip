<?php

namespace Draguo\Ip\Drives;

use Draguo\Ip\Exceptions\InvalidRequest;
use Draguo\Ip\Support\Config;
use Draguo\Ip\Support\HttpRequest;

class Taobao extends Driver
{
    use HttpRequest;

    const ENDPOINT = 'http://ip.taobao.com/service/getIpInfo.php';

    public function toLocation($ip, Config $config)
    {
        return $this->transformRequest($this->toLocationRaw($ip, $config));
    }

    public function toLocationRaw($ip, Config $config)
    {
        $query = [
            'ip' => $ip
        ];

        $request = json_decode($this->getRequest(self::ENDPOINT, $query), true);
        if ($request['code'] !== 0) {
            throw new InvalidRequest($request['data']);
        }

        return $request;
    }

    /**
     * @param $request
     *
     * @return array
     * [country,province,city,adcode,lng, // 精度lat, // 维度 isp, // 服务商 ]
     *
     */
    public function transformRequest($request)
    {
        $this->transformResult = $request['data'];

        return [
            'country'  => $this->handleUndefinedIndex('country'),
            'province' => $this->handleUndefinedIndex('region'),
            'city'     => $this->handleUndefinedIndex('city'),
            'adcode'   => $this->handleUndefinedIndex('city_id'),
            'lng'      => '',
            'lat'      => '',
            'isp'      => $this->handleUndefinedIndex('isp')
        ];
    }
}