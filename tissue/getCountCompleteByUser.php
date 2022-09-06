<?php
	session_start();
	header("content-type:application/json;charset=UTF-8");
	include_once "../config/database.php";
	include_once "../objects/tissue.php";
	$database=new Database();
	$db=$database->getConnection();
	$obj=new tissue($db);
	$userCode=isset($_SESSION["UserName"])?$_SESSION["UserName"]:"chatchai.j";
	$flag=$obj->getCountCompleteByUser($userCode);
	echo json_encode(array("flag"=>$flag));
?>