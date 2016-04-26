<?php
/**
* 日期：2016.04.25
*/
class GetRestaurantName
{
    protected $db;

    function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getRstName()
    {
        $sql = "SELECT title_cn, title_en, title_local FROM
            pre_restaurant WHERE columnid = :columnid";
        try {
            $stmt = $this->db->prepare($sql,
                array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt->execute(array(':columnid' => 100073));
            $data = $stmt->fetchAll(PDO::FETCH_NUM);
            // while ($rows = $stmt->fetch(PDO::FETCH_NUM,
            //     PDO::FETCH_ORI_NEXT)) {
            //     $data[] = $rows;
            // };
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return $data;
    }

    public function getRows($id)
    {
        $sql = "SELECT title_cn, title_en, title_local FROM
            pre_restaurant WHERE columnid = :columnid";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':columnid', $id, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->rowCount();
        if ($rows >= 1) {
            return $rows;
        } else {
            return "没有查询到相关记录";
        }
    }

    public function insertData($url, $name)
    {
        $sql = "INSERT INTO test_table (url, name)
                VALUES (:url, :name)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':url', $url, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        if($status = $stmt->execute()) {
            echo '插入数据成功' . '<br/>';
            echo '受影响的行数为：' . $status;
        } else {
            print_r($e->getMessage());
        }
    }
}
