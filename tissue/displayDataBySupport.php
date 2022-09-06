<?php
include_once "../config/config.php";
include_once "../lib/classAPI.php";
include_once "../config/database.php";
include_once "../objects/classLabel.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: html/text; charset=UTF-8");
$database = new Database();
$db = $database->getConnection();
$objLbl = new ClassLabel($db);
$cnf=new Config();
$status=isset($_GET["status"])?$_GET["status"]:"";
$userCode=isset($_GET["userCode"])?$_GET["userCode"]:"";
$path="tissue/getDataBySupport.php?status=".$status."&userCode=".$userCode;
$url=$cnf->restURL.$path;
$api=new ClassAPI();


$data=$api->getAPI($url);
echo "<thead>";
		echo "<tr>";
			echo "<th>No.</th>";
			echo "<th>".$objLbl->getLabel("t_issue","createDate","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_issue","issueType","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_issue","issueDetail","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_issue","status","TH")."</th>";
			echo "<th>จัดการ</th>";
		echo "</tr>";
echo "</thead>";
if(!isset($data["message"])){
		echo "<tbody>";
		$i=1;
		foreach ($data as $row) {
			print_r($row["status"]);
				echo "<tr>";
					echo '<td width=\'80px\' align=\'center\'>'.$i++.'</td>'."\n";
					echo '<td width=\'150px\' align=\'center\'>'.$row["createDate"].'</td>'."\n";
					echo '<td>'.$row["issueType"].'</td>'."\n";
					echo '<td><div style="min-height:100px;max-height:300px;overflow:scroll;">'.$row["issueDetail"].'</div></td>'."\n";
					echo '<td width=\'200px\'>'.$row["progressStatus"].'</td>'."\n";
					
					$strLink="";
					switch($row["statusCode"]){

						case "02":{

								$strLink="<button type='button' class='btn btn-info'
								onclick='getJobAssign(".$row["id"].")' >
								<span class='glyphicon glyphicon-list-alt'></span>
								</button>";
								$strLink.="<button type='button' class='btn btn-warning'
								onclick='setTranser(".$row["id"].")' >
								<span class='glyphicon glyphicon-send'></span>
								</button>";
							}
						break;
						case "03":{
								$strLink="<button type='button' class='btn btn-success'
								onclick='getJobTracking(".$row["id"].")' >
								<span class='glyphicon glyphicon glyphicon glyphicon-tasks'></span>
								</button>";
								$strLink.="<button type='button' class='btn btn-warning'
								onclick='setTranser(".$row["id"].")' >
								<span class='glyphicon glyphicon-send'></span>
								</button>";

						}
					} 
					echo "<td width='100px'>".$strLink."</td>\n";
					echo "</tr>\n";
		}
		echo "</tbody>";
}
?>

<style type="text/css">
.tiptext {
   border: 1px solid #ddd;
   border-radius: 4px;
   padding: 5px;
   width: 100%;
}
.description {
    display:none;
    position:absolute;
    border:1px solid #ddd;
    border-radius: 4px;
    width:400px;
    min-height:200px;
}
</style>



<script>
	



	$(document).ready(function(){

		$(".tiptext").mouseover(function() {
			$(this).children(".description").show();
		}).mouseout(function() {
			$(this).children(".description").hide();
		});

		tablePage("#tbJobRequest");
	})
</script>
