<?php
session_start();
include_once "../config/config.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
$userCode=isset($_SESSION["UserName"])?$_SESSION["UserName"]:"Admin";
$cnf=new Config();
$rootPath=$cnf->path;

?>
<input type="hidden" id="obj_evaluate" value="5">
<input type="hidden" id="obj_usercode" value="<?=$userCode?>">
<form role='form'>
<div class="box-body">
		    <div class='form-group'>
			<div class="col-sm-12">
				<input type="radio" id="obj_5" name="radObj" onclick='setEvaluateValue(5)' checked value="5">
  				<label for="obj_5">พึงพอใจมาก</label>
			</div>
		    </div>
		     <div class='form-group'>
			<div class="col-sm-12">
				<input type="radio" id="obj_4" name="radObj" onclick='setEvaluateValue(4)' value="4">
  				<label for="obj_4">พึงพอใจมาก</label>
			</div>
		    </div>
		    <div class='form-group'>
			<div class="col-sm-12">
				<input type="radio" id="obj_3" name="radObj" onclick='setEvaluateValue(3)' value="3">
  				<label for="obj_3">พึงพอใจปานกลาง</label>
			</div>
		    </div>
		    <div class='form-group'>
			<div class="col-sm-12">
				<input type="radio" id="obj_2" name="radObj" onclick='setEvaluateValue(2)' value="2">
  				<label for="obj_2">พึงพอใจน้อย</label>
			</div>
		    </div>
		    <div class='form-group'>
			<div class="col-sm-12">
				<input type="radio" id="obj_1" name="radObj" onclick='setEvaluateValue(1)' value="1">
  				<label for="obj_1">พึงพอใจน้อยที่สุด</label>
			</div>
		    </div>

		    <div class='form-group' >
		    	<div class="col-sm-12">
		    		<textarea id="obj_message" class="form-control" cols="50" rows="4"></textarea>
		    	</div>
		    </div>
</div>
</form>

<script type="text/javascript">
	function setEvaluateValue(evaValue){
			
			$("#obj_evaluate").val(evaValue);
	}
	
	function createEvaluation(){
		$("#obj_evaluate").val($('input[name="radObj"]:checked').val());
		var issueId=$("#obj_issueId").val();
		var msg=$("#obj_message").val();
		var score=$('input[name="radObj"]:checked').val();
		var url="<?=$rootPath?>/tevaluate/create.php";
		
		var jsonObj={
			"issueId":issueId,
			"evaluateBy":$("#obj_usercode").val(),
			"message":msg,
			"score":score

		}
		var jsonData=JSON.stringify (jsonObj);

		var flag=executeData(url,jsonObj,false);
		return flag;
	}

</script>