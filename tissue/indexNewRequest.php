<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: html/text; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/classLabel.php";
include_once "../config/config.php";
include_once "../lib/classAPI.php";

$database = new Database();
$db = $database->getConnection();
$objLbl = new ClassLabel($db);
$cnf=new Config();
$rootPath=$cnf->path;
$userCode=isset($_SESSION["UserCode"])?$_SESSION["UserCode"]:"Admin";



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
<section class="content-header">
     <h1>
        <b>ระบบแจ้งซ่อมออนไลน์</b>

        <small>>>แจ้งซ่อม</small>
      </h1>
      </h1>
   
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
      <div class="col-sm-12">
      <div class="box box-warning">
      <div class="box-header with-border">
      <h3 class="box-title"><b>
        <?php echo $objLbl->getLabel("t_issue","Request","th").":" ?>
      </b></h3>
      </div>
      <div id="dvRequest">
          <form role='form'>
<div class="box-body">
<div class="col-sm-4">

    
    <div class='form-group'>
      <label class="col-sm-12"><?php echo $objLbl->getLabel("t_issue","building","th").":" ?>/<?php echo $objLbl->getLabel("t_issue","floorNo","th").":" ?>/<?php echo $objLbl->getLabel("t_issue","roomNo","th").":" ?></label>
      <div class="col-sm-12">
        
        <table width="100%">
        <tr>
        <td width="39%">
          <select class="form-control" id="obj_building"></select>
        </td>
        <td>-
        </td>
        <td >
          <input type="text" 
              class="form-control" id='obj_floorNo' 
              placeholder='floorNo'>
        </td>
        <td>-
        </td>
        <td width="39%">
          <input type="text" 
              class="form-control" id='obj_roomNo' 
              placeholder='roomNo'>
        </td>
        </tr> 
        </table>
      </div>
    </div>
    
    <div class='form-group'>
      <label class="col-sm-12"><?php echo $objLbl->getLabel("t_issue","telNo","th").":" ?>/<?php echo $objLbl->getLabel("t_issue","lineNo","th").":" ?></label>
      <div class="col-sm-12">
        
        <table width="100%">
        <tr>
        <td>
          <input type="text" 
              class="form-control" id='obj_telNo' 
              placeholder='telNo'>
        </td>
        <td>-
        </td>
        <td>
          <input type="text" 
              class="form-control" id='obj_lineNo' 
              placeholder='lineNo'>
        </td>
        </tr>
        </table>
      </div>
    </div>
    
    <div class='form-group'>
      <label class="col-sm-12"><?php echo $objLbl->getLabel("t_issue","createDate","th").":" ?></label>
      <div class="col-sm-12">
        <div class="input-group date">
        <div class="input-group-addon">
        <i class="fa fa-calendar"></i>
        </div>
        <input type="date" class="form-control" id="obj_createDate" value="<?=date('Y-m-d')?>">
        </div>
      </div>
    </div>
    <div class='form-group'>
      <label class="col-sm-12"><?php echo $objLbl->getLabel("t_issue","issueType","th").":" ?></label>
      <div class="col-sm-12">

        <select class="form-control" id="obj_issueType">
        </select>
      </div>
    </div>
    <div class='form-group'>
      <label class="col-sm-12"><?php echo $objLbl->getLabel("t_issue","issueDetail","th").":" ?></label>
      <div class="col-sm-12">
        <div id='dvIssueDetail'>
        <textarea class="form-control"
        rows="4" cols="100" 
         id='obj_issueDetail' ></textarea>
        </div>
      </div>
    </div>
    <div class='form-group'>
      <label class="col-sm-12"><?php echo $objLbl->getLabel("t_issue","notifyBy","th").":" ?></label>
      <div class="col-sm-12">
        <input type="text" 
              class="form-control" id='obj_notifyBy' 
              value='<?php echo $_SESSION["FullName"]; ?>'>
      </div>
    </div>
    <div class='form-group'><div class="col-sm-12"><hr></div></div>
      <div class='form-group'>
        <div class="col-sm-12">
            <input type="button" id="btnSaveIssue" value="บันทึก"  class="btn btn-success">
            <input type="button" id="btnNew" value="เพิ่ม"  class="btn btn-primary">
        </div> 
    </div>
  

</div>
<div class="col-sm-8">
  <table id="tbStaffRequest" class="table table-bordered table-hover">
    
  </table>

</div>
</div>
</form>

      </div>
       
      </div>  
      </div>
        
    </section>



   <div class="modal fade" id="modal-inprogress">
     <div class="modal-dialog" style="width:900px"  >
      <div class="modal-content">
          <div class="box-header with-border">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ติดตามสถานะการดำเนินงาน</h4>
           </div>
           <div class="modal-body" id="dvInprogress">
           
           </div>
          <div>
                 <div class="modal-footer">
                    <input type="button" id="btnCloseInprogress" value="ปิด"  class="btn btn-default pull-left" data-dismiss="modal">
                  </div>
          </div>
      </div>
     </div>
   </div>

    

<iframe id="frmCapture" style="width:1px;height:1px"></iframe>
<script>

 function setTextEditor(obj){
    //'#obj_issueDetail'
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
            heightMin: 300,
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




  function listBuilding(){
    var url="<?=$rootPath?>/tbuilding/listBuilding.php";
    setDDLPrefix(url,"#obj_building","***Building***");
  }

  function listIssueType(){
    var url="<?=$rootPath?>/tissuetype/getData.php";
    setDDLPrefix(url,"#obj_issueType","***Type***");
  }

  function displayIssue(){
    var url="<?=$rootPath?>/tissue/displayDataByStaff.php?userCode=<?=$userCode?>";
    $("#tbStaffRequest").load(url);
  }

  function getLastId(){
    var url ="<?=$rootPath?>/tissue/getLastId.php";
    var data=queryData(url);
    return data.id;
  }

  function sendNotify(id){
        //sendStream(id);
        url="<?=$rootPath ?>/lineBot/notifyWithPicture.php?id="+id;
        executeData(url,jsonObj,false);
  }

  function sendStream(id){
    var url="<?=$rootPath?>/tissue/capture2Img.php?id="+id;
    $('#frmCapture').attr('src', url)
  }

  

  function createIssue(){
    var url='<?=$rootPath?>/tissue/create.php';
    jsonObj={
      roomNo:$("#obj_roomNo").val(),
      floorNo:$("#obj_floorNo").val(),
      building:$("#obj_building").val(),
      telNo:$("#obj_telNo").val(),
      lineNo:$("#obj_lineNo").val(),
      createDate:$("#obj_createDate").val(),
      issueType:$("#obj_issueType").val(),
      issueDetail:$("#obj_issueDetail").val(),
      notifyBy:$("#obj_notifyBy").val(),
      status:'01'
    }
    var jsonData=JSON.stringify (jsonObj);
    console.log(jsonData);
    var flag=executeData(url,jsonObj,false);
    var id= getLastId();
    sendNotify(id);
    return flag;
  } 


  function updateIssue(){
    var url='<?=$rootPath?>/tissue/update.php';
    jsonObj={
      roomNo:$("#obj_roomNo").val(),
      floorNo:$("#obj_floorNo").val(),
      building:$("#obj_building").val(),
      telNo:$("#obj_telNo").val(),
      lineNo:$("#obj_lineNo").val(),
      createDate:$("#obj_createDate").val(),
      issueType:$("#obj_issueType").val(),
      issueDetail:$("#obj_issueDetail").val(),
      notifyBy:$("#obj_notifyBy").val(),
      id:$("#obj_id").val()
    }
    var jsonData=JSON.stringify (jsonObj);

    var flag=executeData(url,jsonObj,false);
    sendNotify($("#obj_id").val());
    return flag;
  }

  function validIssue(){
    var flag=true;
    flag=regDate.test($("#obj_createDate").val());
    if (flag==false){
        $("#obj_createDate").focus();
        return flag;
    }
    return flag;
  }

  function clearIssue(){

      $("#obj_id").val("");
      $("#obj_roomNo").val("");
      $("#obj_floorNo").val("");
      $("#obj_building").val("");
      $("#obj_telNo").val("");
      $("#obj_lineNo").val("");
      $("#obj_issueType").val("");
      $("#obj_issueDetail").val("");
      $("#obj_notifyBy").val("");
  }

  function saveIssue(){
    var flag;
    flag=true;
    if(flag==true){
      if($("#obj_id").val()!=""){
      flag=updateIssue();
      }else{
      flag=createIssue();
    }
    if(flag==true){
      swal.fire({
      title: "การบันทึกข้อมูลเสร็จสมบูรณ์แล้ว",
      type: "success",
      buttons: [false, "ปิด"],
      dangerMode: true,
    }).then((result) => {
      displayIssue();
      clearIssue();
    });
      
     //loadInput();
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

function getIssueDetail(id){
  var url="<?=$rootPath?>/tissue/getIssueDetail.php?id="+id;
  $("#dvIssueDetail").load(url);
}

function readOneIssue(id){
    var url='<?=$rootPath?>/tissue/readOne.php?id='+id;
    data=queryData(url);
    if(data!=""){
      $("#obj_roomNo").val(data.roomNo);
      $("#obj_floorNo").val(data.floorNo);
      $("#obj_building").val(data.building);
      $("#obj_telNo").val(data.telNo);
      $("#obj_lineNo").val(data.lineNo);
      $("#obj_createDate").val(data.createDate);
      $("#obj_issueType").val(data.issueType);
      $("#obj_issueDetail").val(data.issueDetail);
      $("#obj_notifyBy").val(data.notifyBy);
      $("#obj_id").val(data.id);
      getIssueDetail(data.id);
    }
  }
function confirmDelete(id){
    swal.fire({
      title: "คุณต้องการที่จะลบข้อมูลนี้หรือไม่?",
      text: "***กรุณาตรวจสอบข้อมูลให้ครบถ้วนก่อนกดปุ่มตกลง",
      type: "warning",
      confirmButtonText: "ตกลง",
      cancelButtonText: "ยกเลิก",
      showCancelButton: true,
      showConfirmButton: true
    }).then((willDelete) => {
    if (willDelete.value) {
      url="tissue/delete.php?id="+id;
      executeGet(url,false,"");
      displayIssue();
    swal.fire({
      title: "ลบข้อมูลเรียบร้อยแล้ว",
      type: "success",
      buttons: "ตกลง",
    });
    } else {
      
    }
    });
  } 
  

  
function clearData(){
      $("#obj_id").val("");
      $("#obj_roomNo").val("");
      $("#obj_floorNo").val("");
      $("#obj_building").val("");
      $("#obj_telNo").val("");
      $("#obj_lineNo").val("");
      $("#obj_createDate").val("");
      $("#obj_issueType").val("");
      $("#obj_issueDetail").val("");
      getIssueDetail(0);
  }

  
   function getmustEvaluate(){
      var url="<?=$rootPath?>/tissue/getCountCompleteByUser.php";
      var data=queryData(url);
      return data.flag;
  }

 function showEvaluate(){
     if(getmustEvaluate()===true){
             swal.fire({
                text: "คุณต้องการทำการประเมินความพึงพแใจการบริการงานที่สำเร็จแล้วเสียก่อน",
                title: "Message Alert",
                type: "warning",
               
              })
            var url="<?=$rootPath?>/tissue/displayCompleteWorkByUser.php";
            $("#dvMain").load(url);
      }
  }


  function displayInprogress(issueId){
    $("#modal-inprogress").modal("toggle");
    var url="<?=$rootPath?>/tissue/displayInprogress.php?issueId="+issueId;
    console.log(url);
    $("#dvInprogress").load(url);
   
  }


 

  $(document).ready(function(){
    showEvaluate();
    listBuilding();
    listIssueType();
    setTextEditor("#obj_issueDetail");

    displayIssue();

    $("#btnSaveIssue").click(function(){
      saveIssue();
    });

    $(".close").click(function(){
      $("#modal-inprogress").modal("hide");
    });

    $("#btnCloseInprogress").click(function(){
      $("#modal-inprogress").modal("hide");
    });

    $("#btnNew").click(function(){
      clearData();
    });

    
  });


</script>
