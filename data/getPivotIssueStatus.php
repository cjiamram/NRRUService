<?php
header("content-type:application/json;charset=utf-8");
include_once "../config/database.php";
include_once "../objects/data.php";
$database=new Database();
$db=$database->getConnection();
$obj=new Data($db);
$sDate=isset($_GET["sDate"])?$_GET["sDate"]:date('Y-m-d');
$fDate=isset($_GET["fDate"])?$_GET["fDate"]:date('Y-m-d');
$stmt=$obj->getPivotIssueStatus($sDate,$fDate);
if($stmt->rowCount()>0){
	$objArr=array();
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		$objItem=array("ปี/เดือน"=>$yrmn,
			"ประเภทการร้องขอ"=>$issueType,
			"สถานะงาน"=>$status,
			"จำนวน"=>$CNT
			);
		array_push($objArr,$objItem);

	}
	echo json_encode($objArr);
}else
{
	echo json_encode(array("message"=>$false));
}
?>