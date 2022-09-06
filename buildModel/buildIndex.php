<?php 
	$tableName=isset($_GET["tableName"])?$_GET["tableName"]:"";
	$tName=str_replace("_", "", $tableName);
	copy('buildTemplate.php', "../".$tName.'/index.php');
	echo json_encode(
		        array("message" => true)
	);
?>