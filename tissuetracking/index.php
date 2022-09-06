<?php
      include_once '../config/database.php';
      include_once '../config/config.php';
      include_once '../objects/classLabel.php';
      $cnf=new Config();
      $tableName=isset($_GET["tableName"])?$_GET["tableName"]:"";
      $dbName=isset($_GET["dbName"])?$_GET["dbName"]:"";
      $tName=str_replace("_", "", $tableName);
      $path=$cnf->path."/".$tName;
      $database = new Database();
      $db = $database->getConnection();
      $objLbl=new ClassLabel($db);

?>
<input type="hidden" id="obj_id" value="">
<section class="content-header">
     <h1>
        <b>Module</b>

        <small>>>Sub Module</small>
      </h1>
      <ol class="breadcrumb">
   
        <table width="100%" cellspacing="2" cellpading="2">
          <tr>
            <td width="40%" align="center">
                <input type="button" id="btnInput"   class="btn btn-primary col-sm-12" data-toggle="modal" data-target="#modal-input" value="สร้าง">
            </td>
            <td width="60%" align="center">
                <input type="button" id="btnSearch"  class="btn btn-success col-sm-12" data-toggle="modal" data-target="#modal-search" value="ค้นหาข้นสูง">
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
               <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-search"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="txtSearch">
                </div>
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
      <h3 class="box-title"><b>Object List</b></h3>
      </div>
      <table id="tblDisplay" class="table table-bordered table-hover">
      </table>
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
                    <input type="button" id="btnSave" value="บันทึก"  class="btn btn-primary" data-dismiss="modal">
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
<script src="<?php echo $path ?>/jsExecute.js"></script>
<script>
 var path='<?php echo $path?>';
 var tableName='<?php echo $tableName; ?>';
 var dbName='<?php echo $dbName;?>';
 function loadInput(){
      var url=path+"/input.php";
      $("#dvInputBody").load(url);
 }

function displayData(){
 
    var url=path+"/displayData.php?tableName="+tableName+"&dbName="+dbName+"&keyWord="+$("#txtSearch").val();
    $("#tblDisplay").load(url);
 }

 function loadPage(){
    loadInput();
    displayData();
 }

 $( document ).ready(function() {
    loadPage();
    $("#btnInput").click(function(){
        clearData();
        $("#obj_code").val(genCode());
    });

    $("#txtSearch").change(function(){
        displayData();
    });

    $("#btnSave").click(function(){
        saveData();
    });
 });

</script>
