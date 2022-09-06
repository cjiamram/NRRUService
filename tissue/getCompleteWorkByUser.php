<?php
	header("content-type:application/json;charset=UTF-8");
	include_once "../config/database.php";
	include_once "../objects/tissue.php";
	include_once "../objects/manage.php";
	include_once "../objects/tissuetracking.php";

	$database=new Database();
	$db=$database->getConnection();
	$obj=new tissue($db);
	$obj_1=new tissuetracking($db);
	$userCode=isset($_GET["userCode"])?$_GET["userCode"]:"chatchai.j";
	$stmt=$obj->getCompleteWorkByUser($userCode);
	if($stmt->rowCount()>0){
		$objArr=array();
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			$arrProblem =$obj_1->getTrackingComplete($id);
			//print_r($arrProblem);
			$objItem=array(
						"id"=>$id,
						"Location"=>$Location,
						"CreateDate"=>Format::getTextDate($createDate),
						"IssueDetail"=>$issueDetail,
						"FixProblem"=>$arrProblem["fixProblem"],
						"FixDate"=>Format::getTextDate($arrProblem["createDate"])

					);
			array_push($objArr,$objItem);
		}
		echo json_encode($objArr);

	}else
	echo json_encode(array("message"=>false));

?>