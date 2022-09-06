<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/classLabel.php";
include_once "../config/config.php";
$database = new Database();
$db = $database->getConnection();
$objLbl = new ClassLabel($db);
$cnf=new Config();
$path=$cnf->path;
?>
<form role='form'>
<div class="box-body">
		<div class='form-group'>
			<label class="col-sm-12">คำค้น :</label>
			<div class="col-sm-12">
				<input type="text" class="form-control" id="obj_keyWord">
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12">ประเภทคำขอ :</label>
			<div class="col-sm-12">
				<select id="obj_issueType" class="form-control"></select>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12">วันที่แจ้ง :</label>
			<div class="col-sm-12">
				<div class="input-group date">
				<div class="input-group-addon">
				<i class="fa fa-calendar"></i>
				</div>
				<input type="date" class="form-control" id="obj_requestDate">
				</div>
			</div>
		</div>
</div>
</form>

<script>
	var rootPath='<?php echo $path; ?>';  
	function listIssueType(){
		var url=rootPath+"/tissuetype/getData.php";
		setDDLPrefix(url,"#obj_issueType","***Type***");
	}

	$(document).ready(function(){
		listIssueType();
	});

</script>