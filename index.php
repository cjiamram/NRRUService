<!DOCTYPE html>
<?php
include_once "objects/pageInfo.php";
include_once "config/config.php";
$cnf=new Config();
$rootPath=$cnf->path;



  session_start();
  $_SESSION["lang"]="TH";
  if(!isset($_SESSION["UserName"])){
      header( "location:indexDashboard.php");
      exit();
    }
  else
  {
    include_once "config/database.php";
    include_once "objects/tfullname.php";
    $database = new Database();
    $db = $database->getConnection();
    $obj = new tfullname($db);
    if($obj->isExist($_SESSION["UserName"])!==true){
      $obj->userCode = $_SESSION["UserName"];
      $obj->fullName =$_SESSION["FullName"];
      $obj->departmentCode = $_SESSION["DepartmentId"];

      $obj->create();
    }

    echo "<input type='hidden' id='obj_staffCode' value='".$_SESSION["UserName"]."' >";


    echo "<input type='hidden' id='obj_staffId' value='".$_SESSION["UserName"]."' >";
  }
?>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>NRRU Service Online</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/skin-purple.min.css">
  <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="css/jquery-ui.css"/>
  <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="dist/css/jquery-confirm.min.css">
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.min.css">
  <link rel="stylesheet" href="bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">


<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="js/jquery-1.12.4.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script src="js/canvasjs.min.js"></script>
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="js/plugins/sweetalert/sweetalert2.all.min.js"></script>

<script src="js/component.js"></script>
<script src="js/menuRender.js"></script>
<script src="js/fileManager.js"></script>
</head>

<body class="hold-transition skin-purple sidebar-mini" style="padding:no-padding">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="#" class="logo">
      <span class="logo-mini"><b>NSO</b></span>
      <span class="logo-lg"><b>NRRU Service</b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <ul class="dropdown-menu">
              <li>
                <!-- inner menu: contains the messages -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                      </div>
                     
                    </a>
                  </li>
                  <!-- end message -->
                </ul>
                <!-- /.menu -->
              </li>
              <!--<li class="footer"><a href="#">See All Messages</a></li>-->
            </ul>
          </li>
          <!-- /.messages-menu -->

          <li class="dropdown notifications-menu">
       
            <ul class="dropdown-menu">
             
              <li class="footer"><a href="#"></a></li>
            </ul>
          </li>
          <li class="dropdown tasks-menu">
            <ul class="dropdown-menu">
              <li class="header"></li>
              <li>
                <ul class="menu">
                  <li>
                    <a href="#">
                
                      <div class="progress xs">
                        <!-- Change the css width attribute to simulate progress -->
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                        </div>
                      </div>
                    </a>
                  </li>
                 
                </ul>
              </li>
              <li class="footer">
                <a href="#"></a>
              </li>
            </ul>
          </li>
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" onclick='initialize()' data-toggle="dropdown">
               <?php
                $picture=$_SESSION["Picture"];
                if(isset($_SESSION["Picture"])&&$_SESSION["Picture"]!==""){
                    echo ("<img id=\"imgPicR\" class=\"user-image\" alt=\"User Image\">");
                    echo("<span class=\"hidden-xs\">".$_SESSION["FullName"]."</span>");
                }else
                {
                    echo("<img src=\"dist/img/avatar5.png\" id=\"imgPicR\" class=\"user-image\" alt=\"User Image\">");
                    echo("<span class=\"hidden-xs\">".$_SESSION["FullName"]."</span>");

                }
              ?>
            </a>


            
          </li>

      
          <li class="dropdown user user-menu">
             
              <a href="#" id="lnkLogout"   class="dropdown-toggle" data-toggle="dropdown">
               <img src="dist/img/Logout.png" class="user-image" alt="User Image">
              <span class="hidden-xs">Logout</span>
              </a>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <div class="user-panel">
        <div class="pull-left image">
       
           <?php
                
            if(isset($_SESSION["Picture"])&&$_SESSION["Picture"]!==""){
                echo ("<img id=\"imgPicL\" class=\"user-image\" alt=\"User Image\">");

            }else
            {
                echo ("<img src=\"dist/img/avatar5.png\" id=\"imgPicL\" class=\"user-image\" alt=\"User Image\">");

            }
           ?>
        </div>
        <div class="pull-left info">
          <p>
            <?php 
            if(isset($_SESSION["Picture"])){
                echo($_SESSION["FullName"]);
            }
           ?>
          </p>
        </div>
      </div>

      <!-- search form (Optional) -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
        </div>
      </form>
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree" id="ulMenu">
   
      </ul>
     
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="dvMain">

  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      Anything you want
    </div>
    <strong>Copyright &copy; 2020 <a href="#">NRRU</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane active" id="control-sidebar-home-tab">
        <!--<h3 class="control-sidebar-heading">Recent Activity</h3>-->
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:;">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <!--<h3 class="control-sidebar-heading">Tasks Progress</h3>-->
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:;">
             
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <div class="control-sidebar-bg"></div>
  <div class="control-sidebar-bg"></div>
  <script>

 async function imageExists(imgUrl) {
    if (!imgUrl) {
        return false;
    }
    return new Promise(res => {
        const image = new Image();
        image.onload = () => res(true);
        image.onerror = () => res(false);
        image.src = imgUrl;
    });
}

(async () => {
  var x= await imageExists('<?=$picture?>');
  if(x===true){
    document.getElementById('imgPicR').src='<?=$picture?>';
    document.getElementById('imgPicL').src='<?=$picture?>';
  }else{
    document.getElementById('imgPicR').src='dist/img/avatar5.png';
    document.getElementById('imgPicL').src='dist/img/avatar5.png';
  }
})()
  

  $("#lnkLogout").click(function(){
       logout();

  });

  function goDashboard(){
    $("#dvMain").load("<?=$rootPath?>/Dashboard/mainDashBoard.php");
  }

  function getmustEvaluate(){
      var url="<?=$rootPath?>/tissue/getCountCompleteByUser.php";
      var data=queryData(url);
      return data.flag;
  }

  function showEvaluate(){
     if(getmustEvaluate()===false)
          {$("#dvMain").load("<?=$rootPath?>/Dashboard/mainDashBoard.php");}
      else
          {
            var url="<?=$rootPath?>/tissue/displayCompleteWorkByUser.php";
            $("#dvMain").load(url);

        ;}
  }

  function initialize(){

     showEvaluate();
  }
  

  $( window ).load(function() {
     getHeadMenu("#ulMenu");
     initialize();
   });
  </script>
</div>
</body>
</html>