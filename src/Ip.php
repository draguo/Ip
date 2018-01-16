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
    protected $driver = 'taobao';

    public function __construct(array $config = [])
    {
        $this->config = new Config($config);
        if ( ! empty($config['driver'])) {
            $this->setDefaultDriver($config['driver']);
        }
    }

    public function toLocation($ip)
    {
        try {
            return $this->makeDriver($this->config)
                        ->toLocation($ip, $this->config);
        } catch (\Exception $exception) {
            return [
                'status'  => '0',
                'message' => $exception->getMessage()
            ];
        }
    }

    public function toLocationRaw($ip)
    {
        return $this->makeDriver($this->config)
                    ->toLocationRaw($ip, $this->config);
    }

    /**
     * @param $name
     *
     * @return $this
     */
    public function setDefaultDriver($name)
    {
        $this->driver = $name;

        return $this;
    }

    public function makeDriver($config)
    {
        $driverClass = $this->getClassName();

        return new $driverClass($config);
    }

    protected function getClassName()
    {
        $name = $this->driver;

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
