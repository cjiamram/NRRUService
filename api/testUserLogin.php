<?php	
	require_once("../lib/nusoap.php");
	header ("Content-Type: text/html; charset=utf-8");

	$data = json_decode(file_get_contents("php://input"));


	$client = new nusoap_client("http://entrance.nrru.ac.th/nrruwebservice/nrruWebService_userLogin.php?wsdl",true);
	$params = array(
		'userlogin' => $data->userName,
		'password' => $data->passWord
	);
	$data = $client->call("getUserLogin",$params); 
	$student = json_decode($data,true);
	print_r($student[0]);

	//echo 'student : ' . $student . '<br><br>';
	if($data!=""){
	foreach ($student as $result) {
			//echo $result["staffid"] ;
			/*echo 'usertype : ' . $result["usertype"] . '<br>'; 
			echo 'code : ' . $result["code"] . '<br>';
			echo 'username : ' . $result["username"] . '<br>';
			echo 'firstname : ' . $result["firstname"] . '<br>';
			echo 'lastname : ' . $result["lastname"] . '<br>';
			echo 'faculty : ' . $result["faculty"] . '<br>';
			echo 'major : ' . $result["major"] . '<br>';
			echo 'datetime : ' . $result["datetime"] . '<br>';*/
		}
	}

?>