<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/tstaff.php";
$database = new Database();
$db = $database->getConnection();
$obj = new tstaff($db);
$data = json_decode(file_get_contents("php://input"));
$obj->personnelid = $data->personnelid;
$obj->staffid = $data->staffid;
$obj->prefixname = $data->prefixname;
$obj->staffname = $data->staffname;
$obj->staffsurname = $data->staffsurname;
$obj->prefixnameeng = $data->prefixnameeng;
$obj->staffnameeng = $data->staffnameeng;
$obj->staffsurnameeng = $data->staffsurnameeng;
$obj->workgroupid = $data->workgroupid;
$obj->departmentid = $data->departmentid;
$obj->username = $data->username;
if($obj->create()){
		echo json_encode(array('message'=>true));
}
else{
		echo json_encode(array('message'=>false));
}
?>