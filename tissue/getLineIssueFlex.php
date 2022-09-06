<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/tissue.php";
include_once "../objects/manage.php";
include_once "../config/config.php";
$cnf=new Config();
$rootPath=$cnf->restURL;
$database = new Database();
$db = $database->getConnection();
$obj = new tissue($db);
$data = json_decode(file_get_contents("php://input"));
$obj->id = isset($_GET['id']) ? $_GET['id'] : 0;
$stmt=$obj->readOneNotify();
$num=$stmt->rowCount();
//print_r($num);
if($num>0){
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		extract($row);
		
		$issueMessage=str_replace("uploads/",$rootPath."uploads/",$issueDetail);

		$item = array(
			"id"=>$id,
			"staffId" =>  $staffId,
			"roomNo" =>  $roomNo,
			"floorNo" =>  $floorNo,
			"building" =>  $building,
			"telNo" =>  $telNo,
			"lineNo" =>  $lineNo,
			"createDate" =>  Format::getSystemDate($createDate),
			"issueType" =>  $issueType,
			"issueDetail" =>  $issueMessage,
			"notifyBy" =>  $notifyBy,
			"status" =>  $status
		);
}
echo(json_encode($item));
?>