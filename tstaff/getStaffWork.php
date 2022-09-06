<?php
header("content-type:application/json;charset=UTF-8");
include_once "../config/database.php";
include_once "../objects/tstaff.php"; 
include_once "../objects/tissue.php"; 

$database=new Database();
$db=$database->getConnection();
$objStaff=new tstaff($db);
$objIssue=new tissue($db);
$stmt=$objStaff->listStaff();
$num = $stmt->rowCount();

if($num>0){
		$objArr=array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);

				$countWork=$objIssue->getProgressWork($username);

				$objItem=array(
					"id"=>$id,
					"username"=>$username,
					"staff"=>$staff,
					"countWork"=>$countWork
				);
				array_push($objArr, $objItem);
			}
			echo json_encode($objArr);
}
else{
			echo json_encode(array("message" => false));
}


?>