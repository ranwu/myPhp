<?php 
header('Content-Type: text/html; charset=utf-8');

function getRstName()
{
	$rstData = array();
	try {
		$pdo = new PDO('mysql:host=localhost;dbname=test','root','');
		$sql = "SELECT title_cn, title_en, title_local from 
			pre_restaurant columnid = 100073";
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
print_r(getRstName());
