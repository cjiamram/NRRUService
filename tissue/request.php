<?php
//session_start();
//print_r($_SESSION["UserCode"]);
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

?>


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
				<div id="dvIssueDetail">
				<textarea class="form-control"
				rows="4" cols="100" 
				 id='obj_issueDetail' ></textarea>
				</div>
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
    	<?php
    		$userCode=isset($_SESSION["UserCode"])?$_SESSION["UserCode"]:"Admin";
$path="";

if(isset($_GET["isSearch"])){

	$keyWord=isset($_GET["keyWord"])?$_GET["keyWord"]:"";
	$issueType=isset($_GET["issueType"])?$_GET["issueType"]:"";
	$requestDate=isset($_GET["requestDate"])?$_GET["requestDate"]:"";
	$path="tissue/getAdvanceByStaff.php?userCode=".$userCode."&keyWord=".$keyWord."&issueType=".$issueType."&requestDate=".$requestDate;
}else{
	$path="tissue/getDataByStaff.php?userCode=".$userCode;
}


$url=$cnf->restURL.$path;
$api=new ClassAPI();


$data=$api->getAPI($url);
echo "<thead>";
		echo "<tr>";
			echo "<th>No.</th>";
			echo "<th>".$objLbl->getLabel("t_issue","createDate","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_issue","issueType","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_issue","issueDetail","TH")."</th>";
			echo "<th>".$objLbl->getLabel("t_issue","status","TH")."</th>";
			echo "<th>จัดการ</th>";
		echo "</tr>";
echo "</thead>";
if(!isset($data["message"])){
echo "<tbody>";
$i=1;
foreach ($data as $row) {
		echo "<tr>\n";
			echo '<td>'.$i++.'</td>'."\n";
			echo '<td width=\'150px\' align=\'center\'>'.$row["createDate"].'</td>'."\n";
			echo '<td width=\'200px\'>'.$row["issueType"].'</td>'."\n";
			echo '<td><textarea class=\'form-control\' rows=\'2\' cols=\'30\'>'.$row["issueDetail"].'</textarea></td>'."\n";
			echo '<td>'.$row["status"].'</td>'."\n";
			
			$strOperate="";

			if($row["statusCode"]==="01"){
				$strOperate="<button type='button' class='btn btn-info'
					onclick='readOneIssue(".$row['id'].")'>
					<span class='fa fa-edit'></span>
				</button>
				<button type='button'
					class='btn btn-danger'
					onclick='confirmDelete(".$row['id'].")'>
					<span class='fa fa-trash'></span>
				</button>";
			}
			echo "<td width='150px'>".$strOperate."</td>\n";
			echo "</tr>\n";
}
echo "</tbody>";
}
    	?>
    </table>

</div>
</div>
</form>

 


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
		//displayIssue();
		 loadInput();
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


function getIssueDetail(id){
	var url ="<?=$rootPath?>/tissue/getIssueDetail.php?id="+id;
	console.log(url);
	$("#dvIssueDetail").load(url);
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
			$("#obj_notifyBy").val(data.notifyBy);
			$("#obj_id").val(data.id);
			getIssueDetail(data.id);
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
		setTextEditor("#obj_issueDetail");

		tablePage("#tbStaffRequest");


		$("#btnSaveIssue").click(function(){
			saveIssue();
		});

		$("#btnNew").click(function(){
			clearData();
		});

		
	});



	

	

</script>
