<?php
	include_once "../config/config.php";
	$cnf=new Config();
	$rootPath=$cnf->path;

?>
<script src="<?=$rootPath?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=$rootPath?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<input type="hidden" id="obj_issueId">
<section class="content container-fluid">
	<div>&nbsp;</div>
      <div class="col-sm-12">
      <div class="box box-warning">
      <div class="box-header with-border">
      <h3 class="box-title"><b>รายการงานที่เสร็จสิ้น</b></h3>
      </div>
   
      <div id="dvCompleteJob">
      </div>
      </div>  
      </div>
</section>

 <div class="modal fade" id="modal-input">
     <div class="modal-dialog" id="dvInput" style="width:800px" >
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
                    <input type="button" id="btnSave" value="บันทึก"   class="btn btn-primary" >
                  </div>
          </div>
      </div>
     </div>
   </div>

<script>
	
	function loadEvaluate(){
		var url="<?=$rootPath?>/tissue/evaluate.php";
		$("#dvInput").load(url);
	}

	function displayData(){
		var url="<?=rootPath?>/tissue/displayCompletByUser.php";
		$("#dvCompleteJob").load(url);
	}

	

	$(document).ready(function(){
		displayData();
	});
</script>
