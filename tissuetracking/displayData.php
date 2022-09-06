<?php
include_once "../config/config.php";
include_once "../lib/classAPI.php";
include_once "../config/database.php";
include_once "../objects/classLabel.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
$database = new Database();
$db = $database->getConnection();
$objLbl = new ClassLabel($db);
$cnf=new Config();
$issueId=isset($_GET["issueId"])?$_GET["issueId"]:"";
$path="tissuetracking/getData.php?issueId=".$issueId;
$url=$cnf->restURL.$path;
$api=new ClassAPI();
$data=$api->getAPI($url);
echo "<thead>";
		echo "<tr>";
			echo "<th>No.</th>";
			echo "<th>".$objLbl->getLabel("t_issuetracking","detail","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_issuetracking","status","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_issuetracking","operatingDate","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_issuetracking","progress","TH")."</th>";
		echo "</tr>";
echo "</thead>";
if(!isset($data["message"])){
echo "<tbody>";
$i=1;
foreach ($data as $row) {
		echo "<tr>";
			echo '<td>'.$i++.'</td>';
			echo '<td>'.$row["detail"].'</td>';
			echo '<td>'.$row["status"].'</td>';
			echo '<td>'.$row["operatingDate"].'</td>';
			echo '<td>'.$row["progress"].'</td>';
			echo "</tr>";
}
echo "</tbody>";
}
?>

<script>
$(document).ready(function(){
		tablePage("#tbIssueDisplay");
	});
</script>
