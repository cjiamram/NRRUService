<?php
header("content-type:application/json;charset=UTF-8");
include_once "../config/database.php";
include_once "../objects/tissue.php";

$database=new Database();
$db=$database->getConnection();
$obj=new tissue($db);
$stmt=$obj->getEvaluation();
//print_r($stmt);
if($stmt->rowCount()>0){
	$objArr=array();
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			$objItem=array("avgEva"=>floatval($avgEva),"IssueType"=>$issueType);
			array_push($objArr,$objItem);

	}
	echo json_encode($objArr);
}else
echo json_encode(array("message"=>false));

?>