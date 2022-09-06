<?php
	session_start();
	require_once("../lib/nusoap.php");
	header ("Content-Type: text/html; charset=utf-8");

	$client = new nusoap_client("http://entrance.nrru.ac.th/nrruwebservice/nrruWebService_userLogin.php?wsdl",true);
	$params = array(
		'userlogin' => $_POST['username'],
		'password' => $_POST['password']
	);
	$data = $client->call("getUserLogin",$params); 
	$userData = json_decode($data,true);

	if($userData[0]["code"]!=""){
	foreach ($userData as $row) {
			echo json_encode(array("UserCode"=>$row["username"],"message"=>true)) ;
			$_SESSION["UserCode"]=$row["username"];
			$_SESSION["FullName"]=$row["firstname"].' '.$row["lastname"]  ;
			$_SESSION["UserCode"]=$row["staffid"];
			$_SESSION["Picture"]=$row["picture"];
		}
	}else
	echo json_encode(array("message"=>false));
	
?>