<?php
include 'conf/mysql.php';
include 'models/GetRestaurantName.php';
include 'models/SearchURL.php';

//得到店铺名
$stmt = new GetRestaurantName($DBH);
$rstName = $stmt->getRstName();
var_dump($rstName);exit;
//开始搜索URL
foreach ($rstName as $value) {
    if (is_array($value)) {
        foreach ($value as $row) {
            if ($row != '') {
                $searchURL = new SearchURL($row);
                $url = $searchURL->getURL();
                if (count($url) >= 1 && $url != null) {
                    $resultURL = $url[0];
                    $name = $row;
                    $stmt->insertData($resultURL, $name);
                    break;
                } else {
                    echo "没有搜索到数据";
                    continue;
                }
            }
        }
    }
}
// $rstName = $stmt->getRstName();
// $rstRows = $stmt->getRows(100073);
// $urlCount = count($result);

// include 'views/showRstName.php';