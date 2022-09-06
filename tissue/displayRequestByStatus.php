<?php
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
$status=isset($_GET["status"])?$_GET["status"]:"01";

if(isset($_GET["isSearch"])){

	$keyWord=isset($_GET["keyWord"])?$_GET["keyWord"]:"";
	$issueType=isset($_GET["issueType"])?$_GET["issueType"]:"";
	$requestDate=isset($_GET["requestDate"])?$_GET["requestDate"]:"";
	$path="tissue/getRequestByAdvanceStatus.php?status=".$status."&keyWord=".$keyWord."&issueType=".$issueType."&requestDate=".$requestDate;
}else{
	$path="tissue/getRequestByStatus.php?status=".$status;
}



$url=$cnf->restURL.$path;
$api=new ClassAPI();


$data=$api->getAPI($url);
echo "<thead>";
		echo "<tr>";
			echo "<th>No.</th>";
			echo "<th width='20%'>".$objLbl->getLabel("t_issue","createDate","TH")."-".$objLbl->getLabel("t_issue","notifyBy","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_issue","location","TH")."-".$objLbl->getLabel("t_issue","contact","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_issue","issueType","TH")."</th>";
			echo "<th width='300px'>".$objLbl->getLabel("t_issue","issueDetail","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_issue","status","TH")."</th>";
		echo "</tr>";
echo "</thead>";
if(!isset($data["message"])){
echo "<tbody>";
$i=1;
foreach ($data as $row) {
		echo "<tr>";
			echo '<td>'.$i++.'</td>';
			$strProcess='<div class=\'col-sm-12\'>'.$row["createDate"].'</div>';
			$strProcess.='<div class=\'col-sm-12\'>'.$row["notifyBy"].'</div>';

			$strProcess.='<div class=\'col-sm-12\'>
			<button type=\'button\' class=\'btn btn-info pull-left\'
				 onclick=\'receiveJob('.$row["id"].')\' >
				<span class=\'fa fa-handshake-o\'></span>
			</button></div>';

			echo '<td width=\'20%\' >'.$strProcess.'</td>';
			$strContact='<div class=\'col-sm-12\'>';
			$strContact.='<div>'.$row["location"].'</div>';
			$strContact.='</div>';
			$strContact.='<div class=\'col-sm-12\'>';
			$strContact.='<div>'.$row["contact"].'</div>';
			$strContact.='</div>';

			//echo '<td>'.$row["notifyBy"].'</td>';
			echo '<td>'.$strContact.'</td>';
			//echo '<td>'.$row["contact"].'</td>';
			echo '<td width=\'200px\'>'.$row["issueType"].'</td>';
			//echo '<td><textarea class=\'form-control\' style=\'width:100%;height:80px;\' >'.$row["issueDetail"].'</textarea></td>';
			echo '<td><div style="min-height:100px;max-height:300px;overflow:scroll;">'.$row["issueDetail"].'</div></td>';

			echo '<td>'.$row["status"].'</td>';
			echo "</tr>";
}
echo "</tbody>";
}
?>

<script>
	$(document).ready(function(){
		tablePage("#tbJobRequest");
	})
</script>
