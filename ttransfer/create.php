<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/ttransfer.php";
$database = new Database();
$db = $database->getConnection();
$obj = new ttransfer($db);
$data = json_decode(file_get_contents("php://input"));
$obj->transferFrom = $data->transferFrom;
$obj->issueId = $data->issueId;
$obj->transferDate = $data->transferDate;
$obj->transferTo = $data->transferTo;
$obj->status = $data->status;
if($obj->create()){
		echo json_encode(array('message'=>true));
}
else{
		echo json_encode(array('message'=>false));
}
?>