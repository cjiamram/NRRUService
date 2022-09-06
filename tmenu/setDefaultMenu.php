<?php
	header("content-type:application/json;charset=UTF-8");
	include_once "../config/database.php";
	include_once "../objects/tmenu.php";

	$database=new Database();
	$db=$database->getConnection();
	$obj=new tmenu($db);
	$userCode=isset($_GET["userCode"])?$_GET["userCode"]:"";
	$flag=$obj->setDefaultMenu($userCode);
	echo json_encode(array("message"=>$flag));

?>