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


//print_r($_SESSION["UserCode"]);

?>
<link rel="stylesheet" href="/NRRUServiceOnline/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="/NRRUServiceOnline/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/NRRUServiceOnline/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

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
        <input type="date" class="form-control" id="obj_createDate">
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
        
        <textarea class="form-control"
        rows="4" cols="100" 
         id='obj_issueDetail' ></textarea>
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


   <div class="modal fade" id="modal-input">
     <div class="modal-dialog" id="dvInput" >
      <div class="modal-content">
          <div class="box-header with-border">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Input</h4>
           </div>
           <div class="modal-body" id="dvInputBody">
           
           </div>
          <div>
                 <div class="modal-footer">
                    <input type="button" id="btnClose" value="ปิด"  class="btn btn-default pull-left" data-dismiss="modal">
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
                <h4 class="modal-title">Advance Search</h4>
           </div>
           <div class="modal-body" id="dvAdvBody">
           
           </div>
          <div>
                 <div class="modal-footer">
                    <input type="button" id="btnAdvCose" value="ปิด"  class="btn btn-default pull-left" data-dismiss="modal">
                    <input type="button" id="btnAdvSearch" value="ค้นหา"  class="btn btn-primary" data-dismiss="modal">
                  </div>
           </div>
        </div>
     </div>
   </div>
<script>
function listBuilding(){
    var url="<?=$rootPath?>/tbuilding/listBuilding.php";
    setDDLPrefix(url,"#obj_building","***Building***");
  }

  function listIssueType(){
    var url="<?=$rootPath?>/tissuetype/getData.php";
    setDDLPrefix(url,"#obj_issueType","***Type***");
  }

  function displayIssue(){
   var url="<?=$rootPath?>/tissue/getDataByStaff.php?userCode=<?=$userCode?>";
   var data= queryData(url);
   console.log(data);


   // var url="<?=$rootPath?>/tissue/displayDataByStaff.php?userCode=<?=$userCode?>";
   // console.log(url);
    //$("#tbStaffRequest").load(url);
    //var url="<?=$rootPath?>/tissue/indexNewRequest.php";
    //$("#dvContent").load();
  }

  function getLastId(){
    var url ="<?=$rootPath?>/tissue/getLastId.php";
    var data=queryData(url);
    return data.id;
  }

  function sendNotify(id){
        var url="<?=$rootPath?>/tissue/displayIssueNotify.php?id="+id;
        var data=queryData(url);
        url="<?=$rootPath ?>/lineBot/sendNotify.php";
        var jsonObj={
          message:data.message
        }

        var jsonData=JSON.stringify(jsonObj);
        executeData(url,jsonObj,false);

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
    console.log(jsonData);

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

  function saveIssue(){
    var flag;
    //flag=validIssue();
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
    });
      displayIssue();
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
  }

  


 

  $(document).ready(function(){
    listBuilding();
    listIssueType();
    //tablePage("#tbStaffRequest");

    displayIssue();


    $("#btnSaveIssue").click(function(){
      saveIssue();
    });

    $("#btnNew").click(function(){
      clearData();
    });

    
  });


</script>
