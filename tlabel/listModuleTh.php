<?php
header("content-type:application/json;charset=UTF-8");
include_once "../objects/tlabel.php";
include_once "../config/database.php";

$database=new Database();
$db=$database->getConnection();
$obj=new tlabel($db);

$stmt=$obj-> listModuleTh();
if($stmt->rowCount()>0){
	$objArr=array();
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		$objItem=array("id"=>$tableName,
			"code"=>$tableName,
			"moduleTh"=>$moduleTh
			);

		array_push($objArr,$objItem);
	}
	echo json_encode($objArr);
}else{
	echo json_encode(array("message"=>false));
}

?>