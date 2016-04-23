<?php 
function searchURL($qstring)
{
	$url = array();
	//将要搜索的字符串编码
	$q = urlencode('site:tabelog.com '.$qstring);

	$curlobj = curl_init();
	curl_setopt($curlobj, CURLOPT_URL, "http://ajax.googleapis.com/ajax/services/search/web?q=$q&v=1.0&start=0&rsz=3");
	curl_setopt($curlobj, CURLOPT_PROXY, '127.0.0.1');
	curl_setopt($curlobj, CURLOPT_PROXYPORT, '1080');
	curl_setopt($curlobj, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
	curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curlobj, CURLOPT_TIMEOUT, 1);

	// 设置https支持
	date_default_timezone_set('PRC'); //使用cookie必须先设置时区
	curl_setopt($curlobj, CURLOPT_SSL_VERIFYPEER, 0); // 终止从服务端进行验证

	$dataJson = curl_exec($curlobj);
	$data = json_decode($dataJson,true);
	if (count($data['responseData']['results']) >= 1) {
	    echo '关键字' . $qstring . '的URL：' . '<br/>';
	    echo '=======================================================START' . '<br/>';
	    foreach ($data['responseData']['results'] as $value) {
	        if (is_array($value)) {
	            foreach ($value as $key => $value) {
	                if ($key === 'url') {
	                    echo $key . ' => ' . $value . '<br/>'; 
	                    $url[] = $value;
	                }
	            }
	        }
	    }
	} else {
		searchURL($qstring);
		echo "$qstring 重复查找 1 次<br/>";
	}
	curl_close($curlobj);
	return $url;
}
// searchURL('hello');
// searchURL('world');
// searchURL('tokyo');
// searchURL('大黑家');
searchURL('Buchi布琪餐厅');

 ?>