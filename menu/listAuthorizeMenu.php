<?php
	header("content-type:application/json;charset=UTF-8");
	include_once "../config/database.php";
	include_once "../objects/menu.php";

	$database=new Database();
	$db=$database->getConnection();
	$obj=new Menu($db);
	$stmt=$obj->listHeadMenu();

	$userName=isset($_GET["userName"])?$_GET["userName"]:"";

	if($stmt->rowCount()>0){
		$objArr=array();
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			$isExist=$obj->isMenuExist($MenuId,$userName);
			$objItem=array("MenuId"=>$MenuId,"MenuName"=>$MenuName,"LevelNo"=>$LevelNo,"IsExist"=>$isExist);
			array_push($objArr, $objItem);
			$stmt1=$obj->listChildMenu($MenuId);
			if($stmt1->rowCount()>0){
				while($row1=$stmt1->fetch(PDO::FETCH_ASSOC)){
					extract($row1);
					$isExist=$obj->isMenuExist($MenuId,$userName);
					$objItem=array("MenuId"=>$MenuId,"MenuName"=>$MenuName,"LevelNo"=>$LevelNo,"IsExist"=>$isExist);
					array_push($objArr, $objItem);
				}
			}
		}
		echo json_encode($objArr);
	}else{
		echo json_encode(array("message"=>false));
	}
?>