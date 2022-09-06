<?php
session_start();
include_once "../config/config.php";
include_once "../lib/classAPI.php";
include_once "../config/database.php";
include_once "../objects/classLabel.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: html/text; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
$database = new Database();
$db = $database->getConnection();
$objLbl = new ClassLabel($db);
$cnf=new Config();
$path="tstaff/getStaffWork.php";
$url=$cnf->restURL.$path;
$api=new ClassAPI();


$data=$api->getAPI($url);

echo "<thead>";
		echo "<tr>";
			echo "<th colspan='2'>No.</th>";
			echo "<th>".$objLbl->getLabel("t_staff","staff","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_staff","countWork","TH")."</th>";
		echo "</tr>";
echo "</thead>";
if($data!==""){
echo "<tbody>";
$i=1;
foreach ($data as $row) {
		echo "<tr>\n";
			echo '<td width="50px">'.$i++.'</td>'."\n";
			echo '<td>'.$row["staff"].'</td>'."\n";
			echo '<td width=\'70px\'>'.$row["countWork"].'</td>'."\n";
			echo "</tr>\n";
}
echo "</tbody>";
}
?>

<script>
	$(document).ready(function(){
		tablePage("#tbStaffWork");
	})
</script>
