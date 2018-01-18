# IP
### 通过ip获取中文地理位置

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
driver 名见下面的支持计划
[
    country
    province
    city
    adcode
    lng // 经度
    lat // 维度
    isp // 服务商
]
```


支持计划
- [x] 淘宝 **taobao** api
- [x] 高德地图 **amap**
- [x] 百度地图 **baidu**
- [ ] ipip.net api
- [ ] ipip.net 数据库
- [ ] 纯真数据库
- [ ] ip 问问 api
- [ ] ip 问问 数据库

```php

```
