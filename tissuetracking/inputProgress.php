<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/tissuetracking.php";
include_once "../objects/classLabel.php";
include_once "../config/config.php";

$database = new Database();
$db = $database->getConnection();
$objLbl = new ClassLabel($db);
$cnf=new Config();

$userCode=isset($_SESSION["UserName"])?$_SESSION["UserName"]:"";
$issueId=isset($_GET["issueId"])?$_GET["issueId"]:0;

$rootPath=$cnf->path;

?>
<div class="row">
<div class="col-sm-12">
<div class="box">
<div class="box box-primary">
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_issue","issueDetail","th").":" ?></label>
			<div class="col-sm-12">
			
				
				<div id="obj_issueDetail" style="min-height:200,overflow:scrool"></div>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_issue","notifyBy","th").":" ?>/<?php echo $objLbl->getLabel("t_issue","createDate","th").":" ?></label>
			<div class="col-sm-6">
				<input type="text" id="obj_notifyBy" class="form-control" disabled>
			</div>
			<div class="col-sm-6">
				<input type="text" id="obj_requestDate" class="form-control" disabled>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"></label>
			
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_issuetracking","detail","th").":" ?></label>
			<div class="col-sm-12">
				<div id="dvDetail">
					<textarea class="form-control" 
					id="obj_detail"
					cols="50" rows="3">
					</textarea>
					</div>
				
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_issuetracking","status","th").":" ?>/<?php echo $objLbl->getLabel("t_issuetracking","operatingDate","th").":" ?>/<?php echo $objLbl->getLabel("t_issuetracking","progress","th").":" ?></label>
			<div class="col-sm-6">
			<select class="form-control" id="obj_progressStatus"></select>
			</div>
			<div class="col-sm-6">
				<table width="100%">
					<tr>
					<td width="49%">
							<div class="input-group date">
							<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
							</div>
							<input type="date" class="form-control" id="obj_operatingDate">
							</div>
					</td>
					<td LIGN="center" width="2%">-</td>
					<td width="25%">
						<input type="text" class="form-control"  id="obj_progress" placeholder='progress'>
						
					</td>
					<td>&nbsp;</td>
					<td>%</td>
					</tr>
				</table>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"></label></label>
			
		</div>
		
</div>
</div>
</div>
</div>
<div>&nbsp;</div>
<div class="row">
	<div class="col-sm-12">
	<div class="box box-warning">
	<table id="tbIssueDisplay" class="table table-bordered table-hover">
	</table>
	</div>
</div>
</div>


<script>


  var userCode='<?=$userCode?>';
  var issueId='<?=$issueId?>';

  

  function updateStaffProgress(issueId,userCode,progressStatus){
  		var url="<?=$rootPath?>/tassignstaff/updateStatusByUser.php?issueId="+issueId+"&userCode="+userCode+"&progressStatus="+progressStatus;
  		console.log(url);
  		var flag=executeGet(url);
  		return flag;
  }

  function createProgress(){
			var url='<?=$rootPath?>/tissuetracking/create.php';
			jsonObj={
				issueId:$("#obj_id").val(),
				staffCode:userCode,
				detail:$("#obj_detail").val(),
				status:$("#obj_progressStatus").val(),
				operatingDate:$("#obj_operatingDate").val(),
				progress:$("#obj_progress").val()
			}
			var jsonData=JSON.stringify (jsonObj);
			var flag=executeData(url,jsonObj,false);
			updateStaffProgress($("#obj_id").val(),userCode,$("#obj_progressStatus").val());
			updateStatusByAssign();
			return flag;
	}
	
	function updateProgress(){
				var url='<?=$rootPath?>/tissuetracking/update.php';
				jsonObj={
					issueId:$("#obj_id").val(),
					staffCode:userCode,
					detail:$("#obj_detail").val(),
					status:$("#obj_progressStatus").val(),
					operatingDate:$("#obj_operatingDate").val(),
					progress:$("#obj_progress").val(),
					id:$("#obj_id").val()
				}
				var jsonData=JSON.stringify (jsonObj);

				var flag=executeData(url,jsonObj,false);
				updateStaffProgress($("#obj_id").val(),userCode,$("#obj_progressStatus").val());
				updateStatusByAssign();
				return flag;
		}


	

	$(document).ready(function(){
			setTextEditor("#obj_detail");
		    listProgressStatus();
		    $("#obj_issueDetail").val("");
		    setCurrentSysDate("#obj_operatingDate");
		    $("#obj_progressStatus").prop('selectedIndex',1);
		     loadIssueDetail();
		     displayProgress();
		    $("#obj_progressStatus").change(function(){
		    	if($("#obj_progressStatus").val()==="04"){
		    		$("#obj_progress").val(100);
		    	}
		    	else{
		    		if($("#obj_progressStatus").val()==="08")
		    			$("#obj_progress").val(0);
		    		else
		    			$("#obj_progress").val(50);

		    	}
		    });

	});
	
</script>

