<?php 
$proxy = "127.0.0.1";
$proxyport = "1080";
$ch = curl_init("https://www.google.com");



curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_PROXY,$proxy);
curl_setopt($ch,CURLOPT_PROXYPORT,$proxyport);
curl_setopt ($ch, CURLOPT_TIMEOUT, 120);



$result = curl_exec($ch);
echo $result;

curl_close($ch); 



 ?>