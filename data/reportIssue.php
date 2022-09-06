<?php
	header("content-type:application/json;charset=UTF-8");
	include_once "../config/config.php";
	$cnf=new Config();
	$rootPath=$cnf->path;
	$sdate=date_create(date("Y-m-d"));
	date_add($sdate,date_interval_create_from_date_string("-150 days"));
?>
<section class="content-header">
     <h1>
        <b>รายงาน</b>

        <small>>>รายงานการปฏิบัติงาน</small>
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
	<div class="row">
	<div class="col-sm-8" id="dvBar">
	</div>
	<div class="col-sm-4">
	<table width='100%'>
	<tr>
		<td>
			<div id="dvPieStatus"></div>
		</td>
	</tr>
	<tr>
		<td>
			<div id="dvPieIssue"></div>
		</td>
	</tr>
	</table>
	</div>
	</div>
	<div>
		<iframe id="dvPivot" style="width:100%;height:600px;border:none;"></iframe>

	</div>

	<div>
 
</div>





<script>
	
	function setBarChart(){
		var url="<?=$rootPath?>/data/barMonthCountIssue.php?sDate="+$("#obj_sDate").val()+"&fDate="+$("#obj_fDate").val();
		$("#dvBar").load(url);
	}

	function setPivot(){
		var url="<?=$rootPath?>/data/pivotIssueStatus.php?sDate="+$("#obj_sDate").val()+"&fDate="+$("#obj_fDate").val();
		console.log(url);
		$("#dvPivot").attr("src",url);

	}

	function setPieCountStatus(yrmn){
		var url="<?=$rootPath?>/data/pieCountStatus.php?yrmn="+yrmn;
		$("#dvPieStatus").load(url);

	}


	function setPieCountIssue(yrmn){
		var url="<?=$rootPath?>/data/pieCountIssue.php?yrmn="+yrmn;
		console.log(yrmn);
		$("#dvPieIssue").load(url);

	}


	

	$(document).ready(function(){
		setBarChart();
		setPivot();
		setPieCountStatus("");
		setPieCountIssue("");

		$("#btnReport").click(function(){
			setBarChart();
			setPivot();
			setPieCountStatus("");
			setPieCountIssue("");
		});

	});

</script>
