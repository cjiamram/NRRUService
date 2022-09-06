<?php
      include_once '../config/database.php';
      include_once '../config/config.php';
      include_once '../objects/classLabel.php';
      $cnf=new Config();
      $rootPath=$cnf->path;
      $database = new Database();
      $db = $database->getConnection();
      $objLbl=new ClassLabel($db);

?>
<link rel="stylesheet" href="<?=$rootPath?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="<?=$rootPath?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=$rootPath?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<input type="hidden" id="obj_id" value="">
<section class="content-header">
     <h1>
        <b>ระบบแจ้งซ่อมออนไลน์</b>

        <small>>><?php echo $objLbl->getLabel("t_issue","assignJob","th").":" ?></small>
      </h1>
      <ol class="breadcrumb">
        <input type="button" id="btnSearch"  class="btn btn-success pull-right"  value="ค้นหาข้นสูง">
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box"></div>
        <div class="form-group">
          <div class="col-sm-12">
             <div class="col-sm-6">
              
      
             </div>
             <div>
              <div  class="col-sm-4">
              </div>
          </div>
          </div>
        </div>

      <div>&nbsp;</div>
      <div class="col-sm-12">
      <div class="box box-warning">
      <div class="box-header with-border">
      <h3 class="box-title"><b><?php echo $objLbl->getLabel("t_issue","Request List","th").":" ?></b></h3>
      </div>
      <table id="tbJobRequest" class="table table-bordered table-hover">
      </table>
      </div>  
      </div>
        
    </section>


   <div class="modal fade" id="modal-input">
     <div class="modal-dialog" id="dvInput" style="width:800px" >
      <div class="modal-content">
          <div class="box-header with-border">
                <button type="button" class="close"  aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $objLbl->getLabel("t_issue","AssignJob","th").":" ?></h4>
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

     <div class="modal fade" id="modal-search">
        <div class="modal-dialog" id="dvSearch">
           <div class="modal-content">
            <div class="box-header with-border">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ค้นหาขั้นสูง</h4>
           </div>
           <div class="modal-body" id="dvAdvBody">
           
           </div>
          <div>
                 <div class="modal-footer">
                    <input type="button" id="btnAdvClose" value="ปิด"  class="btn btn-default pull-left" data-dismiss="modal" >
                    <input type="button" id="btnAdvSearch" value="ค้นหา"  class="btn btn-primary" data-dismiss="modal">
                  </div>
           </div>
        </div>
     </div>
   </div>
<script>

 function displayData(){
 
    var url="<?=$rootPath?>/tissue/displayRequestByStatus.php?status=01";
    $("#tbJobRequest").load(url);
 }


 function displayAdvanceData(){
 
    var url="<?=$rootPath?>/tissue/displayRequestByStatus.php?status=01&keyWord="+$("#obj_keyWord").val()+"&issueType="+$("#obj_issueType").val()+"&requestDate="+$("#obj_requestDate").val()+"&isSearch=true";
    $("#tbJobRequest").load(url);
 }

 function receiveJob(id){
    var url="<?=$rootPath?>/tassign/assignJob.php?issueId="+id;
    $("#dvInputBody").load(url);
    $("#modal-input").modal("toggle");
    $("#obj_id").val(id);
    loadIssue();
 }

 function listStaff(){
    var url ="<?=$rootPath?>/tstaff/listStaff.php";
     setDDLPrefix(url,"#obj_receiveBy","***ผู้มอบหมายหลัก***");
 }


 function loadAssign(){   
   
   var url="<?=$rootPath?>/tassign/trackingAssign.php";
   $("#dvInputBody").load(url);

 }

 function showAssign(){
    $('#modal-input').modal('toggle');
 }



 function listStatus(){
    var url="<?=$rootPath?>/tstatus/getData.php";
    setDDLPrefix(url,"#obj_status","***Status***");
 }

 function listReceiveStatus(){
    var url="<?=$rootPath?>/tstatus/listNextStatus.php";
    setDDLPrefix(url,"#obj_receiveStatus","***Status***");
 }


  function loadIssue(){
   var url="<?=$rootPath?>/tissue/readOneDetail.php?id="+$("#obj_id").val();
   var data=queryData(url);
   if(data!==""){
      $("#obj_notifyBy").val(data.notifyBy);
      $("#obj_IssueDetail").html(data.issueDetail);
      $("#obj_requestDate").val(data.createDate);
   }
 }



//**********Project Assign Module************

//**********************

 $( document ).ready(function() {
    displayData();
    $("#obj_status").change(function(){
        $("#modal-input").modal("toggle");
        displayData();
    });

    $("#btnClose").click(function(){
        $("#modal-input").modal("hide");
    });

    $(".close").click(function(){
      $("#modal-input").modal("hide");
    });

    $("#btnSearch").click(function(){
        $("#modal-search").modal("toggle");
        var url=rootPath+"/tissue/searchRequest.php";
        $("#dvAdvBody").load(url);

    });

    $("#btnAdvSearch").click(function(){
        displayAdvanceData();
    });


    $("#btnSave").click(function(){
        saveAssign();
    });
 });

</script>
