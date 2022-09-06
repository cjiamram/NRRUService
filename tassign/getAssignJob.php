<?php
header("content-type:application/json;charset=UTF-8");
include_once "../config/database.php";
include_once "../objects/tassign.php";


$database=new Database();
$db=$database->getConnection();



?>
