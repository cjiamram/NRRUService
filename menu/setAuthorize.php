<?php
	header("content-type:application/json;charset=UTF-8");
	include_once "../config/config.php";
	$cnf=new Config();
	$rootPath=$cnf->path;

?>

<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="<?=$rootPath?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=$rootPath?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<div class="box box-primary">
<div class="box-header with-border">
  <h3 class="box-title">จัดการสิทธิการใช้ระบบ</h3>
</div>
 <div class="box-body">
 	<div class="col-sm-2">User Name
 	</div>
 	<div class="col-sm-3">
 		<input type="text" id="obj_userName" class="form-control">

 	</div>
 	<div class="col-sm-7">
 		 <input type="button" id="btnRetreive" value="สิทธิ"การใช้งาน  class="btn btn-primary" >
 	</div>

 	<table class="table table-bordered table-hover" id="tblMenu">
 	</table>
 	</div>
 	
 </div>
</div>

<script>
		function authorizeMenu(){
			var url="<?=$rootPath?>/menu/displayAuthorizeMenu.php?userName="+$("#obj_userName").val();
			//console.log(url);
			$("#tblMenu").load(url);
		}

		function setAuthen(menuId,objId){
			
			if($("#obj_userName").val()!==""){
					var userName=$("#obj_userName").val();
					var isCheck=$(objId).prop('checked')?1:0;
					var url="<?=$rootPath?>/menu/setAuthen.php?userName="+userName+"&menuId="+menuId+"&isCheck="+isCheck;
					var flag=executeGet(url);
					
					if(flag.message===true){
							swal.fire({
							title: "กำหนดสิทธิการใช้งานเรียบร้อยแล้ว",
							type: "success",
							buttons: [false, "ปิด"],
							dangerMode: true,
							});
					}
			}
		}

		authorizeMenu();

		


		$("#btnRetreive").click(function(){
			//console.log("xxxxxx");
			authorizeMenu();
		});

</script>
