<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="referer" content="never" />
    <meta name="renderer" content="webkit">
    <title>phpMyAdmin</title>
</head>    
<body>
    <h1>一天就扫扫扫!扫nmlgb!</h1>

<?php
require 'RedisPool.php';
$conf = array(
    'RA' => array(
        '127.0.0.1',
        6379
    )
);
RedisPool::addServer($conf); //添加Redis配置
$redis = RedisPool::getRedis('RA'); //连接RA，使用默认0库
//连接本地的 Redis 服务
$ip = getIp();
if ($ip != "本机ip") {
    //$redis->lpush("ip-list", getIp());
    $redis->set($ip, "1");
} else {
    if ($_GET["flushall"] == 'ok') {
        $redis->flushall();
        echo '清空成功!';
    }
}
// 获取数据并输出
//$arList = $redis->lrange('ip-list',0,-1);
$arList = $redis->keys("*");
foreach ($arList as $value) {
    echo "IP: $value <br>";
}
//echo "Stored keys in redis:: ";
//print_r($arList);
function getIp() {
    if ($_SERVER["HTTP_CLIENT_IP"] && strcasecmp($_SERVER["HTTP_CLIENT_IP"], "unknown")) {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    } else {
        if ($_SERVER["HTTP_X_FORWARDED_FOR"] && strcasecmp($_SERVER["HTTP_X_FORWARDED_FOR"], "unknown")) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else {
            if ($_SERVER["REMOTE_ADDR"] && strcasecmp($_SERVER["REMOTE_ADDR"], "unknown")) {
                $ip = $_SERVER["REMOTE_ADDR"];
            } else {
                if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) {
                    $ip = $_SERVER['REMOTE_ADDR'];
                } else {
                    $ip = "unknown";
                }
            }
        }
    }
    return ($ip);
}
?>
</body>
</html>
