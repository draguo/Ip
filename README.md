<h1 align="center">通过ip获取中文地理位置</h1>
<p align="center">
<a href="https://travis-ci.org/draguo/Ip"><img src="https://travis-ci.org/draguo/Ip.svg?branch=master" alt="Build Status"></a>
</p>

## 说明
依赖于各家提供的 api

## 使用
```php
$config = [
    'driver' => 'amap'
    'key' => 'qweqweqwassdf',
];
    
// return array
$service = new Ip($config);
$location = $service->toLocation($ip); 
[
    country
    province
    city
    adcode // 城市的编号
    lng // 经度
    lat // 维度
    isp // 服务商
]
```
为了方便使用， toLocation 返回的方法进行了重新包装，但由于各家服务商提供的数据
不一致，所以部分数据会不存在，如果需要原样的数据可以调用，toLocationRaw($ip)  
driver 名见下面的支持计划中黑体字部分


已经支持计划(免费使用的)
淘宝 **taobao**
高德地图 **amap**
百度地图 **baidu**

未来支持(没有提供免费试用 api)
- [ ] ipip.net api
- [ ] ipip.net 数据库
- [ ] 纯真数据库
- [ ] ip 问问 api
- [ ] ip 问问 数据库
