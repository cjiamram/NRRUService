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
$path="tmenu/getData.php?keyWord=".$keyword;
$url=$cnf->restURL.$path;
$api=new ClassAPI();
$data=$api->getAPI($url);
echo "<thead>";
		echo "<tr>";
			echo "<th>No.</th>";
			echo "<th>".$objLbl->getLabel("t_menu","MenuId","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_menu","MenuName","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_menu","Link","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_menu","Parent","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_menu","OrderNo","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_menu","LevelNo","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_menu","Topic","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_menu","enableDefault","TH")."</th>";
			echo "<th>จัดการ</th>";
		echo "</tr>";
echo "</thead>";
if(!isset($data["message"])){
echo "<tbody>";
$i=1;
foreach ($data as $row) {
		echo "<tr>";
			echo '<td>'.$i++.'</td>';
			echo '<td>'.$row["MenuId"].'</td>';
			echo '<td>'.$row["MenuName"].'</td>';
			echo '<td>'.$row["Link"].'</td>';
			echo '<td>'.$row["Parent"].'</td>';
			echo '<td>'.$row["OrderNo"].'</td>';
			echo '<td>'.$row["LevelNo"].'</td>';
			echo '<td>'.$row["Topic"].'</td>';
			echo '<td>'.$row["enableDefault"].'</td>';
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
  $(function () {
   
  	tablePage('#tblDisplay');
  });
</script>