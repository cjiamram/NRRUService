<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/tevaluate.php";
$database = new Database();
$db = $database->getConnection();
$obj = new tevaluate($db);
$data = json_decode(file_get_contents("php://input"));
$obj->issueId = $data->issueId;
$obj->evaluateBy = $data->evaluateBy;
$obj->message = $data->message;
$obj->score = $data->score;
$obj->id = $data->id;
if($obj->update()){
		echo json_encode(array('message'=>true));
}
else{
		echo json_encode(array('message'=>false));
}
?>