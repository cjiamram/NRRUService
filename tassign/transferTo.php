<?php
	header("content-type:application/json;charset=UTF-8");
	include_once "../config/database.php";
	include_once "../objects/tassign.php";
	
	$database=new Database();
	$db=$database->getConnection();
	$obj=new tassign($db);

	$data = json_decode(file_get_contents("php://input"));

	$issueId=isset($data->issueId)?$data->issueId:0;
	$transferFrom=isset($data->transferFrom)?$data->transferFrom:"";
	$transferTo=isset($data->transferTo)?$data->transferTo:"";

	$flag=$obj->transferTo($issueId,$transferFrom,$transferTo);
	echo json_encode(array("message"=>$flag));


?>