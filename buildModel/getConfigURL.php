<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/Config.php';
$cnf=new Config();
echo json_encode(array("restURL"=>$cnf->restURL));
?>