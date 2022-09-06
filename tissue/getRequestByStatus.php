<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/tissue.php";
include_once "../objects/manage.php";
include_once "../api/staff.php";
$database = new Database();
$db = $database->getConnection();
$obj = new tissue($db);
$objStaff=new Staff();
$status=isset($_GET["status"]) ? $_GET["status"] : "01";
$stmt = $obj->getRequestByStatus($status);
$num = $stmt->rowCount();
if($num>0){
		$objArr=array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$objItem=array(
					"id"=>$id,
					"location"=>$Location,
					"contact"=>"Tel:".$telNo." Line:".$lineNo,
					"issueType"=>$issueType,
					"issueDetail"=>$issueDetail,
					"notifyBy"=>$notifyBy,
					"status"=>$status,
					"createDate"=>Format::getTextDate($createDate)
				);
				array_push($objArr, $objItem);
			}
			echo json_encode($objArr);
}
else{
			echo json_encode(array("message" => false));
}
?>