<?php
	header("content-type:application/json;charset=UTF-8");
	include_once "../config/database.php";
	include_once "../objects/tissue.php";
	$database=new Database();
	$db=$database->getConnection();
	$obj=new tissue($db);
	$evaluateLevel=isset($_GET["evaluateLevel"])?$_GET["evaluateLevel"]:0;
	$evaluateMessage=isset($_GET["evaluateMessage"])?$_GET["evaluateMessage"]:"";
	$id=isset($_GET["id"])?$_GET["id"]:0;
	$flag=$obj->updateEvaluate($id,$evaluateLevel,$evaluateMessage);
	echo json_encode(array("flag"=>$flag));



?>