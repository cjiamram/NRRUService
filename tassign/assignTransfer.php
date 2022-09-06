<?php
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: POST");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
		include_once "../config/database.php";
		include_once "../objects/tassign.php";
		include_once "../objects/classLabel.php";
		include_once "../config/config.php";
		$database = new Database();
		$db = $database->getConnection();
		$objLbl = new ClassLabel($db);
		$cnf=new Config();
		$rootPath=$cnf->path;
?>
<link rel="stylesheet" href="<?=$rootPath?>/bower_components/select2/dist/css/select2.min.css">
<script src="<?=$rootPath?>/bower_components/select2/dist/js/select2.full.min.js"></script>

<form role='form'>
<div class="box-body">

<table  class="table table-bordered table-hover">
	<tr>
	<td colspan="2">
		<div class="box box-success">
		<table id="tbStaffWork" class="table table-bordered table-hover">

		</table>
		</div>

	</td>
	</tr>
	<tr>
		<td colspan="2">หมายเหตุ</td>
	</tr>
	<tr>
		<td colspan="2">
		<textarea class="form-control" id="obj_message" rows="5" cols="50">

		</textarea>
		</td>
	</tr>
	

</table>
</div>
</form>

<script>

 function displayStaffWork(){
    var url="<?=$rootPath?>/tstaff/chooseStaff.php";
    $("#tbStaffWork").load(url);
 }

  function getAssignId(issueId){
    var url="<?=$rootPath?>/tassign/getId.php?issueId="+issueId;
    var data=queryData(url);
    return data.id;
  }

  function saveAssignStaff(issueId,assignId,userCode){
    var jsonObj={
        assignId:assignId,
        userCode:userCode,
        issueId:issueId,
        status:1,
        progressStatus:'07'

    }

    var url="<?=$rootPath?>/tassignstaff/create.php";
    jsonData=JSON.stringify(jsonObj);

    var flag=executeData(url,jsonObj);
    notifyAssigned(userCode);
    return flag;

  }

  function deleteByIssueId(issueId){
      var url ="<?=$rootPath?>/tassignstaff/deleteByIssueId.php?issueId="+issueId;
      var flag=executeGet(url);
      return flag;
 }

 function isResponsder(){
    var flag=false;
    var i=1;
    while(document.getElementById("objChk-"+i)!=null){
        if(document.getElementById("objChk-"+i).checked===true){
            return true;
        }
        i++;
    }
    return flag;
 }

  function saveAssignIteration(){
    var i=1;
    var flag=true;
    var assignId=getAssignId($("#obj_id").val());
    deleteByIssueId($("#obj_id").val());
    while(document.getElementById("objChk-"+i)!==null){
        if(document.getElementById("objChk-"+i).checked===true){
          var userCode=$("#id-"+i).val();
          flag &= saveAssignStaff($("#obj_id").val(),assignId,userCode);
        }
        i++;
    }
    return flag;
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


 $(function () {
		  displayStaffWork();
  });


</script>