<?php
include_once "../config/database.php";
include_once "../objects/tissue.php";

$database=new Database();
$db=$database->getConnection(); 
$obj=new tissue($db);
$issueId=isset($_GET["issueId"])?$_GET["issueId"]:0;
$flag=$obj->updateStatusByAssign($issueId);

echo json_encode(array("message"=>$flag));

?>