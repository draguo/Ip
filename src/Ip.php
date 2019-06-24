<?php

namespace Draguo\Ip;

use Draguo\Ip\Support\Config;

class Ip
{
    /**
     * @var Config
     */
    protected $config;
    /**
     * @var
     */
    protected $gateways = ['taobao'];

    public function __construct(array $config = [])
    {
        $this->config = new Config($config);

        if (!empty($config)) {
            $this->gateways = $config;
        }
    }

    public function toLocation($ip)
    {

        $results = [];
        $isSuccessful = false;

        foreach ($this->gateways as $gateway => $config) {
            try {
                $results = $this->makeDriver($gateway, $config)->toLocation($ip);
                $isSuccessful = true;

                break;
            } catch (\Exception $e) {
                $results[$gateway] = [
                    'gateway' => $gateway,
                    'exception' => $e,
                ];
            }
        }

        if (!$isSuccessful) {
            throw new \Exception($results);
        }

        return $results;
    }

    public function toLocationRaw($ip)
    {
        return $this->makeDriver($this->config)
            ->toLocationRaw($ip, $this->config);
    }

    private function makeDriver($gateway, $config)
    {
        $driverClass = $this->getClassName($gateway);

        if (!class_exists($driverClass)) {
            throw new \Exception('driver does not exist');
        }

        return new $driverClass($config);
    }

    protected function getClassName($name)
    {
        if (class_exists($name)) {
            return $name;
        }

        $name = ucfirst(str_replace(['-', '_', ''], '', $name));

        return __NAMESPACE__ . "\\Drives\\{$name}";
    }

    public static function __callStatic($name, $arguments)
    {
        $ip = new static();

        return $ip->$name($arguments);
    }
}
