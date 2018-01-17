<?php

namespace Draguo\Ip\Drives;

use Draguo\Ip\Contracts\Transform;

abstract class Driver implements Transform
{
    protected $transformResult = [];

    protected function getResultFormat()
    {
        return [
            'country'  => '',
            'province' => '',
            'city'     => '',
            'adcode'   => '',
            'lng'      => '',
            'lat'      => '',
            'isp'      => ''
        ];
    }

    // 功能等同于 php7 中的 ?? 如果存在就返回对应值，如果不存在就返回 ''
    protected function handleUndefinedIndex($keys)
    {
        $array = $this->transformResult;

        if (is_null($keys)) {
            return '';
        }
        if ($array === []) {
            return '';
        }
        $keys = (array) $keys;
        $subKeyArray = '';
        foreach ($keys as $key) {
            $subKeyArray = $array;
            if (array_key_exists($key, $array)) {
                return $array[$key];
            }
            foreach (explode('.', $key) as $subKey) {
                if (array_key_exists($subKey, $subKeyArray)){
                    $subKeyArray = $subKeyArray[$subKey];
                } else {
                    return '';
                }
            }
        }
        return $subKeyArray;
    }
}