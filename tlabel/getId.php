<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/tlabel.php";
$database = new Database();
$db = $database->getConnection();
$obj = new tlabel($db);
$tableName=isset($_GET["tableName"]) ? $_GET["tableName"] : "";
$fieldName=isset($_GET["fieldName"]) ? $_GET["fieldName"] : "";
//print_r($tableName);
//print_r(trim($fieldName));
$obj->tableName=$tableName;
$obj->fieldName=$fieldName;
$stmt = $obj->getId();
$num = $stmt->rowCount();


if($num>0){
		
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		extract($row);
		$objItem=array(
		"id"=>$id
		);
		echo json_encode($objItem);
}
else{
			echo json_encode(array("id" => ""));
}
?>