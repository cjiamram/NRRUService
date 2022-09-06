<?php
	header("Content-Type:application/json;charseet=UTF-8");
	include_once "../config/database.php";
	include_once "../objects/tissue.php";

	$database=new Database();
	$db=$database->getConnection();
	$obj=new tissue($db);

	echo json_encode(array("CNT"=>$obj->getNewWorkAll()));

?>