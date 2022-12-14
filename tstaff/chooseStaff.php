<?php
session_start();
//include_once "../config/config.php";
//include_once "../lib/classAPI.php";
include_once "../config/database.php";
include_once "../objects/classLabel.php";
include_once "../objects/tissue.php"; 
include_once "../objects/tstaff.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
$database = new Database();
$db = $database->getConnection();
$obj=new tstaff($db);
$objLbl = new ClassLabel($db);

$issueType=isset($_GET["issueType"])?$_GET["issueType"]:"";
$obj=new tstaff($db);
$objIssue=new tissue($db);
$data=array();

$stmt=$obj->getStaffByIssueType($issueType);
if($stmt->rowCount()>0){
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		$countWork=$objIssue->getProgressWork($username);

				$objItem=array(
					"id"=>$id,
					"username"=>$username,
					"staff"=>$staff,
					"countWork"=>$countWork
				);
				array_push($data, $objItem);
	}
}

echo "<thead>";
		echo "<tr>";
			echo "<th colspan='2'>No.</th>";
			echo "<th>".$objLbl->getLabel("t_staff","staff","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_staff","countWork","TH")."</th>";
		echo "</tr>";
echo "</thead>";
if(count($data)>0){
		echo "<tbody>";
				$i=1;
				foreach ($data as $row) {
							echo "<tr>\n";
							$strChk="<input type='checkbox' id='objChk-".$i."'>";
							$strChk.="<input type='hidden' id='id-".$i."' value='".$row["username"]."'>";
							echo '<td width="10px">'.$strChk.'</td>'."\n";
							echo '<td width="30px" align="center">'.$i++.'</td>'."\n";
							echo '<td>'.$row["staff"].'</td>'."\n";
							echo '<td width=\'100px\' align="center">'.$row["countWork"].'</td>'."\n";
							echo "</tr>\n";
				}
		echo "</tbody>";
}
?>

<script>

</script>
