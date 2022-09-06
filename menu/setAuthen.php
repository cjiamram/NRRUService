<?php
	header("content-type:application/json;charset=UTF-8");	
	include_once "../objects/menu.php";
	include_once "../config/database.php";
	$database=new Database();
	$db=$database->getConnection();

	$obj=new menu($db);
	$userId=isset($_GET["userName"])?$_GET["userName"]:"";
	$menuId=isset($_GET["menuId"])?$_GET["menuId"]:"";
	$isCheck=isset($_GET["isCheck"])?$_GET["isCheck"]:0;
	$flag=$obj->setAuthen($userId,$menuId,$isCheck);

	echo json_encode(array("message"=>$flag));
?>