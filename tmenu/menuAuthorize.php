<?php
	include_once "../config/database.php";
	include_once "../objects/tmenu.php";
	include_once "../config/config.php";

	$database=new Database();
	$db=$database->getConnection();
	$obj=new tmenu($db);
	$cnf=new Config();



?>

<section class="content-header">
<h1>
	<b>ระบบแจ้งซ่อมออนไลน์</b>
	<small>>>กำหนดสิทธิการใช้งาน</small>
</h1>
</section>

<section class="content container-fluid">
<div class="box"></div>
<div class="row">
<div class="col-lg-3 col-xs-6">
	<div id="dvUser">
	</div>
</div>
<div class="col-lg-9 col-xs-6">
	   <div class="form-group">
          <div class="col-sm-12">
             <div class="col-sm-6">
              
                <table width="100%">
                  <tr>
                    <td width="150px">
                      <label>
                        เมนูหลัก:
                      </label>
                    </td>
                    <td>
                      <select class="form-control"
                      id="obj_HeadMenu"
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

        <div id="dvChildMenu">
        </div>
</div>	
</div>
</section>

<script>

var rootPath='<?php echo $cnf->path; ?>';

function listParent(){
	var url=rootPath+"/tmenu/listHeader.php";
	setDDL(url,"#obj_HeadMenu");
}

$(document).ready(function(){
	listParent();
});

</script>
