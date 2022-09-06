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
$path="tissue/getData.php?keyWord=".$keyword;
$url=$cnf->restURL.$path;
$api=new ClassAPI();
$data=$api->getAPI($url);
echo "<thead>";
		echo "<tr>";
			echo "<th>No.</th>";
			echo "<th>".$objLbl->getLabel("t_issue","staffId","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_issue","roomNo","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_issue","floorNo","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_issue","building","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_issue","telNo","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_issue","lineNo","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_issue","createDate","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_issue","issueType","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_issue","issueDetail","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_issue","notifyBy","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_issue","status","TH")."</th>";
			echo "<th>จัดการ</th>";
		echo "</tr>";
echo "</thead>";
if($data!=""){
echo "<tbody>";
$i=1;
foreach ($data as $row) {
		echo "<tr>";
			echo '<td>'.$i++.'</td>';
			echo '<td>'.$row["staffId"].'</td>';
			echo '<td>'.$row["roomNo"].'</td>';
			echo '<td>'.$row["floorNo"].'</td>';
			echo '<td>'.$row["building"].'</td>';
			echo '<td>'.$row["telNo"].'</td>';
			echo '<td>'.$row["lineNo"].'</td>';
			echo '<td>'.$row["createDate"].'</td>';
			echo '<td>'.$row["issueType"].'</td>';
			echo '<td>'.$row["issueDetail"].'</td>';
			echo '<td>'.$row["notifyBy"].'</td>';
			echo '<td>'.$row["status"].'</td>';
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
