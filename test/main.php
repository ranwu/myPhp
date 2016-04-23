<?php 
header('Content-Type: text/html; charset=utf-8');

//从pre_restaurant数据库表中得到店铺名称
function getRstName()
{
	$rstData = array();
	try {
		$pdo = new PDO('mysql:host=localhost;dbname=test','root','');
		//选择英文标题为空并且中文标题不为空的内容
		$sql = "select title_cn from pre_restaurant where title_en='' and title_cn!=''";
		$stmt = $pdo->query($sql);
		echo $stmt->rowCount();
		if ($stmt->rowCount()) {
			echo '结果：' . '<hr/>';
			foreach ($stmt as $row) {
				$rstData[] = $row['title_cn'];
			}
		}
	} catch (PDOException $e) {
		echo $e->getMessage();
	}
	return $rstData;
}

function searchURL($qstring)
{
	$url = array();
	//将要搜索的字符串编码
	$q = urlencode('site:tabelog.com '.$qstring);

	$curlobj = curl_init();
	curl_setopt($curlobj, CURLOPT_URL, "http://ajax.googleapis.com/ajax/services/search/web?q=$q&v=1.0&start=0&rsz=8");
	curl_setopt($curlobj, CURLOPT_PROXY, '127.0.0.1');
	curl_setopt($curlobj, CURLOPT_PROXYPORT, '1080');
	curl_setopt($curlobj, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
	curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, true);

	// 设置https支持
	date_default_timezone_set('PRC'); //使用cookie必须先设置时区
	curl_setopt($curlobj, CURLOPT_SSL_VERIFYPEER, 0); // 终止从服务端进行验证

	$dataJson = curl_exec($curlobj);
	$data = json_decode($dataJson,true);
	if (count($data['responseData']['results']) >= 1) {
	    echo '关键字 ' . $qstring . ' 的URL：' . '<br/>';
	    echo '-------------------' . '<br/>';
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
	    echo '<hr/>';
	} else {
		echo '关键字'.$qstring.'没有搜索到！<br/>';
	}
	curl_close($curlobj);
	return $url;
}

$rstName = getRstName();
$rstURL = array();
foreach ($rstName as $row) {
	$rstURL[] = searchURL($row);
}
var_dump($rstURL);

