<?php 
$qstring = 'hello';
echo $qstring;
$q = urlencode('site:tabelog.com '.$qstring);

$curlobj = curl_init();
curl_setopt($curlobj, CURLOPT_URL, "http://ajax.googleapis.com/ajax/services/search/web?q=$q&v=1.0&start=0&rsz=3");
curl_setopt($curlobj, CURLOPT_PROXY, '127.0.0.1');
curl_setopt($curlobj, CURLOPT_PROXYPORT, '1080');
curl_setopt($curlobj, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, true);

// 设置https支持
date_default_timezone_set('PRC'); //使用cookie必须先设置时区
curl_setopt($curlobj, CURLOPT_SSL_VERIFYPEER, 0); // 终止从服务端进行验证

$dataJson = curl_exec($curlobj);
$data = json_decode($dataJson,true);
var_dump($data);
var_dump(count($data['responseData']['results']));
if (count($data['responseData']['results']) >= 1) {
    foreach ($data['responseData']['results'] as $value) {
        if (is_array($value)) {
            foreach ($value as $key => $value) {
                if ($key === 'url') {
                    echo $key . ' => ' . $value . '<br/>';
                }
            }
        }
    }
}
curl_close($curlobj);

