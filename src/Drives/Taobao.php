<?php

namespace Draguo\Ip\Drives;

use Draguo\Ip\Exceptions\InvalidRequest;
use Draguo\Ip\Support\HttpRequest;

class Taobao extends Driver
{
    use HttpRequest;

    const ENDPOINT = 'http://ip.taobao.com/service/getIpInfo.php';

    /**
     * @param string $ip
     * @return array
     * @throws InvalidRequest
     */
    public function toLocation($ip)
    {
        return $this->transformRequest($this->toLocationRaw($ip));
    }

    /**
     * @param $ip
     * @return \Draguo\Ip\Contracts\json|mixed
     */
    public function toLocationRaw($ip)
    {
        $query = [
            'ip' => $ip
        ];

        $request = json_decode($this->getRequest(self::ENDPOINT, $query), true);


        return $request;
    }

    /**
     * @param $request
     * @return array
     * @throws InvalidRequest
     */
    public function transformRequest($request)
    {
        if ($request['code'] !== 0) {
            throw new InvalidRequest($request['data']);
        }
        $data = $request['data'];
        return [
            'country' => $data['country'],
            'province' => $data['region'],
            'city' => $data['city'],
            'adcode' => $data['city_id'],
            'lng' => '',
            'lat' => '',
            'isp' => $data['isp'],
        ];
    }
}