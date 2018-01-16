# IP
### 通过ip获取中文地理位置

```
composer require draguo/ip
```
```
Ip::getLocation('8.8.8.8')
or
$ip = new Ip();
$ip->getLocation('8.8.8.8')
```

使用
```php
    $config = [
        'driver' => 'amap'
        'key' => 'qweqweqwassdf',
    ];
    
    // return array
    $service = new Ip($config);
    $location = $service->toLocation($ip); 
为了方便使用， toLocation 返回的方法进行了重新包装，但由于各家服务商提供的数据
不一致，所以部分数据会不存在，如果需要原样的数据可以调用，toLocationRaw($ip)
    [
        country
        province
        city
        adcode
        lng // 精度
        lat // 维度
        isp // 服务商
    ]
```


支持计划
- [x] 淘宝 api
- [x] 高德地图
- [ ] 百度地图
- [ ] ipip.net api
- [ ] ipip.net 数据库
- [ ] 纯真数据库
- [ ] ip 问问 api
- [ ] ip 问问 数据库

```php

```
