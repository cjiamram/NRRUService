<?php
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: POST");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
		include_once "../config/database.php";
		include_once "../objects/tassign.php";
		include_once "../objects/classLabel.php";
		include_once "../config/config.php";
		$database = new Database();
		$db = $database->getConnection();
		$objLbl = new ClassLabel($db);
		$cnf=new Config();
		$rootPath=$cnf->path;
?>
<link rel="stylesheet" href="<?=$rootPath?>/bower_components/select2/dist/css/select2.min.css">
<script src="<?=$rootPath?>/bower_components/select2/dist/js/select2.full.min.js"></script>

<form role='form'>
<div class="box-body">

<table  class="table table-bordered table-hover">
	<tr>
		<td width="150px">
			ผู้รับโอน :
		</td>
		<td>
			<select id="obj_assignPerson" class="select2 form-control" style="width:100%"></select>
		</td>
	</tr>
	<tr>
		<td colspan="2">หมายเหตุ</td>
	</tr>
	<tr>
		<td colspan="2">
		<textarea class="form-control" id="obj_message" rows="5" cols="50">

		</textarea>
		</td>
	</tr>
	

</table>
</div>
</form>

<script>

 $(function () {
		$('.select2').select2();
		 listAssignStaff();
  });


</script>