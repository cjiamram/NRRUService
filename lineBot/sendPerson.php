<?php

$name = "Chatchai Jiamram";
$email = "cjiamram@gmail.com";
$phone = "0832302608";
$lineid = "cjiamram@gmail.com";
$mesg = "Hello";

$message = $mesg."\n".'จาก: '.$name."\n".'อีเมล์: '.$email."\n".'Phone: '.$phone."\n".'Line ID: '.$lineid;

if($name<>"" || $email <> "" || $mesg <> "") {
	
	sendlinemesg();

	header('Content-Type: text/html; charset=utf-8');
	$res = notify_message($message);
	echo "<center>l;ส่งข้อความเรียบร้อยแล้ว</center>";
} else {
	echo "<center>Error: กรุณากรอกข้อมูลให้ครบถ้วน</center>";
}

function sendlinemesg() {
	
    define('LINE_API',"https://notify-api.line.me/api/notify");
	define('LINE_TOKEN',"wiCRKRqoyzPJLUO3yb7G09QIKqZBBtz30468vsVuee5");

	function notify_message($message){

		$queryData = array('message' => $message);
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