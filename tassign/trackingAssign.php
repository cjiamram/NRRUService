<?php
session_start();
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
$UserName=isset($_SESSION["UserName"])?$_SESSION["UserName"]:"";
$cnf=new Config();
$rootPath=$cnf->path;
?>
<link rel="stylesheet" href="<?php echo $rootPath; ?>/bower_components/select2/dist/css/select2.min.css">
<script src="<?php echo $rootPath; ?>/bower_components/select2/dist/js/select2.full.min.js"></script>
<div class="row">
<div class="col-lg-7 col-xs-6">
<div class="box box-warning">
    <div class='form-group'>
      <label class="col-sm-12"><?php echo $objLbl->getLabel("t_issue","issueDetail","th").":" ?></label>
      <div class="col-sm-12">
   
      <div id="obj_IssueDetail" style="min-height: 200px;overflow: scroll;"></div>
      </div>
    </div>
    <div class='form-group'>
      <label class="col-sm-12"><?php echo $objLbl->getLabel("t_issue","notifyBy","th").":" ?></label>
      <div class="col-sm-12">
      <input type="text" id="obj_notifyBy" class="form-control" disabled>
      </div>
    </div>
    <div class='form-group'>
      <label class="col-sm-12"><?php echo $objLbl->getLabel("t_issue","requestDate","th").":" ?></label>
      <div class="col-sm-12">
      <input type="text" id="obj_requestDate" class="form-control" disabled>
      </div>
    </div>
	
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_assign","assignFrom","th").":" ?></label>
			<div class="col-sm-12">
				<input type="text" value="<?php echo $UserName; ?>" 
							class="form-control" id='obj_assignFrom' 
							placeholder='assignFrom'>
			</div>
		</div>
		<div class='form-group' style="display:none">
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_assign","receiveBy","th").":" ?></label>
			<div class="col-sm-12">
			    <select id="obj_receiveBy" class="select2" style="width:100%"></select>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_assign","duration","th").":" ?></label>
			<div class="col-sm-12">
				<table width="100%">
				<tr>
					<td width="49%">
						<div class="input-group date">
						<div class="input-group-addon">
						<i class="fa fa-calendar"></i>
						</div>
						<input type="date" class="form-control" id="obj_startDate">
						</div>
					</td>
					<td align="center">-</td>
					<td width="49%">
						<div class="input-group date">
						<div class="input-group-addon">
						<i class="fa fa-calendar"></i>
						</div>
						<input type="date" class="form-control" id="obj_deuDate">
						</div>
						
					</td>
				</tr>
				</table>
			</div>
		</div>
</div>
</div>
<div class="col-lg-5 col-xs-6">
    <div class="box box-success">
    <table id="tbStaffWork" class="table table-bordered table-hover">

    </table>
    </div>
</div>
</div>




<script>
	var rootPath='<?php echo $rootPath; ?>';
  var regDec = /^\d+(\.\d{1,2})?$/;
	var regEmail=/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/g;
	var regTel=/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/g;
	var regDate=/(0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])[- \/.](19|20)\d\d/;
	
	 $(function () {
    		$('.select2').select2()
  	})

	function validAssign(){
	    var flag=true;
	    flag=regDate.test($("#obj_createDate").val());
	    if (flag==false){
	        $("#obj_createDate").focus();
	        return flag;
	    }
	    flag=regDate.test($("#obj_startDate").val());
	    if (flag==false){
	        $("#obj_startDate").focus();
	        return flag;
	    }
	    flag=regDate.test($("#obj_deuDate").val());
	    if (flag==false){
	        $("#obj_deuDate").focus();
	        return flag;
	    }
	    flag=regDate.test($("#obj_realStartDate").val());
	    if (flag==false){
	        $("#obj_realStartDate").focus();
	        return flag;
	    }
	    return flag;
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
        status:1
    }
    var jsonData=JSON.stringify (jsonObj);
    console.log(jsonData);
    var url="<?=$rootPath?>/tassignstaff/create.php";
    var flag=executeData(url,jsonObj,false);
    console.log(flag);
    return flag;

  }

  function deleteByIssueId(issueId){
      var url ="<?=$rootPath?>/tassignstaff/deleteByIssueId.php?issueId="+issueId;
      var flag=executeGet(url);
      return flag;
 }

  function saveAssignIteration(){
    var i=0;
    var flag=true;
    var assignId=getAssignId($("#obj_id").val());
    deleteByIssueId($("#obj_id").val());
      console.log("AAA");
    while(document.getElementById("objChk-"+i)!=null){
        console.log(i);
        if($("#objChk-"+i).checked()==true){
          var userCode=$("#id-"+i).val();
          flag &= saveAssignStaff($("#obj_id").val(),assignId,userCode);
        }
        i++;
    }
    return flag;
  }


	function createAssign(){
    var url=rootPath+'/tassign/create.php';
    jsonObj={
      issueId:$("#obj_id").val(),
      fixProblem:'',
      assignFrom:$("#obj_assignFrom").val(),
      receiveBy:$("#obj_receiveBy").val(),
      startDate:$("#obj_startDate").val(),
      deuDate:$("#obj_deuDate").val(),
      realStartDate:$("#obj_realStartDate").val(),
      realEndDate:$("#obj_realEndDate").val(),
      status:"02"
    }
    var jsonData=JSON.stringify (jsonObj);
    var flag=executeData(url,jsonObj,false);
    flag &=saveAssignIteration();
    return flag;
}
function updateAssign(){
    var url=rootPath+'tassign/update.php';
    jsonObj={
      issueId:$("#obj_id").val(),
      fixProblem:'',
      assignFrom:$("#obj_assignFrom").val(),
      receiveBy:$("#obj_receiveBy").val(),
      startDate:$("#obj_startDate").val(),
      deuDate:$("#obj_deuDate").val(),
      realStartDate:$("#obj_realStartDate").val(),
      realEndDate:$("#obj_realEndDate").val(),
      status:"02",
      id:$("#obj_id").val()
    }
    var jsonData=JSON.stringify (jsonObj);
    var flag=executeData(url,jsonObj,false);
    flag &=saveAssignIteration();
    return flag;
}

function updateStatus(){
  var url =rootPath+ "/tissue/updateStatus.php?id="+$("#obj_id").val()+"&status=02";
  executeGet(url);
  //var data.message;
}

function notifyAssigned(){
    //First Method Implement
    var url="<?=$rootPath?>/lineBot/notifyAssignJob.php?assignTo="+$("#obj_receiveBy").val()+"&id="+$("#obj_id").val();
    //var url="<?=$rootPath?>/lineBot/notifyAssignMSG.php?assignTo="+$("#obj_receiveBy").val()+"&id="+$("#obj_id").val();
    //console.log(url);
    //var url="<?=$rootPath?>/lineBot/notifyAssignWithPicture.php?assignTo="+$("#obj_receiveBy").val()+"&id="+$("#obj_id").val();
    //console.log(url);
    var data=executeGet(url);
    //console.log(data);
}

function saveAssign(){
    var flag;
    flag=true;
    if(flag==true){
       
        flag=createAssign();
        updateStatus();
        notifyAssigned();
        if(flag==true){
              swal.fire({
              title: "?????????????????????????????????????????????????????????????????????????????????????????????",
              type: "success",
              buttons: [false, "?????????"],
              dangerMode: true,
            });
            displayData();
        }
        else{
                swal.fire({
                title: "??????????????????????????????????????????????????????????????????",
                type: "error",
                buttons: [false, "?????????"],
                dangerMode: true,
            });
          }
        }else{
              swal.fire({
              title: "???????????????????????????????????????????????????????????????????????????????????????",
              type: "error",
              buttons: [false, "?????????"],
              dangerMode: true,
          });
        }
}


function formatDate(dateObj,format)
{
    var monthNames = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
    var curr_date = dateObj.getDate();
    var curr_month = dateObj.getMonth();
    curr_month = curr_month + 1;
    var curr_year = dateObj.getFullYear();
    var curr_min = dateObj.getMinutes();
    var curr_hr= dateObj.getHours();
    var curr_sc= dateObj.getSeconds();
    if(curr_month.toString().length == 1)
    curr_month = '0' + curr_month;      
    if(curr_date.toString().length == 1)
    curr_date = '0' + curr_date;
    if(curr_hr.toString().length == 1)
    curr_hr = '0' + curr_hr;
    if(curr_min.toString().length == 1)
    curr_min = '0' + curr_min;

    if(format ==1)//dd-mm-yyyy
    {
        return curr_date + "-"+curr_month+ "-"+curr_year;       
    }
    else if(format ==2)//yyyy-mm-dd
    {
        return curr_year + "-"+curr_month+ "-"+curr_date;       
    }
    else if(format ==3)//dd/mm/yyyy
    {
        return curr_date + "/"+curr_month+ "/"+curr_year;       
    }
    else if(format ==4)// MM/dd/yyyy HH:mm:ss
    {
        return curr_month+"/"+curr_date +"/"+curr_year+ " "+curr_hr+":"+curr_min+":"+curr_sc;       
    }
}

 function AddDay(strDate,intNum){

  sdate =  new Date(strDate);
  sdate.setDate(sdate.getDate()+intNum);
  return sdate;
 }



 function setDate(){
  var d = new Date();
  var start = formatDate(d,2);
  var finish=formatDate(AddDay(start,1),2);
 
  $("#obj_startDate").val(start);
  $("#obj_deuDate").val(finish);
 }


 function displayStaffWork(){
    var url="<?=$rootPath?>/tstaff/displayStaffWork.php";
    $("#tbStaffWork").load(url);
 }
	
	$(document).ready(function(){
		  listStaff();
    	listReceiveStatus();
      displayStaffWork();
    	setDate();
      loadIssue();
		
	})
	
</script>
