<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/tmenu.php";
$database = new Database();
$db = $database->getConnection();
$obj = new tmenu($db);
$data = json_decode(file_get_contents("php://input"));
$obj->MenuId = $data->MenuId;
$obj->MenuName = $data->MenuName;
$obj->Link = $data->Link;
$obj->Parent = $data->Parent;
$obj->OrderNo = $data->OrderNo;
$obj->LevelNo = $data->LevelNo;
$obj->Topic = $data->Topic;
$obj->enableDefault = $data->enableDefault;
$obj->id = $data->id;
if($obj->update()){
		echo json_encode(array('message'=>true));
}
else{
		echo json_encode(array('message'=>false));
}
?>