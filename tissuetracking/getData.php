<?php
include_once "../objects/manage.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/tissuetracking.php";
$database = new Database();
$db = $database->getConnection();
$obj = new tissuetracking($db);
$issueId=isset($_GET["issueId"]) ? $_GET["issueId"] : "";
$stmt = $obj->getData($issueId);
$num = $stmt->rowCount();
if($num>0){
		$objArr=array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$objItem=array(
					"id"=>$id,
					"issueId"=>$issueId,
					"staffCode"=>$staffCode,
					"detail"=>$detail,
					"status"=>$status,
					"operatingDate"=>Format::getSystemDate($operatingDate),
					"progress"=>$progress."%",
				);
				array_push($objArr, $objItem);
			}
			echo json_encode($objArr);
}
else{
			echo json_encode(array("message" => false));
}
?>