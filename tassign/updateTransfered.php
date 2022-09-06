<?php
	header("content-type:application/json;charset=UTF-8");
	include_once "../config/database.php";
	include_once "../objects/tassign.php";

	$database=new Database();
	$db=$database->getConnection();
	$obj=new tassign($db);
	$data = json_decode(file_get_contents("php://input"));

	$issueId=isset($data->issueId)?$data->issueId:0;
	$assignTo=isset($data->assignTo)?$data->assignTo:"";
	$message=isset($data->message)?$data->message:"";


	$flag=$obj->updateTransfered($issueId,$assignTo,$message);
	echo json_encode(array("message"=>$flag));

?>