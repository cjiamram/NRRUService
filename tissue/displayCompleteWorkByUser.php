<input type="hidden" id="obj_issueId">
<section class="content-header">
     <h1>
        <b>ระบบแจ้งซ่อมออนไลน์</b>
        <small>>>รายการแจ้งซ่อมที่เสร็จสมบูรณ์แล้ว</small>
      </h1>
    </section>
<div class="box">
<?php
session_start();
header("content-type:application/json;charset=UTF-8");
include_once "../config/config.php";
include_once "../lib/classAPI.php";
$cnf=new Config();
$rootPath=$cnf->path;
$api=new ClassAPI();
$userCode=isset($_SESSION["UserName"])?$_SESSION["UserName"]:"chatchai.j";

$url=$cnf->restURL."/tissue/getCompleteWorkByUser.php?userCode=".$userCode;
$data=$api->getAPI($url);
   echo "<table id=\"tbJobRequest\" class=\"table table-bordered table-hover\">";
	echo "<tr>\n";
	echo "<th>No.</th>\n";
	echo "<th>ปัญหาที่แจ้ง</th>\n";
	echo "<th>วันที่แจ้ง</th>\n";
	echo "<th>วิธีแก้ปัญหา</th>\n";
	echo "<th>แล้วเสร็จวันที่</th>\n";
	echo "<th>ประเมิน</th>\n";
	echo "</tr>\n";
	$i=1;
	echo "<tbody>\n";
	if(!isset($data["message"])){
	foreach ($data as $row) {
		
				echo "<tr>\n";
				echo "<td>".$i++."</td>\n";
				echo "<td><div style=\"min-height:100px;overflow:scroll\">".$row["IssueDetail"]."</div></td>\n";
				echo "<td width='150px' align='center'>".$row["CreateDate"]."</td>\n";
				echo "<td><div style=\"min-height:100px;overflow:scroll\">".$row["FixProblem"]."</div></td>\n";		
				echo "<td width='150px' align='center'>".$row["FixDate"]."</td>\n";
				$strLink="<button type='button' class='btn btn-info'
				onclick=\"evaluateRequest(".$row["id"].")\" >
				<span class='glyphicon glyphicon glyphicon-stats'></span>
				</button>";
				echo "<td>".$strLink."</td>\n";
				echo "</tr>\n";
		
	}
	echo "</tbody>\n";
	echo "</table>\n";

}

?>
<div>

<div class="modal fade" id="modal-input">
     <div class="modal-dialog" id="dvInput" style="width:500px" >
      <div class="modal-content">
          <div class="box-header with-border">
                <button type="button" class="close"  aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ประเมินความพึงพอใจ</h4>
           </div>
           <div class="modal-body" id="dvInputBody">
                
           </div>
          <div>
                 <div class="modal-footer">
                    <input type="button" id="btnClose" value="ปิด"   class="btn btn-default pull-left" >
                    <input type="button" id="btnSaveEvaluate" value="บันทึก"   class="btn btn-primary" >
                  </div>
          </div>
      </div>
     </div>
   </div>

<script>

	function loadEvaluate(){
		var url="<?=$rootPath?>/tissue/evaluate.php";
		$("#dvInputBody").load(url);
	}
	function evaluateRequest(issueId){
		$("#obj_issueId").val(issueId);
		$("#modal-input").modal("toggle");
	}

	function getmustEvaluate(){
      var url="<?=$rootPath?>/tissue/getCountCompleteByUser.php";
      var data=queryData(url);
      return data.flag;
  }

 function showEvaluate(){
     if(getmustEvaluate()===true){
            //var url="<?=$rootPath?>/tissue/displayCompleteWorkByUser.php";
            //$("#dvMain").load(url);
           
             //var url="<?=$rootPath?>/tissue/displayCompleteWorkByUser.php";
            //$("#dvMain").load(url);
      }
      else
      {
      	     $(location).attr('href','index.php');

      }
  }


	

	function saveEvaluate(){
		var url="<?=$rootPath?>/tissue/updateEvaluate.php?id="+$("#obj_issueId").val()+"&evaluateLevel="+$("#obj_evaluate").val()+"&evaluateMessage="+$("#obj_message").val();
		var flag=executeGet(url);
		showEvaluate();
	}

	$(document).ready(function(){
		 loadEvaluate();
		 $("#btnClose").click(function(){
		 	$("#modal-input").modal("hide");
		 	
		 });

		  $("#btnSaveEvaluate").click(function(){
		    $("#modal-input").modal("hide");
		  	saveEvaluate();
		  	createEvaluation();
		 });

		  $(".close").click(function(){
		 	$("#modal-input").modal("hide");
		 });
	});
</script>

