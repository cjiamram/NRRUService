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
      <table id="tbJobQuery" class="table table-bordered table-hover">
      </table>
      </div>  
      </div>
        
    </section>


   


<script>

 function displayData(){
 
    var url="<?=$rootPath?>/tissue/displayQueryByAdmin.php?keyWord="+$("#txtK");
    $("#tbJobRequest").load(url);
 }



</script>
