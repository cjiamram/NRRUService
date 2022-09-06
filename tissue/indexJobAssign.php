<?php
      session_start();

      include_once '../config/database.php';
      include_once '../config/config.php';
      include_once '../objects/classLabel.php';
      $cnf=new Config();
      $rootPath=$cnf->path;
      $database = new Database();
      $db = $database->getConnection();
      $objLbl=new ClassLabel($db);
      $userCode=isset($_SESSION["UserName"])?$_SESSION["UserName"]:"";

?>
  <link rel="stylesheet" href="/NRRUServiceOnline/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?=$rootPath?>/css/froala_editor.css">
  <link rel="stylesheet" href="<?=$rootPath?>/css/froala_style.css">
  <link rel="stylesheet" href="<?=$rootPath?>/css/plugins/code_view.css">
  <link rel="stylesheet" href="<?=$rootPath?>/css/plugins/draggable.css">
  <link rel="stylesheet" href="<?=$rootPath?>/css/plugins/colors.css">
  <link rel="stylesheet" href="<?=$rootPath?>/css/plugins/emoticons.css">
  <link rel="stylesheet" href="<?=$rootPath?>/css/plugins/image_manager.css">
  <link rel="stylesheet" href="<?=$rootPath?>/css/plugins/image.css">
  <link rel="stylesheet" href="<?=$rootPath?>/css/plugins/line_breaker.css">
  <link rel="stylesheet" href="<?=$rootPath?>/css/plugins/table.css">
  <link rel="stylesheet" href="<?=$rootPath?>/css/plugins/char_counter.css">
  <link rel="stylesheet" href="<?=$rootPath?>/css/plugins/video.css">
  <link rel="stylesheet" href="<?=$rootPath?>/css/plugins/fullscreen.css">
  <link rel="stylesheet" href="<?=$rootPath?>/css/plugins/file.css">
  <link rel="stylesheet" href="<?=$rootPath?>/css/plugins/quick_insert.css">
  <link rel="stylesheet" href="<?=$rootPath?>/css/plugins/help.css">
  <link rel="stylesheet" href="<?=$rootPath?>/css/third_party/spell_checker.css">
  <link rel="stylesheet" href="<?=$rootPath?>/css/plugins/special_characters.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">

  <script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
  <script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>

  <script type="text/javascript" src="<?=$rootPath?>/js/froala_editor.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/plugins/align.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/plugins/char_counter.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/plugins/code_beautifier.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/plugins/code_view.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/plugins/colors.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/plugins/draggable.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/plugins/emoticons.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/plugins/entities.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/plugins/file.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/plugins/font_size.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/plugins/font_family.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/plugins/fullscreen.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/plugins/image.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/plugins/image_manager.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/plugins/line_breaker.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/plugins/inline_style.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/plugins/link.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/plugins/lists.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/plugins/paragraph_format.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/plugins/paragraph_style.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/plugins/quick_insert.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/plugins/quote.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/plugins/table.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/plugins/save.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/plugins/url.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/plugins/video.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/plugins/help.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/plugins/print.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/third_party/spell_checker.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/plugins/special_characters.min.js"></script>
  <script type="text/javascript" src="<?=$rootPath?>/js/plugins/word_paste.min.js"></script>

  <script src="<?=$rootPath?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="<?=$rootPath?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>


<input type="hidden" id="obj_id" value="">
<input type="hidden" id="obj_statusCheck" value="">
<input type="hidden" id="obj_assignId" value="">
<section class="content-header">
     <h1>
        <b>ระบบแจ้งซ่อมออนไลน์</b>

        <small>>><?php echo $objLbl->getLabel("t_issue","lookAssignJob","th").":" ?></small>
      </h1>
      <ol class="breadcrumb">
   
        <table width="40%" cellspacing="2" cellpading="2">
          <tr>
           
            <td align="center">
                <!--<input type="button" id="btnSearch"  class="btn btn-success col-sm-12" data-toggle="modal" data-target="#modal-search" value="ค้นหาข้นสูง">-->
             </td>
          </tr>
        </table>

      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box"></div>
        <div class="form-group">
          <div class="col-sm-12">
             <div class="col-sm-6">
              
                <table width="100%">
                  <tr>
                    <td width="150px">
                      <label>
                        <?php echo $objLbl->getLabel("t_issue","status","th").":" ?>
                      </label>
                    </td>
                    <td>
                      <select class="form-control"
                      id="obj_status"
                      ></select>
                    </td>
                  </tr>
                </table>

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
     <div class="modal-dialog" id="dvInput" style="max-width:900px" >
      <div class="modal-content">
          <div class="box-header with-border">
                <button type="button" class="close"  aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $objLbl->getLabel("t_issue","Tracking","th").":" ?></h4>
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



   <div class="modal fade" id="modal-transfer">
     <div class="modal-dialog" id="dvInput" style="max-width:900px" >
      <div class="modal-content">
          <div class="box-header with-border">
                <button type="button" class="close"  aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $objLbl->getLabel("t_assign","TransferJob","th").":" ?></h4>
           </div>
           <div class="modal-body" id="dvTransferBody">
                
           </div>
          <div>
                 <div class="modal-footer">
                    <input type="button" id="btnCloseTransfer" value="ปิด"   class="btn btn-default pull-left" >
                    <input type="button" id="btnSaveTransfer" value="บันทึก"   class="btn btn-primary" >
                  </div>
          </div>
      </div>
     </div>
   </div>

   
   </div>
<script src="<?=$rootPath?>/tissue/jsExecute.js"></script>
<script>

var userCode='<?=$userCode?>';
function setTextEditor(obj){

    editor=new FroalaEditor(obj, {
      key: "1C%kZV[IX)_SL}UJHAEFZMUJOYGYQE[\\ZJ]RAe(+%$==",
      attribution: false, // to hide "Powered by Froala"
      toolbarButtons: {
          moreText: {
          // List of buttons used in the  group.
          buttons: ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle', 'clearFormatting'],

          // Alignment of the group in the toolbar.
          align: 'left',

          // By default, 3 buttons are shown in the main toolbar. The rest of them are available when using the more button.
          buttonsVisible: 3
          },

          moreParagraph: {
          buttons: ['alignLeft', 'alignCenter', 'formatOLSimple', 'alignRight', 'alignJustify', 'formatOL', 'formatUL', 'paragraphFormat', 'paragraphStyle', 'lineHeight', 'outdent', 'indent', 'quote'],
          align: 'left',
          buttonsVisible: 3
          },

          moreRich: {
          buttons: ['insertLink', 'insertImage', 'insertVideo', 'insertTable', 'emoticons', 'fontAwesome', 'specialCharacters', 'embedly', 'insertFile', 'insertHR'],
          align: 'left',
          buttonsVisible: 3
          },

        moreMisc: {
            buttons: ['undo', 'redo', 'fullscreen', 'print', 'getPDF', 'spellChecker', 'selectAll', 'html', 'help'],
            align: 'right',
            buttonsVisible: 2
        }
      },

  
      pastePlain: true,
            language: 'th',
            heightMin: 150,
            heightMax: 500,
            imageUploadURL:"./froala_upload_image.php",
            imageUploadParam:"fileName",
            imageManagerLoadMethod:"GET",
            imageManagerDeleteMethod:"POST",
            // video
            videoUploadURL: './froala_upload_video.php',
            videoUploadParam: 'fileName',
            videoUploadMethod: 'POST',
            videoMaxSize: 50 * 1024 * 1024,
            videoAllowedTypes: ['mp4', 'webm', 'jpg', 'ogg'],
   //file 
            fileUploadURL: './froala_upload_file.php',
            fileUploadParam: 'fileName',
            fileUploadMethod: 'POST',
            fileMaxSize: 20 * 1024 * 1024,
            fileAllowedTypes: ['*'],
  });
  } 

 function displayData(){
    var url="<?=$rootPath?>/tissue/displayDataBySupport.php?userCode="+userCode+"&status="+$("#obj_status").val();
    $("#tbJobRequest").load(url);
 }



 function listStaff(){
    var url ="<?=$rootPath?>/tstaff/listStaff.php";
     setDDLPrefix(url,"#obj_assignTo","***Assign To***");
 }


 function loadAssign(){   
   var url="<?=$rootPath?>/tassign/trackingRecord.php";
   $("#dvInputBody").load(url);
   $("#obj_receiveStatus").val("02");


 }

 function getJobAssign(issueId){
    $("#dvInput").css("max-width", "700px");
    var url="<?=$rootPath?>/tassign/trackingRecord.php";
    $("#dvInputBody").load(url);
    $("#modal-input").modal("toggle");
    $("#obj_id").val(issueId);
    $("#obj_statusCheck").val("1");
 }

function getJobTracking(issueId){
    $("#dvInput").css("width", "max-width");
    var url="<?=$rootPath?>/tissuetracking/inputProgress.php";
    $("#dvInputBody").load(url);
    $("#modal-input").modal("toggle");
    $("#obj_id").val(issueId);
    $("#obj_statusCheck").val("2");
    displayProgress();
 }


  function displayProgress(){
    var url ="<?=$rootPath?>/tissuetracking/displayData.php?issueId="+$("#obj_id").val();
    $("#tbIssueDisplay").load(url);
  }

  function loadIssueDetail(){
   var url="<?=$rootPath?>/tissue/readOneDetail.php?id="+$("#obj_id").val();
   var data=queryData(url);
   if(data!==""){
      $("#obj_notifyBy").val(data.notifyBy);
      $("#obj_issueDetail").html(data.issueDetail);
      $("#obj_requestDate").val(data.createDate);
   }
 }


  function loadIssueDetailAssign(){
   var url="<?=$rootPath?>/tissue/readOneDetail.php?id="+$("#obj_id").val();
   var data=queryData(url);
   if(data!==""){
      $("#obj_notifyBy_1").val(data.notifyBy);
      $("#obj_Detail_1").html(data.issueDetail);
      $("#obj_requestDate_1").val(data.createDate);
   }
 }

 function listStatus(){
    var url="<?=$rootPath?>/tstatus/listNextStatus.php";
    setDDLPrefix(url,"#obj_status","***Status***");
 }

 function listProgressStatus(){
    var url="<?=$rootPath?>/tstatus/listProgressStatus.php";
    setDDLPrefix(url,"#obj_progressStatus","***Status***");
 }

 function listReceiveStatus(){
    var url="<?=$rootPath?>/tstatus/listThirdStatus.php";
    setDDLPrefix(url,"#obj_receiveStatus","***Status***");
 }


//**********Project Assign Module************

function checkAssign(){
    if($("#obj_receiveStatus").val()=="06"){
        $("#dvTransfer").attr("style","display:block");
    }else{
      $("#dvTransfer").attr("style","display:none");
    }
}


function updateStatusAssignStaff(userCode,issueId){
  var url="<?=$rootPath?>/tassignstaff/updateStatus.php?userCode="+userCode+"&issueId="+issueId+"&status=03";
  //console.log(url);
  var flag=executeGet(url);
  return flag;
}

function updateJobAssign(){
    var url='<?=$rootPath?>/tassign/updateTracking.php';
    jsonObj={
      issueId:$("#obj_id").val(),
      fixProblem:$("#obj_fixProblem").val(),
      realStartDate:$("#obj_realStartDate").val(),
      realEndDate:$("#obj_realEndDate").val(),
      assignTo:$("#obj_assignTo").val(),
      status:$("#obj_receiveStatus").val(),
      serviceCharge:$("#obj_serviceCharge").val(),
      materialCharge:$("#obj_materialCharge").val(),

    }
    var jsonData=JSON.stringify (jsonObj);
    var flag=executeData(url,jsonObj,false);
    updateStatusAssignStaff('<?=$userCode?>',$("#obj_id").val());
    return flag;
}

function updateStatus(status){
  var url ="<?=$rootPath?>/tissue/updateStatus.php?id="+$("#obj_id").val()+"&status="+status;
  executeGet(url);
}

function updateStatusByAssign(){
    var url ="<?=$rootPath?>/tissue/updateStatusByAssign.php?issueId="+$("#obj_id").val();
    var flag= executeGet(url);
    return flag;
}

function insertTrackingAssign(status,progress){
    var url='<?=$rootPath?>/tissuetracking/create.php';
      jsonObj={
        issueId:$("#obj_id").val(),
        staffCode:userCode,
        detail:$("#obj_fixProblem").val(),
        status:status,
        operatingDate:$("#obj_realStartDate").val(),
        progress:progress
      }
      var jsonData=JSON.stringify (jsonObj);
      var flag=executeData(url,jsonObj,false);
      updateStaffProgress($("#obj_id").val(),userCode,status);

      return flag;
}

function saveAssign(){
    
    if($("#obj_receiveStatus").val()===""){
        swal.fire({
              title: "กรุณากำหนดสถานะการรับงาน",
              type: "error",
              buttons: [false, "ปิด"],
              dangerMode: true,
            });
        return ;
    }

    var flag;
    flag=true;
    if(flag==true){
       
        flag=updateJobAssign();
        updateStatusByAssign();

        if($("#obj_receiveStatus").val()==="03"){
            insertTrackingAssign($("#obj_receiveStatus").val(),10);
        }else
        if($("#obj_receiveStatus").val()==="04"){
           insertTrackingAssign($("#obj_receiveStatus").val(),100);
        }
        

        if(flag==true){
              swal.fire({
              title: "การบันทึกข้อมูลเสร็จสมบูรณ์แล้ว",
              type: "success",
              buttons: [false, "ปิด"],
              dangerMode: true,
            });
            displayData();
        }
        else{
                swal.fire({
                title: "การบันทึกข้อมูลผิดพลาด",
                type: "error",
                buttons: [false, "ปิด"],
                dangerMode: true,
            });
          }
        }else{
              swal.fire({
              title: "รูปแบบการกรอกข้อมูลไม่ถูกต้อง",
              type: "error",
              buttons: [false, "ปิด"],
              dangerMode: true,
          });
        }
}

//**********************
function saveProgressTracking(){
    
    if($("#obj_progress").val()===""){
           swal.fire({
          title: "กรุณาระบุ % การดำเนินการ 1-100%",
          type: "error",
          buttons: [false, "ปิด"],
          dangerMode: true,
        });
        return;
    }

    var flag;
    flag=true;
    if(flag==true){

          flag=createProgress();
          updateStatusByAssign();


    if(flag==true){
      swal.fire({
      title: "การบันทึกข้อมูลเสร็จสมบูรณ์แล้ว",
      type: "success",
      buttons: [false, "ปิด"],
      dangerMode: true,
    });
    displayProgress();
    }
    else{
      swal.fire({
      title: "การบันทึกข้อมูลผิดพลาด",
      type: "error",
      buttons: [false, "ปิด"],
      dangerMode: true,
    });
    }
    }else{
      swal.fire({
      title: "รูปแบบการกรอกข้อมูลไม่ถูกต้อง",
      type: "error",
      buttons: [false, "ปิด"],
      dangerMode: true,
      });
      }
}

//**************Transfer Job**********************
function setTranser(id){
  $("#obj_id").val(id);
  $("#modal-transfer").modal("toggle");
}

function listAssignStaff(){
     var url ="<?=$rootPath?>/tstaff/listStaff.php";
     setDDLPrefix(url,"#obj_assignPerson","***Assign To***");
 }

 function loadTransfer(){
     //var url="<?=$rootPath?>/tassign/transferJob.php";
      var url="<?=$rootPath?>/tassign/assignTransfer.php";
     $("#dvTransferBody").load(url);
 }

 function updateTransfered(){
     var url="<?=$rootPath?>/tassign/transferTo.php";
     var jsonObj={
      "issueId":$("#obj_id").val(),
      "assignTo":$("#obj_assignPerson").val(),
      "message":$("#obj_message").val()
     }
     var jsonData=JSON.stringify (jsonObj);

     var flag=executeData(url,jsonObj,false);
     return flag;
 }

 function transferTo(){
    var userCode='<?=$userCode?>';

    var jsonObj={
      "issueId":$("#obj_id").val(),
      "transferFrom":userCode,
      "transferTo":$("#obj_assignPerson").val()
    }
    var jsonData=JSON.stringify (jsonObj);
    var url="<?=$rootPath?>/tassign/transferTo.php";
    var flag=executeData(url,jsonObj,false);
    return flag;
 }

//************************************************
 $( document ).ready(function() {
    listStatus();
    displayData();
    loadTransfer();
    
    $("#obj_receiveStatus").change(function(){
        checkAssign();
    });

    $("#obj_status").change(function(){
        displayData();
    });

    $("#btnClose").click(function(){
        $('#modal-input').modal('hide');
    });

     $(".close").click(function(){
        $('#modal-input').modal('hide');
        $("#modal-transfer").modal("hide");
    });

    $("#btnSaveTransfer").click(function(){
        //var flag=transferTo();
        var flag=true;
        flag= updateTransfered();
        flag &=saveAssignIteration(); 
        if(flag==true){
              swal.fire({
              title: "การโอนงานเรียบร้อยแล้ว",
              type: "success",
              buttons: [false, "ปิด"],
              dangerMode: true,});
        }else{
              swal.fire({
              title: "การโอนงานผิดพลาด",
              type: "error",
              buttons: [false, "ปิด"],
              dangerMode: true,});
        }
        $('#modal-transfer').modal('hide');
    });

    $("#btnSave").click(function(){
      $('#modal-input').modal('hide');
      if($("#obj_statusCheck").val()==="1"){
        saveAssign();
      }
     if($("#obj_statusCheck").val()==="2"){
        saveProgressTracking();
       
     }
      
    });
 });

</script>
