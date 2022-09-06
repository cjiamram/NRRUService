<?php
	session_start();
	header("content-type:application/json;charset=UTF-8");
	include_once "../config/config.php";
	$cnf=new Config();
	$rootPath=$cnf->path;
	$sdate=date_create(date("Y-m-d"));
	date_add($sdate,date_interval_create_from_date_string("-150 days"));
	$userCode=isset($_SESSION["UserName"])?$_SESSION["UserName"]:"";
?>
<section class="content-header">
     <h1>
        <b>รายงาน</b>

        <small>>>รายงานการปฏิบัติงานรายบุคคล</small>
      </h1>
  
 </section>

<div class="box box-success">


<div  class="col-sm-1">
                  ระหว่างวันที่ :
 </div>
 <div class="col-sm-3">
 	<table width="100%">
 	<tr>
 		<td><input class="form-control" value="<?=date_format($sdate,"Y-m-d")?>" type='date' id="obj_sDate">
 		</td>
 		<td width='10px'>-
 		</td>
 		<td><input class="form-control" value="<?=date('Y-m-d')?>" type='date' id="obj_fDate">
 		</td>
 	</tr>	
 	</table>
 	
 </div>
 <div class="col-sm-8">
 	<input type="button" value="แสดงผล" id="btnReport" class="btn btn-primary pull-left" >
 </div>
 <div class="row">&nbsp;
</div>
	<div class="row">
		<div id="dvReport" class="col-sm-12">
		</div>
	
	</div>
</div>

<script>
	
	function displayReport(){
		var url="<?=$rootPath?>/tissue/reportIssueComplete.php?sDate="+$("#obj_sDate").val()+"&fDate="+$("#obj_fDate").val()+"&userCode=<?=$userCode?>";
		$("#dvReport").load(url);
	}

	$(document).ready(function(){
		displayReport();

		$("#btnReport").click(function(){
			displayReport();
		});

	});

</script>
