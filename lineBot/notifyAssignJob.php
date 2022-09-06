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
		$sText.="มอบหมายโดย :".$_SESSION["FullName"]."\n";
		$sText.="มอบหมายโดย :".$staffName."\n";
	}

	$message=$sText;
	sendlinemesg($token);
	header('Content-Type: text/html; charset=utf-8');
	$res = notify_message($message);
	echo "<center>ส่งข้อความเรียบร้อยแล้ว</center>";


function sendlinemesg($token) {	
    define('LINE_API',"https://notify-api.line.me/api/notify");
	define('LINE_TOKEN',$token);

	function notify_message($message){

		$queryData = array('message' => $message,'stickerPackageId' => $sticker_package_id,
    		'stickerId' => $sticker_id);
		$queryData = http_build_query($queryData,'','&');
		$headerOptions = array(
			'http'=>array(
				'method'=>'POST',
				'header'=> "Content-Type: application/x-www-form-urlencoded\r\n"
						."Authorization: Bearer ".LINE_TOKEN."\r\n"
						."Content-Length: ".strlen($queryData)."\r\n",
				'content' => $queryData
			)
		);
		$context = stream_context_create($headerOptions);
		$result = file_get_contents(LINE_API,FALSE,$context);
		$res = json_decode($result);
		return $res;

	}

}

?>