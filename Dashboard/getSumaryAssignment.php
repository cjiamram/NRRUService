<?php
header("content-type:application/json;charset=UTF-8");
include_once "../config/database.php";
include_once "../objects/tissue.php";

$database=new Database();
$db=$database->getConnection();
$obj=new tissue($db);
$stmt=$obj->getSumaryAssignment();

if($stmt->rowCount()>0){
	$objArr=array();
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		$objItem=array(
				"WorkGroup"=>$workGroup,
				"CNT"=>$CNT,
				"Color"=>$obj->randColor()
			);

		array_push($objArr,$objItem);
	}
	echo json_encode($objArr);
}



?>