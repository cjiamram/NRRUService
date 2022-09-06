<?php
	session_start();
	header("content-type:application/json;charset=UTF8");
	include_once "../config/database.php";
	include_once "../objects/tassign.php";
	include_once "../objects/manage.php";

	$database=new Database();
	$db=$database->getConnection();
	$obj=new tassign($db);

	$userCode=isset($_SESSION["UserCode"])?$_SESSION["UserCode"]:"chatchai.j";

	/*
		$stmt->bindParam(":fixProblem",$this->fixProblem);
		$stmt->bindParam(":realStartDate",$this->realStartDate) ;
		$stmt->bindParam(":realEndDate",$this->realEndDate) ;
		$stmt->bindParam(":status",$this->status) ;
		$stmt->bindParam(":assignTo",$this->assignTo) ;
		$stmt->bindParam(":issueId",$this->issueId);
		$stmt->bindParam(":receiveBy",$this->receiveBy) ;
	*/

	//print_r($userCode);

	$data=json_decode(file_get_contents("php://input"));
	$obj->fixProblem=$data->fixProblem;
	$obj->realStartDate=Format::getSystemDate($data->realStartDate);
	$obj->realEndDate=Format::getSystemDate($data->realEndDate);
	$obj->status=$data->status;
	$obj->assignTo=$data->assignTo;
	$obj->issueId=$data->issueId;
	$obj->receiveBy=$userCode;
	$obj->serviceCharge=$data->serviceCharge;
	$obj->materialCharge=$data->materialCharge;

	$flag=$obj->updateTracking();

	echo json_encode(array("message"=>$flag));


?>