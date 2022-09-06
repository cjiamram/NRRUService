<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../config/database.php';
include_once '../objects/menu.php';

$database = new Database();
$db = $database->getConnection();
$Menu = new Menu($db);
//if(!isset($_SESSION["UserName"]))
//	die();
$user =isset($_SESSION["UserName"])?$_SESSION["UserName"]:"Admin";
$stmt=$Menu->listMenu($user);

$num=$stmt->rowCount();
if($num>0){
	$MenuArr=array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    	extract($row);
    	$MenuItem=array(
    		"id"=>$id,
            "Topic"=>$Topic,
    		"MenuId"=>$MenuId,
    		"MenuName"=>$MenuName,
    		"Link"=>$Link,
            "PrettyLink"=>$PrettyLink,
            "OrderNo"=>$OrderNo,
            "LevelNo"=>$LevelNo
    	);
    	array_push($MenuArr, $MenuItem);
    }
    echo json_encode($MenuArr);
}
else{
echo json_encode(
        array("message" => "No Menu found.")
    );
}


?>