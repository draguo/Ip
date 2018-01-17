<?php

namespace Draguo\Ip\Drives;


use Draguo\Ip\Contracts\Transform;
use Draguo\Ip\Exceptions\InvalidRequest;
use Draguo\Ip\Support\Config;
use Draguo\Ip\Support\HttpRequest;

class Baidu implements Transform
{

    use HttpRequest;

    const ENDPOINT = 'https://api.map.baidu.com/location/ip';

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

    public function toLocationRaw($ip, Config $config)
    {
        $query = [
            'ip'   => $ip,
            'ak'   => $config->get('key'),
            'coor' => 'gcj02'
        ];

        $request = $this->getRequest(self::ENDPOINT, $query);
        if ($request['status'] !== 0) {
            throw new InvalidRequest($request['message']);
        }
        return $request;
    }

    private function transformRequest($request)
    {
        $content = $request['content'];
        return [
            'country'  => '',
            'province' => $content['address_detail']['province'],
            'city'     => $content['address_detail']['city'],
            'adcode'   => '',
            'lng'      => $content['point']['x'],
            'lat'      => $content['point']['y'],
            'isp'      => ''
        ];
    }
}