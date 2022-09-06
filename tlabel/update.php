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
$data = json_decode(file_get_contents("php://input"));
$obj->tableName = $data->tableName;
$obj->fieldName = $data->fieldName;
$obj->thLabel = $data->thLabel;
$obj->enLabel = $data->enLabel;
$obj->flag = $data->flag;
$obj->id = $data->id;
if($obj->update()){
		echo json_encode(array('message'=>true));
}
else{
		echo json_encode(array('message'=>false));
}
?>