<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
	include_once "../config/database.php";
	include_once "../objects/tissue.php";
	$database=new Database();
	$db=$database->getConnection();
	$obj=new tissue($db);
	$id=$obj->getLastId();
	echo json_encode(array("id"=>$id));

?>