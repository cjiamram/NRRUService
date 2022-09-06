<?php
	header("content-type:application/json;charset=UTF-8");
	session_start();
	include_once "../config/config.php";
	$cnf=new Config();
	$rootPath=$cnf->path;

?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="<?=$rootPath?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=$rootPath?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<div class="box box-primary">
<div class="box-header with-border">
  <h3 class="box-title">จัดการลาเบล</h3>
</div>
 <div class="box-body">
 	<div class="col-sm-2">เลือกโมดูล
 	</div>
 	<div class="col-sm-3">
 		<select class="form-control" id="obj_module"></select>
 	</div>
 	<div class="col-sm-7">
 		
 	</div>

 	<table class="table table-bordered table-hover" id="tblDisplay">
 	</table>
 	</div>
 </div>
</div>

<script>
	listModule();
	displayLabel();

	function listModule(){
		var url="<?=$rootPath?>/tlabel/listModuleTh.php";
		setDDLPrefix(url,"#obj_module","****เลือก****");
	}

	function displayLabel(){
		var url ="<?=$rootPath?>/tlabel/displayLabel.php?tableName="+$("#obj_module").val();
		$("#tblDisplay").load(url);
	}

	

	


	$("#obj_module").change(function(){
		 displayLabel();
	});



</script>
