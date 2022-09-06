<?php
header("content-type:application/json;charset=UTF8");
include_once "../config/database.php";
include_once "../objects/tissue.php";

$database=new Database();
$db=$database->getConnection();
$obj=new tissue($db);
$id=isset($_GET["id"])?$_GET["id"]:0;
$status=isset($_GET["status"])?$_GET["status"]:"02";
$flag=$obj->updateStatus($id,$status);

echo json_encode(array("message"=>$flag));

?>