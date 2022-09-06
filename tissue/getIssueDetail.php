<?php
header("content-type:html/text;charset=UTF-8");
include_once "../config/database.php";
include_once "../objects/tissue.php";
$database=new Database();
$db=$database->getConnection();
$obj=new tissue($db);
$id=isset($_GET["id"])?$_GET["id"]:0;
$issueDetail=$obj->getIssueDetail($id);
echo "<textarea id='obj_issueDetail' class='form-control'>".$issueDetail."</textarea>";

?>

<script>
	$(document).ready(function(){
		setTextEditor("#obj_issueDetail");
	});
</script>