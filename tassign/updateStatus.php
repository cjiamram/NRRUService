<?php
	header("content-type:application/json;charset=UTF-8");
	include_once "../config/database.php";
	include_once "../objects/tassignstaff.php";

	$database=new Database();
	$db=$database->getConnection();
	$obj=new tassignstaff($db);

	$userCode=isset($_GET["userCode"])?$_GET["userCode"]:"";
	$issueId=isset($_GET["issueId"])?$_GET["issueId"]:0;
	$status=isset($_GET["status"])?$_GET["status"]:"";


	$flag=$obj->updateStatus($userCode,$issueId,$status);

	echo json_encode(array("flag"=>$flag));


?>