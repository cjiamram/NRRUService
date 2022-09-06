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
$keyword=isset($_GET["keyWord"])?$_GET["keyWord"]:"";
$path="tassign/getData.php?keyWord=".$keyword;
$url=$cnf->restURL.$path;
$api=new ClassAPI();
$data=$api->getAPI($url);
echo "<thead>";
		echo "<tr>";
			echo "<th>No.</th>";
			echo "<th>".$objLbl->getLabel("t_assign","issueId","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_assign","fixProblem","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_assign","createDate","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_assign","assignFrom","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_assign","receiveBy","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_assign","startDate","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_assign","deuDate","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_assign","realStartDate","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_assign","realEndDate","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_assign","status","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_assign","assignTo","TH")."</th>";
			echo "<th>จัดการ</th>";
		echo "</tr>";
echo "</thead>";
if($data!=""){
echo "<tbody>";
$i=1;
foreach ($data as $row) {
		echo "<tr>";
			echo '<td>'.$i++.'</td>';
			echo '<td>'.$row["issueId"].'</td>';
			echo '<td>'.$row["fixProblem"].'</td>';
			echo '<td>'.$row["createDate"].'</td>';
			echo '<td>'.$row["assignFrom"].'</td>';
			echo '<td>'.$row["receiveBy"].'</td>';
			echo '<td>'.$row["startDate"].'</td>';
			echo '<td>'.$row["deuDate"].'</td>';
			echo '<td>'.$row["realStartDate"].'</td>';
			echo '<td>'.$row["realEndDate"].'</td>';
			echo '<td>'.$row["status"].'</td>';
			echo '<td>'.$row["assignTo"].'</td>';
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
}
?>

<script>
	tablePage("#tblDisplay");

</script>
