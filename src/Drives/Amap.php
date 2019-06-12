<?php

namespace Draguo\Ip\Drives;

use Draguo\Ip\Exceptions\InvalidRequest;
use Draguo\Ip\Support\HttpRequest;

class Amap extends Driver
{

    use HttpRequest;

    const ENDPOINT = 'http://restapi.amap.com/v3/ip';

    /**
     * @param string $ip
     *
     * @return array
     * @throws InvalidRequest
     */
    public function toLocation($ip)
    {
        return $this->transformRequest($this->toLocationRaw($ip));
    }

    /**
     * @param        $ip
     *
     * @return array
     */
    public function toLocationRaw($ip)
    {
        $request = $this->getRequest(self::ENDPOINT, [
            'key' => $this->config,
            'ip' => $ip,
        ]);

        return $request;
    }

    /**
     * @param $request
     * @return array
     * @throws InvalidRequest
     */
    private function transformRequest($request)
    {
        if ($request['infocode'] != 10000) {
            throw  new InvalidRequest($request['info']);
        }
        if (!$request['province']) {
            throw  new InvalidRequest('amap not support');
        }
        return [
            'country' => '',
            'province' => $request['province'],
            'city' => $request['city'],
            'adcode' => $request['adcode'],
            'lng' => '',
            'lat' => '',
            'isp' => ''
        ];
    }
}