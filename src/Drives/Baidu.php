<?php

namespace Draguo\Ip\Drives;


use Draguo\Ip\Exceptions\InvalidRequest;
use Draguo\Ip\Support\HttpRequest;

class Baidu extends Driver
{

    use HttpRequest;

    const ENDPOINT = 'https://api.map.baidu.com/location/ip';

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

    public function toLocationRaw($ip)
    {
        $query = [
            'ip' => $ip,
            'ak' => $this->config,
            'coor' => 'gcj02'
        ];

        $request = $this->getRequest(self::ENDPOINT, $query);


        return $request;
    }

    private function transformRequest($request)
    {
        if ($request['status'] !== 0) {
            throw new InvalidRequest($request['message']);
        }

        $data = $request['content'];

        return [
            'country' => '',
            'province' => $data['address_detail']['province'],
            'city' => $data['address_detail']['city'],
            'adcode' => '',
            'lng' => $data['point']['x'],
            'lat' => $data['point']['y'],
            'isp' => ''
        ];
    }

}