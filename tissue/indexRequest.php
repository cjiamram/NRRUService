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

?>
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
<script>

 function getmustEvaluate(){
      var url="<?=$rootPath?>/tissue/getCountCompleteByUser.php";
      var data=queryData(url);
      //console.log(data);
      return data.flag;
  }

 function showEvaluate(){
     if(getmustEvaluate()===false){
         //$("#dvMain").load("<?=$rootPath?>/tissue/indexRequest.php");
         loadInput();
      }
      else
          {
            //console.log("AAAAAAA");
            var url="<?=$rootPath?>/tissue/displayCompleteWorkByUser.php";
            $("#dvMain").load(url);

        ;}
  }



 function loadInput(){
      var url="<?=$rootPath?>/tissue/request.php";
      $("#dvRequest").load(url);
 }



 function loadPage(){
   showEvaluate();
 }

 $( document ).ready(function() {
    loadPage();
 });

</script>
