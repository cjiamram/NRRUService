<?php
	header("content-type:application/json;charset=UTF-8");
	include_once "../config/database.php";
	include_once "../objects/tassign.php";

	$database=new Database();
	$db=$database->getConnection();
	$obj=new tassign($db);
	$issueId=isset($_GET["issueId"])?$_GET["issueId"]:0;
	$id=$obj->getId($issueId);

	echo json_encode(array("id"=>$id));

?>