<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../config/database.php';
include_once '../objects/user.php';
include_once '../lib/nusoap.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

$user->UserName = isset($data->userName) ?$data->userName: "";
$user->Password = isset($data->password) ? $data->password : "";
//print_r($user->Password);

$stmt=$user->getUserName();
if($stmt->rowCount()>0){
	 //while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	 	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	 	extract($row);
	 	$_SESSION["UserName"]=$UserName;
        $_SESSION["FullName"]=$FullName;
        $_SESSION["UserCode"]=$UserCode;
        $_SESSION["Picture"]=$Picture;
	 //}
	 	$status=array("flag"=>true,"userName"=>$_SESSION["UserCode"],"picture"=>$Picture); 


	 /*if($Picture===""){
	 	$client = new nusoap_client("http://entrance.nrru.ac.th/nrruwebservice/nrruWebService_userLogin.php?wsdl",true);
			$params = array(
				'userlogin' => $data->userName,
				'password' => $data->password,
		);
		$data = json_decode($client->call("getUserLogin",$params)); 
		if($data[0]["status"]==1){
			$_SESSION["Picture"]=$data[0]["picture"];
		}
	 }*/
	 echo json_encode($status); 
}
else
{
	 $status=array("flag"=>false,"userName"=>$data->userName); 
	 echo json_encode($status); 
}


?>