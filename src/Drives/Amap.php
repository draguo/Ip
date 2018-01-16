<?php

namespace Draguo\Ip\Drives;


use Draguo\Ip\Contracts\Transform;
use Draguo\Ip\Exceptions\InvalidRequest;
use Draguo\Ip\Support\Config;
use Draguo\Ip\Support\HttpRequest;

class Amap implements Transform
{

    use HttpRequest;

    const ENDPOINT = 'http://restapi.amap.com/v3/ip';

    /**
     * @param string $ip
     * @param Config $config
     *
     * @return array
     * @throws InvalidRequest
     */
    public function toLocation($ip, Config $config)
    {
        return $this->transformRequest($this->toLocationRaw($ip, $config));
    }

    /**
     * @param        $ip
     * @param Config $config
     *
     * @return array
     * @throws InvalidRequest
     */
    public function toLocationRaw($ip, Config $config)
    {
        $query = [
            'key' => $config->get('key'),
            'ip'  => $ip,
        ];

        $request = $this->getRequest(self::ENDPOINT, $query);
        if ($request['status'] == 0) {
            throw new InvalidRequest($request['info']);
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
        $outArr  = [
            'country'  => '',
            'province' => '',
            'city'     => '',
            'adcode'   => '',
            'lng'      => '',
            'lat'      => '',
            'isp'      => ''
        ];
        $keys    = ['province', 'city', 'adcode'];
        $needArr = array_intersect_key($request, array_flip((array)$keys));

        return array_merge($outArr, $needArr);
    }
}