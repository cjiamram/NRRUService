
   <?php
      header("content-type:text/html;charset=UTF-8");
      include_once "../config/config.php";
      $cnf=new Config();
      $rootPath=$cnf->path;
   ?>
<link rel="stylesheet" href="<?=$rootPath?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="<?=$rootPath?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=$rootPath?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>


    <section class="content">
    	 <div class="row">
    	 	<div class="col-lg-4 col-xs-6">
          <!-- small box -->
	          <div class="small-box bg-aqua">
	            <div class="inner">
	              <p>งานใหม่</p>
                  <h3><span id="obj_newWork"></span></h3>
	            </div>
	            <div class="icon">
	              <i class="ion-leaf"></i>
	            </div>
	            <a href="#" id="btnTaskInit" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
	          </div>
	        </div>

	      <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
             

              <p>กำลังดำเนินการ</p>
               <h3><span id="obj_progressWork"></span></h3>
            </div>
            <div class="icon">
              <i class="ion-ios-flame"></i>
            </div>
            <a href="#" id="btnTaskInprogress" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

         <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <p>งานสำเร็จแล้ว</p>
              <h3><span id="obj_completeWork"></span></h3>

              
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" id="btnTaskComplete" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


          <!--<div class="col-lg-3 col-xs-6">
          <div class="small-box bg-red">
            <div class="inner">
               <p>งานที่ไม่สามารถดำเนินการ</p>
              <h3><span id="obj_failWork"></span></h3>

             
            </div>
            <div class="icon">
              <i class="icon ion-alert-circled"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>-->
       </div>

      <div class="row">
         <div class="col-lg-6 col-xs-6" >
          <div id="dvRadar" style="background-color: white;height:550px; text-align: center;">
          </div>

         </div>
        <div class="col-lg-6 col-xs-6">
              <div id="dvBar" style="background-color: white;height:550px; text-align: center;">
              </div>
        </div>
      </div>
    </section>
     <div class="modal fade" id="modal-initialize">
        <div class="modal-dialog" style="width:1500px" >
           <div class="modal-content">
            <div class="box-header with-border">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">งานใหม่</h4>
           </div>
           <div class="modal-body" id="dvInit">
           
           </div>
          <div>
                 <!--<div class="modal-footer">
                    <input type="button" id="btnInitialClose" value="ปิด"  >
                  </div>-->
           </div>
        </div>
     </div>
   </div>

     <div class="modal fade" id="modal-inprogress">
        <div class="modal-dialog" style="width:1500px">
           <div class="modal-content">
            <div class="box-header with-border">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">งานที่แจ้ง</h4>
           </div>
           <div class="modal-body" id="dvInprogress">
           
           </div>
          <div>
           </div>
        </div>
     </div>
   </div>


    <div class="modal fade" id="modal-complete">
        <div class="modal-dialog" style="width:1500px">
           <div class="modal-content">
            <div class="box-header with-border">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">งานที่สำเร็จแล้ว</h4>
           </div>
           <div class="modal-body" id="dvComplete">
           
           </div>
          <div>
               
           </div>
        </div>
     </div>
   </div>



<script>

function setNewWork(){
   var url="<?=$rootPath?>/Dashboard/getNewWorkAll.php";
   var data=queryData(url);
   $("#obj_newWork").text(data.CNT);
}

function setProgressWork(){
   var url="<?=$rootPath?>/Dashboard/getProgressWorkAll.php";
   var data=queryData(url);
   $("#obj_progressWork").text(data.CNT);
}

function setCompleteWork(){
   var url="<?=$rootPath?>/Dashboard/getCompleteWorkAll.php";
   var data=queryData(url);
   $("#obj_completeWork").text(data.CNT);
}

function setFailWork(){
   var url="<?=$rootPath?>/Dashboard/getFailWorkAll.php";
   var data=queryData(url);
   $("#obj_failWork").text(data.CNT);
}

function setRadar(){
  var url="<?=$rootPath?>/Dashboard/radarSumaryByIssueType.php";

  $("#dvRadar").load(url);
}

function setPie(){
  var url="<?=$rootPath?>/Dashboard/pieSumaryByIssueType.php";

  $("#dvRadar").load(url);
}

function setBar(){
  var url="<?=$rootPath?>/Dashboard/barSumaryAsignment.php";
  $("#dvBar").load(url);
}

//pieEvaluation.php
function setPieEva(){
  var url="<?=$rootPath?>/Dashboard/pieEvaluation.php";
  $("#dvBar").load(url);
}




$(document).ready(function(){
  setNewWork();
  setProgressWork();
  setCompleteWork();
  setFailWork();
  setPie();
  setPieEva();

  $("#btnTaskInit").click(function(){
      $("#modal-initialize").modal("toggle");
      var url="<?=$rootPath?>/tissue/popupInitialize.php"; 
      $("#dvInit").load(url);
  });

   $("#btnTaskInprogress").click(function(){
      $("#modal-inprogress").modal("toggle");
      var url="<?=$rootPath?>/tissue/popupInprogress.php"; 
      $("#dvInprogress").load(url);
  });


   $("#btnTaskComplete").click(function(){
      $("#modal-complete").modal("toggle");
      var url="<?=$rootPath?>/tissue/popupComplete.php"; 
      //var url="<?=$rootPath?>/tissue/T1.php";
      $("#dvComplete").load(url);
  });


  $(".close").click(function(){
     $("#modal-initialize").modal("hide");
  });



});

</script>
