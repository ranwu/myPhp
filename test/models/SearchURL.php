<?php
/**
* 日期：2016.04.25
*/
class SearchURL 
{
    protected $qstring;

    function __construct($qstring)
    {
        $this->qstring = $qstring;
    }

    function getURL()
    {
        $url = array();
        $q = urlencode('site:tabelog.com '.$this->qstring);

        $curlobj = curl_init();
        curl_setopt($curlobj, CURLOPT_URL,
            "http://ajax.googleapis.com/ajax/services/search/web?q=$q&v=1.0&start=0&rsz=3");
        curl_setopt($curlobj, CURLOPT_PROXY, '127.0.0.1');
        curl_setopt($curlobj, CURLOPT_PROXYPORT, '1080');
        curl_setopt($curlobj, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlobj, CURLOPT_TIMEOUT, 1);

        // 设置https支持
        date_default_timezone_set('PRC'); 
        curl_setopt($curlobj, CURLOPT_SSL_VERIFYPEER, 0); 

        $dataJson = curl_exec($curlobj);
        $data = json_decode($dataJson,true);
        if (count($data['responseData']['results']) >= 1) {
            foreach ($data['responseData']['results'] as $value) {
                if (is_array($value)) {
                    foreach ($value as $key => $value) {
                        if ($key === 'url') {
                            $url[] = $value;
                        }
                    }
                }
            }
        } else {
            return "没找到<br/>";
        }
        curl_close($curlobj);
        return $url;
    }
}
