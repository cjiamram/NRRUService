<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once "../config/database.php";
	include_once "../objects/tlabel.php";

	$database=new Database();
	$db=$database->getConnection();
	$obj=new tlabel($db);
	$id=isset($_GET["id"])?$_GET["id"]:0;
	$thLabel=isset($_GET["thLabel"])?$_GET["thLabel"]:"";

	$flag=$obj->updateLabel($id,$thLabel);
	echo json_encode(array("message"=>$flag));

?>