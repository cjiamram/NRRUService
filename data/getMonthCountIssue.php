<?php
header("content-type:application/json;charset=utf-8");
include_once "../config/database.php";
include_once "../objects/data.php";
$database=new Database();
$db=$database->getConnection();
$obj=new Data($db);
//$sdate=date_create(date("Y-m-d"));
//date_add($sdate,date_interval_create_from_date_string("-30 days"));$fDate=isset($_GET["fDate"]):$_GET["fDate"]:date('Y-m-d');
$date=date("Y-m-d");
$sDate=isset($_GET["sDate"])?$_GET["sDate"]:date('Y-m-d', strtotime($date. ' - 30 days'));
$fDate=isset($_GET["fDate"])?$_GET["fDate"]:$date;

$stmt=$obj->getMonthCountIssue($sDate,$fDate);
if($stmt->rowCount()>0){
	$objArr=array();
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		$objItem=array("yrmn"=>$yrmn,
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