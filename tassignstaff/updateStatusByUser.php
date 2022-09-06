<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/tassignstaff.php";
$database = new Database();
$db = $database->getConnection();
$obj = new tassignstaff($db);
$userCode=isset($_GET["userCode"])?$_GET["userCode"]:"";
$issueId=isset($_GET["issueId"])?$_GET["issueId"]:0;
$progressStatus=isset($_GET["progressStatus"])?$_GET["progressStatus"]:"";
$flag=$obj->updateStatusByUser($issueId,$userCode,$progressStatus);
echo json_encode(array("message"=>$flag));

//$data = json_decode(file_get_contents("php://input"));

?>