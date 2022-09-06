<?php
	header ("Content-Type: application/json; charset=utf-8");

	session_start();	
	require_once("../lib/nusoap.php");
	include_once "../lib/classAPI.php";

	$data = json_decode(file_get_contents("php://input"));
	$userCode=$data->userName;
	
	$postObj = array(
		'userName' => $data->userName,
		'password' => $data->password
	);
	
	$jsonObj=json_encode($postObj);
	$api=new ClassAPI();
	$url="http://nrruapp.nrru.ac.th/Credential/NRRUCredential.php";
	$user=$api->postAPI($url,$jsonObj); 

	//print_r($user);

	if($user[0]["status"]==1){

			foreach ($user as $row) {
					$_SESSION["UserCode"]=$userCode;
					$_SESSION["staffid"]=$row["staffid"];
					$_SESSION["UserName"]=$row["username"];
					$_SESSION["FullName"]=$row["firstname"].' '.$row["lastname"]  ;
					$_SESSION["Picture"]=$row["picture"];
					$_SESSION["DepartmentId"]=$row["departmentcode1"];
					echo json_encode(array("UserCode"=>$row["username"],"message"=>true)) ;

				}
	}else
	echo json_encode(array("message"=>false));


	
?>