<?php
/**
 * author: draguo
 */

namespace Draguo\Ip\Drives;


use Draguo\Ip\Contracts\Transform;
use Draguo\Ip\Support\Config;
use Draguo\Ip\Support\HttpRequest;

class Taobao implements Transform
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

        $request = $this->getRequest(self::ENDPOINT, $query);
        return json_decode($request,true);
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
        $keys = array_keys($outArr);
        $request['data']['adcode'] = $request['data']['city_id'];
        $request['data']['province'] = $request['data']['region'];
        $needArr = array_intersect_key($request['data'], array_flip((array)$keys));

        return array_merge($outArr, $needArr);
    }
}