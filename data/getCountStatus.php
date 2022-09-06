<?php
header("content-type:application/json;charset=utf-8");
include_once "../config/database.php";
include_once "../objects/data.php";
$database=new Database();
$db=$database->getConnection();
$obj=new Data($db);
$yrmn=isset($_GET["yrmn"])?$_GET["yrmn"]:"";
$stmt=$obj->getCountStatus($yrmn);
if($stmt->rowCount()>0){
	$objArr=array();
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		$objItem=array("status"=>$STATUS,
			"No"=>$CNT
			);
		array_push($objArr,$objItem);

	}
	echo json_encode($objArr);
}else
{
	echo json_encode(array("message"=>$false));
}
?>