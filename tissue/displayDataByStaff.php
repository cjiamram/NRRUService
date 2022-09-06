
<?php

header("Content-Type: html/text; charset=UTF-8");
include_once "../config/config.php";
include_once "../lib/classAPI.php";
include_once "../config/database.php";
include_once "../objects/classLabel.php";
include_once "../objects/tissue.php";

$database = new Database();
$db = $database->getConnection();
$obj=new tissue($db);
$objLbl = new ClassLabel($db);
$cnf=new Config();
$userCode=isset($_GET["userCode"])?$_GET["userCode"]:"Admin";
//print_r($userCode);
$path="";

if(isset($_GET["isSearch"])){

	$keyWord=isset($_GET["keyWord"])?$_GET["keyWord"]:"";
	$issueType=isset($_GET["issueType"])?$_GET["issueType"]:"";
	$requestDate=isset($_GET["requestDate"])?$_GET["requestDate"]:"";
	$path="tissue/getAdvanceByStaff.php?userCode=".$userCode."&keyWord=".$keyWord."&issueType=".$issueType."&requestDate=".$requestDate;
}else{
	$path="tissue/getDataByStaff.php?userCode=".$userCode;
}




$url=$cnf->restURL.$path;
$api=new ClassAPI();

$data=$api->getAPI($url);
echo "<thead>";
		echo "<tr>";
			echo "<th>No.</th>";
			echo "<th>".$objLbl->getLabel("t_issue","createDate","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_issue","issueType","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_issue","issueDetail","TH")."</th>";
			echo "<th width='100px'>".$objLbl->getLabel("t_issue","status","TH")."</th>";
			echo "<th>คิวที่</th>";

			echo "<th>จัดการ</th>";
		echo "</tr>";
echo "</thead>";
if(!isset($data["message"])){
echo "<tbody>";
$i=1;
foreach ($data as $row) {
		echo "<tr>\n";
			echo '<td>'.$i++.'</td>'."\n";
			echo '<td width=\'100px\' align=\'center\'>'.$row["createDate"].'</td>'."\n";
			echo '<td width=\'200px\'>'.$row["issueType"].'</td>'."\n";
			echo '<td><div style="<div style="min-height:100px;max-height:300px;overflow:scroll;">'.$row["issueDetail"].'</div></td>'."\n";
			
			echo '<td>'.$row["status"].'</td>'."\n";
			if($row["statusCode"]==="01")
				echo '<td width=\'70px\'>'.$obj->getQueue($row["id"],$row["issueTypeCode"]) .'</td>'."\n";
			else
				echo '<td width=\'70px\'>---</td>'."\n";

				$strOperate="";

			if($row["statusCode"]=="01"){
				$strOperate="
				<button type='button' class='btn btn-warning'
					onclick='displayInprogress(".$row['id'].")'>
					<span class='fa fa-line-chart'></span>
				</button>
				<button type='button' class='btn btn-info'
					onclick='readOneIssue(".$row['id'].")'>
					<span class='fa fa-edit'></span>
				</button>
				<button type='button'
					class='btn btn-danger'
					onclick='confirmDelete(".$row['id'].")'>
					<span class='fa fa-trash'></span>
				</button>";
			}
			echo "<td width='150px'>".$strOperate."</td>\n";
			echo "</tr>\n";
}
echo "</tbody>";
}
?>

<script>
	$(document).ready(function(){
		tablePage("#tbStaffRequest");
	})
	
</script>
