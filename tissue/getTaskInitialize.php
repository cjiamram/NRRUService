<?php
header("content-type:application/json;charset=UTF-8");
include_once "../config/database.php";
include_once "../objects/tissue.php";
include_once "../objects/manage.php";

$database=new Database();
$db=$database->getConnection();
$obj=new tissue($db);
$status="01";
$stmt=$obj->getRequestByStatus($status);
if($stmt->rowCount()>0){
	$objArr=array();
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		$objItem=array("IssueDetail"=>$issueDetail,
			"Location"=>$Location,
			"IssueType"=>$issueType,
			"IssueDetail"=>$issueDetail,
			"CreateDate"=>Format::getTextDate($createDate),
			"NotifyBy"=>$notifyBy
		 );
		array_push($objArr,$objItem);
	}
	echo json_encode($objArr);
}else{
	echo json_encode(array("message"=>false));
}



?>