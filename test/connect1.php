<?php 
header('Content-Type: text/html; charset=utf-8');

function getRstName()
{
    try {
        $DBH = new PDO('mysql:host=localhost;dbname=test','root','',
            array(PDO::ATTR_PERSISTENT => true));
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    $sql = "SELECT title_cn, title_en, title_local FROM 
        pre_restaurant WHERE columnid = :columnid";
    $stmt = $DBH->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $stmt->execute(array(':columnid' => 100073));
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    echo $stmt->rowCount();
    var_dump($data);
    return $data;
}
$result = getRstName();
