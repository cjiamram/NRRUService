<?php
session_start();
include_once "../config/config.php";
include_once "../lib/classAPI.php";
include_once "../objects/tstaff.php";
include_once "../config/database.php";


$database=new Database();
$db=$database->getConnection();
$obj=new tstaff($db);

$cnf=new Config();
$api=new classAPI();
$restURL=$cnf->restURL;
$id=isset($_GET["id"])?$_GET["id"]:0;
$assignTo=isset($_GET["assignTo"])?$_GET["assignTo"]:"";
$staffName=$obj->getStaffName($assignTo);


$path="tissue/readOneNotify.php?id=".$id;
$url=$cnf->restURL.$path;


$data=$api->getAPI($url);
$id=isset($_GET["id"])?$_GET["id"]:0;
//$picture=$restURL."/SCREEN/P-".$id.".png";
$token = $obj->getToken($assignTo); // LINE Token

//print_r($token);

$mymessage = "ได้รับแจ้งจาก: ".$data["notifyBy"]." \n";
$mymessage .= "โทรศัพท์: ".$data["telNo"]." \n";
$mymessage .= "วันที่แจ้ง: ".$data["createDate"]." \n";
$mymessage .= "หัวข้อ: ".$data["issueType"]." \n";
$mymessage .= "มอบหมายให้: ".$staffName." \n";
$mymessage .= "*************************************\n";
$mymessage .= "*รายละเอียดที่มอบหมาย                    *\n";
$mymessage .= "*************************************\n";
$mymessage .= $data["issueDetail"]."\n";
$mymessage .= "*************************************\n";

//$imageFile = new CURLFILE($picture); // Local Image file Path
$sticker_package_id = '2';  // Package ID sticker
$sticker_id = '34';    // ID sticker
  $data = array (
    'message'=>$mymessage,
    
    'stickerPackageId' => $sticker_package_id,
    'stickerId' => $sticker_id
  );
  //'imageFile' => $imageFile,
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

  ?>