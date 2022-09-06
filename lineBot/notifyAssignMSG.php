<?php
	session_start();
	header("content-type:application/json;charset=utf-8");

	include_once "../config/database.php";
	include_once "../objects/tstaff.php";
	include_once "../config/config.php";
	include_once "../lib/classAPI.php";
	$database=new Database();
	$db=$database->getConnection();
	$cnf=new Config();
	$obj=new tstaff($db);
	$api=new ClassAPI();
	$assignTo=isset($_GET["assignTo"])?$_GET["assignTo"]:"";
	$id=isset($_GET["id"])?$_GET["id"]:0;
	$url=$cnf->restURL."tissue/readOneNotify.php?id=".$id;
	$rootPath=$cnf->restURL;
	$token=$obj->getToken($assignTo);
	$staffName=$obj->getStaffName($assignTo);
	$data=$api->getAPI($url);

	$sText="";
	if($data!=""){

		$sText="ผู้แจ้ง :".$data["notifyBy"]."\n";
		$sText.="โทรศัพท์ :".$data["telNo"]."\n";
		$sText.="รายละเอียด :".$data["issueDetail"]."\n";
		$sText.="ประเภทงาน :".$data["issueType"]."\n";
		$sText.="วันที่แจ้ง :".$data["createDate"]."\n";
		//$sText.="มอบหมายโดย :".$_SESSION["FullName"]."\n";
		$sText.="มอบหมายให้ :".$staffName."\n";
	}

	$message=$sText;
	//print_r($message);


	


	sendlinemesg($token,$id);
	header('Content-Type: text/html; charset=utf-8');
	$res = notify_message($message,$id,$rootPath,$token);
	echo "<center>ส่งข้อความเรียบร้อยแล้ว</center>";


function sendlinemesg($token,$id) {
	
    define('LINE_API',"https://notify-api.line.me/api/notify");
	define('LINE_TOKEN',$token);

	function notify_message($message,$id,$rootPath,$token){
		$picture=$rootPath."/SCREEN/P-".$id.".png";
		$imageFile = new CURLFILE($picture); // Local Image file Path
		$sticker_package_id = '2';  // Package ID sticker
		$sticker_id = '34';    // ID sticker

		$data = array(
			'message' => $message,
			'imageFile' => $imageFile,
			'stickerPackageId' => $sticker_package_id,
    		'stickerId' => $sticker_id
		);

		

		$chOne = curl_init();
		curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
		curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt( $chOne, CURLOPT_POST, 1);
		curl_setopt( $chOne, CURLOPT_POSTFIELDS, $data);
		curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
		$headers = array( 'Method: POST', 'Content-type: multipart/form-data', 'Authorization: Bearer '.$token, );
		curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
		curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec( $chOne );
		if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); }
		else { $result_ = json_decode($result, true);
		echo "status : ".$result_['status']; echo "message : ". $result_['message']; 
		}
		//Close connection
		curl_close( $chOne );
	
	}

}

?>