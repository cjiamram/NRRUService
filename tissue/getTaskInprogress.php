<?php
header("content-type:application/json;charset=UTF-8");
include_once "../config/database.php";
include_once "../objects/tissue.php";
include_once "../objects/tassign.php";

$database=new Database();
$db=$database->getConnection();
$obj=new tissue($db);
$obj_1=new tassign($db);

$stmt=$obj->getRequestByStatus("03");
if($stmt->rowCount()>0){
	$objArr=array();
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		$response=$obj_1->readOneResponse($id);
		$objItem=array("IssueDetail"=>$issueDetail,
			"Location"=>$Location,
			"IssueType"=>$issueType,
			"CreateDate"=>$createDate,
			"NotifyBy"=>$notifyBy,
			"Response"=>$response
		 );
		array_push($objArr,$objItem);
	}
	echo json_encode($objArr);
}else{
	echo json_encode(array("message"=>false));
}



?>