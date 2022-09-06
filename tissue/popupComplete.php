
<form role='form'>
<div class="box-body">
<?php
	include_once "../config/config.php";
	include_once "../lib/classAPI.php";
	$cnf=new Config();
	$url=$cnf->restURL."tissue/getTaskComplete.php";
	//print_r($url);
	$api=new ClassAPI();
	
	$data=$api->getAPI($url);
	//print_r($data);
	if($data!=""){
		echo "<table id=\"tblInitialize\" 
		class=\"table table-bordered table-hover\">";
		echo "<tr>\n";
		echo "<th>No.</th>\n";
		echo "<th>ประเภทปัญหา</th>\n";
		echo "<th>วันที่แจ้ง</th>\n";
		echo "<th>รายละเอียด</th>\n";
		echo "<th>ผู้แจ้ง</th>\n";
		echo "<th>ผู้รับมอบหมาย</th>\n";
		echo "</tr>\n";
		$i=1;
		echo "<tbody>\n";
		foreach ($data as $row) {
			echo "<tr>\n";
			echo "<td>".$i++."</td>\n";
			echo "<td width='150px'>".$row["IssueType"]."</td>\n";
			echo "<td width='150px'>".$row["CreateDate"]."</td>\n";
			echo "<td ><div style='min-height:100px;max-height:300px;overflow:scroll;'>".$row["IssueDetail"]."</div></td>\n";
			echo "<td width='200px'>".$row["NotifyBy"]."</td>\n";
			echo "<td width='200px'>".$row["Response"]."</td>\n";
			echo "</tr>\n";
		}
		echo "</tbody>\n";
		echo "</table>\n";
	}else{
		echo "<div style='text-align:center'><span style='font-family:tahoma;font-size:18px;font-weight:bold;color:red'>ไม่มีงานที่ดำเนินงานเสร็จสมบูรณ์แล้ว</span></div>";
	}
?>



</div>
</form>
<script>
	$(document).ready(function(){
		tablePage("#tblInitialize");
	});
</script>
