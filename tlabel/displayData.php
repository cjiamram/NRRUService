<?php
include_once "../config/config.php";
include_once "../lib/classAPI.php";
include_once "../config/database.php";
include_once "../objects/classLabel.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
$database = new Database();
$db = $database->getConnection();
$objLbl = new ClassLabel($db);
$cnf=new Config();
$tableName=isset($_GET["tableName"])?$_GET["tableName"]:"";
$path="tlabel/getData.php?tableName=".$tableName;
//print_r($path);
$url=$cnf->restURL.$path;
$api=new ClassAPI();
$data=$api->getAPI($url);
echo "<table class=\"table table-bordered table-hover\" id=\"tblLabel\">";
echo "<thead>";
		echo "<tr>";
			echo "<th>No.</th>";
			echo "<th>".$objLbl->getLabel("t_label","tableName","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_label","fieldName","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_label","thLabel","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_label","enLabel","TH")."</th>";
			echo "<th>จัดการ</th>";
		echo "</tr>";
echo "</thead>";
if($data!=""){
echo "<tbody>";
$i=1;
foreach ($data as $row) {
		echo "<tr>";
			echo '<td>'.$i++.'</td>';
			echo '<td>'.$row["tableName"].'</td>';
			echo '<td>'.$row["fieldName"].'</td>';
			echo '<td>'.$row["thLabel"].'</td>';
			echo '<td>'.$row["enLabel"].'</td>';
			echo "<td>
			<button type='button' class='btn btn-info'
				data-toggle='modal' data-target='#modal-input'
				onclick='readOne(".$row['id'].")'>
				<span class='fa fa-edit'></span>
			</button>
			<button type='button'
				class='btn btn-danger'
				onclick='confirmDelete(".$row['id'].")'>
				<span class='fa fa-trash'></span>
			</button></td>";
			echo "</tr>";
}
echo "</tbody>";
echo "</table>";
}
?>
<script>
	//tablePage

	$("document").ready(function(){
		setTablePage("#tblLabel",5);
	});

</script>
