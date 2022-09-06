<?php
	header("content-type:application/json;charset=utf-8");
	include_once "../config/config.php";
	include_once "../lib/classAPI.php";
	$cnf=new Config();
	$id=isset($_GET["id"])?$_GET["id"]:0;

	$url=$cnf->restURL."tissue/readOneNotify.php?id=".$id;
	//print_r($url);
	$api=new ClassAPI();
	$data=$api->getAPI($url);
	//print_r($data);
	$sText="";
	if($data!=""){
		$sText="ผู้แจ้ง :".$data["notifyBy"]."\n";
		$sText.="โทรศัพท์ :".$data["telNo"]."\n";
		$sText.="รายละเอียด :".$data["issueDetail"]."\n";
		$sText.="ประเภทงาน :".$data["issueType"]."\n";
		$sText.="วันที่แจ้ง :".$data["createDate"]."\n";

		
	}

	echo json_encode(array("message"=>$sText));

?>