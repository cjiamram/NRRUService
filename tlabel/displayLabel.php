<?php
include_once "../config/config.php";
include_once "../lib/classAPI.php";
include_once "../config/database.php";
include_once "../objects/tlabel.php";
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
$path="tlabel/listLabel.php?tableName=".$tableName;
$url=$cnf->restURL.$path;
//print_r($url);
$api=new ClassAPI();
$data=$api->getAPI($url);

$rootPath=$cnf->path;

echo "<table class=\"table table-bordered table-hover\" id=\"tblLabel\">";
echo "<thead>";
		echo "<tr>";
			echo "<th>No.</th>";
			echo "<th>".$objLbl->getLabel("t_label","tableName","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_label","moduleTh","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_label","thLabel","TH")."</th>";
			echo "<th>จัดการ</th>";
		echo "</tr>";
echo "</thead>";
if(!isset($data["message"])){
echo "<tbody>";
$i=1;
foreach ($data as $row) {
		echo "<tr>";
			echo '<td>'.$i.'</td>';
			echo '<td>'.$row["tableName"].'<input type="hidden" id="id-'.$i.'" value="'.$row["id"].'" ></td>';
			echo '<td width="400px">'.$row["moduleTh"].'</td>';
			echo '<td width="400px"><input type="text" onchange="labelChange('.$i.')" id="T-'.$i.'"  class="form-control" value="'.$row["thLabel"].'"></td>';
			echo "<td>
			<button type='button' class='btn btn-info'
				onclick=\"saveLabel(".$i.")\">
				<span class='fa fa-floppy-o'></span>
			</button>
			</td>";
			echo "</tr>";
			$i++;
}
echo "</tbody>";
echo "</table>";
}
?>
<input type='hidden' id='obj_labelChange'>
<script>
	
	
	function saveLabel(i){
		if($("#obj_labelChange").val()!==""){
			var id=$("#id-"+i).val();
			var url="<?=$rootPath?>/tlabel/updateLabel.php?id="+id+"&thLabel="+$("#obj_labelChange").val();
			console.log(url);
			var flag=executeGet(url);
			console.log(flag);
			if(flag.message===true){
				swal.fire({
					title: "การกำหนด Label เสร็จสมบูรณ์แล้ว",
					type: "success",
					buttons: [false, "ปิด"],
					dangerMode: true,
					});
			}
			displayLabel();
			$("#obj_labelChange").val("");	
		}
	}

	function labelChange(i){
		var T=$("#T-"+i).val();
		console.log(T);
		$("#obj_labelChange").val(T);	
	}	


	$("document").ready(function(){
		tablePage("#tblLabel");
	});

</script>
