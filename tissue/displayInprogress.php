<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: html/text; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/tissue.php";
include_once "../objects/manage.php";

$database = new Database();
$db = $database->getConnection();
$obj = new tissue($db);
$issueId=isset($_GET["issueId"]) ? $_GET["issueId"] : 27;
$stmt = $obj->getWorkInprogress($issueId);
$num = $stmt->rowCount();
	echo "<table class=\"table table-bordered table-hover\">\n";
	echo "<thead>\n";
	echo "<th>รายละเอียดการแก้ไข</th>\n";
	echo "<th>วันที่</th>\n";
	echo "<th width=\"150px\">ความคืบหน้า</th>\n";
	echo "</thead>\n";
if($num>0){
	

	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		echo "<tr>\n";
		echo "<td>".$detail."</td>\n";
		echo "<td>".Format::getTextDate($operatingDate)."</td>\n";
		echo "<td>".$progress." %</td>\n";
		echo "</tr>\n";
	}
	echo "</table>\n";
	echo "</div>\n";
	echo "</form>\n";
}else{
	echo "<form role='form'>\n";
	echo "<div class=\"box-body\">\n";
	echo "<table class=\"table table-bordered table-hover\">\n";
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		echo "<tr>\n";
		echo "<td>No Message.</td>\n";
		
		echo "</tr>\n";
	}
	
}
echo "</table>\n";


?>