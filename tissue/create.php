<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/tissue.php";
include_once "../objects/manage.php";
$database = new Database();
$db = $database->getConnection();
$obj = new tissue($db);
$data = json_decode(file_get_contents("php://input"));


$staffId=isset($_SESSION["UserCode"])?$_SESSION["UserCode"]:"";

$obj->staffId =  $staffId;
$obj->roomNo = $data->roomNo;
$obj->floorNo = $data->floorNo;
$obj->building = $data->building;
$obj->telNo = $data->telNo;
$obj->lineNo = $data->lineNo;
$obj->createDate = Format::getSystemDate($data->createDate);
$obj->issueType = $data->issueType;
$obj->issueDetail = $data->issueDetail;
$obj->notifyBy = $data->notifyBy;
$obj->status = "01";
if($obj->create()){
		echo json_encode(array('message'=>true));
}
else{
		echo json_encode(array('message'=>false));
}
?>