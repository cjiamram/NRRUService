<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/menu.php";
$database = new Database();
$db = $database->getConnection();
$obj = new Menu($db);
$userCode=isset($_GET["UserCode"])?$_GET["UserCode"]:"";


if($obj->setPrivillageDefault($userCode)){
		echo json_encode(array('message'=>true));
}
else{
		echo json_encode(array('message'=>false));
}

?>