<?php
		session_start();
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
		$UserName=isset($_SESSION["UserName"])?$_SESSION["UserName"]:"";
		$cnf=new Config();
		$rootPath=$cnf->path;

		$cdate=date("Y-m-d");
		$cdate=date_create($cdate);
		date_add($cdate,date_interval_create_from_date_string("3 days"));
?>
<link rel="stylesheet" href="<?=$rootPath?>/bower_components/select2/dist/css/select2.min.css">
<script src="<?=$rootPath?>/bower_components/select2/dist/js/select2.full.min.js"></script>

<form role='form'>
<div class="box-body">

	<div class='form-group'>
      <label class="col-sm-12"><?php echo $objLbl->getLabel("t_issue","issueDetail","th").":" ?></label>
      <div class="col-sm-12">
      
            <div id="obj_Detail_1" style="min-height: 100px;overflow: scroll;"></div>

      </div>
    </div>
    <div class='form-group'>
      <label class="col-sm-12"><?php echo $objLbl->getLabel("t_issue","notifyBy","th").":" ?>/<?php echo $objLbl->getLabel("t_issue","createDate","th").":" ?></label>
      <div class="col-sm-6">
      <input type="text" id="obj_notifyBy_1" class="form-control" disabled>
      </div>
      <div class="col-sm-6">
      <input type="text" id="obj_requestDate_1" class="form-control" disabled>
      </div>
    </div>
 

    <div class='form-group'>
      <label class="col-sm-12"><?php echo $objLbl->getLabel("t_assign","fixProblem","th").":" ?></label>
      <div class="col-sm-12">
       	<div id="dvFix">
        <textarea class="form-control" id='obj_fixProblem'
        rows="3" cols="50"
         ></textarea>
     	</div>
      </div>
    </div>
	
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_assign","duration","th").":" ?></label>
			<div class="col-sm-12">
				<table width="100%">
				<tr>
					<td width="49%">
						<div class="input-group date">
						<div class="input-group-addon">
						<i class="fa fa-calendar"></i>
						</div>
						<input type="date" class="form-control" value="<?=date('Y-m-d')?>" id="obj_realStartDate">
						</div>
					</td>
					<td align="center">-</td>
					<td width="49%">
						<div class="input-group date">
						<div class="input-group-addon">
						<i class="fa fa-calendar"></i>
						</div>
						<input type="date" class="form-control" value="<?=date('Y-m-d')?>" id="obj_realEndDate">
						</div>
						
					</td>
				</tr>
				</table>
			</div>
		</div>
		

		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_assign","status","th").":" ?>/<?php echo $objLbl->getLabel("t_assign","serviceCharge","th").":" ?>/<?php echo $objLbl->getLabel("t_assign","materialCharge","th").":" ?></label>
			<div class="col-sm-4">
				<select class="form-control" id="obj_receiveStatus">
				</select>
			</div>
			<div class="col-sm-4">
				<input type="text" value="0" class="form-control" id="obj_serviceCharge">

			</div>
			<div class="col-sm-4">
				<input type="text" value="0" class="form-control" id="obj_materialCharge">

			</div>
		</div>

    <div class='form-group' id="dvTransfer" style="display:none">
      <label class="col-sm-12"><?php echo $objLbl->getLabel("t_assign","assignTo","th").":" ?></label>
      <div class="col-sm-6">
          <select id="obj_assignTo" class="select2" style="width:100%"></select>
      </div>
    </div>
	
</div>
</form>
<script>

	


$(document).ready(function(){
   listReceiveStatus();
   loadIssueDetailAssign();
   setTextEditor("#obj_fixProblem");
   $("#obj_receiveStatus").val("03");
});

</script>

