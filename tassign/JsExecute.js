var regDec = /^\d+(\.\d{1,2})?$/;
var regEmail=/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/g;
var regTel=/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/g;
var regDate=/(0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])[- \/.](19|20)\d\d/;
function validInput(){
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
function displayData(){
		var url="tassign/displayData.php?tableName=t_assign&dbName=dbserviceonline&keyWord="+$("#txtSearch").val();
		$("#tblDisplay").load(url);
}
function createData(){
		var url='tassign/create.php';
		jsonObj={
			issueId:$("#obj_issueId").val(),
			fixProblem:$("#obj_fixProblem").val(),
			createDate:$("#obj_createDate").val(),
			assignFrom:$("#obj_assignFrom").val(),
			receiveBy:$("#obj_receiveBy").val(),
			startDate:$("#obj_startDate").val(),
			deuDate:$("#obj_deuDate").val(),
			realStartDate:$("#obj_realStartDate").val(),
			realEndDate:$("#obj_realEndDate").val(),
			status:$("#obj_status").val(),
			assignTo:$("#obj_assignTo").val()
		}
		var jsonData=JSON.stringify (jsonObj);
		var flag=executeData(url,jsonObj,false);
		return flag;
}
function updateData(){
		var url='tassign/update.php';
		jsonObj={
			issueId:$("#obj_issueId").val(),
			fixProblem:$("#obj_fixProblem").val(),
			createDate:$("#obj_createDate").val(),
			assignFrom:$("#obj_assignFrom").val(),
			receiveBy:$("#obj_receiveBy").val(),
			startDate:$("#obj_startDate").val(),
			deuDate:$("#obj_deuDate").val(),
			realStartDate:$("#obj_realStartDate").val(),
			realEndDate:$("#obj_realEndDate").val(),
			status:$("#obj_status").val(),
			assignTo:$("#obj_assignTo").val(),
			id:$("#obj_id").val()
		}
		var jsonData=JSON.stringify (jsonObj);
		var flag=executeData(url,jsonObj,false);
		return flag;
}
function readOne(id){
		var url='tassign/readOne.php?id='+id;
		data=queryData(url);
		if(data!=""){
			$("#obj_issueId").val(data.issueId);
			$("#obj_fixProblem").val(data.fixProblem);
			$("#obj_createDate").val(data.createDate);
			$("#obj_assignFrom").val(data.assignFrom);
			$("#obj_receiveBy").val(data.receiveBy);
			$("#obj_startDate").val(data.startDate);
			$("#obj_deuDate").val(data.deuDate);
			$("#obj_realStartDate").val(data.realStartDate);
			$("#obj_realEndDate").val(data.realEndDate);
			$("#obj_status").val(data.status);
			$("#obj_assignTo").val(data.assignTo);
			$("#obj_id").val(data.id);
		}
}
function saveData(){
		var flag;
		flag=validInput();
		if(flag==true){
					if($("#obj_id").val()!=""){
			flag=updateData();
			}else{
			flag=createData();
		}
		if(flag==true){
			swal.fire({
			title: "การบันทึกข้อมูลเสร็จสมบูรณ์แล้ว",
			type: "success",
			buttons: [false, "ปิด"],
			dangerMode: true,
		});
		displayData();
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
			url="tassign/delete.php?id="+id;
			executeGet(url,false,"");
			displayData();
		swal.fire({
			title: "ลบข้อมูลเรียบร้อยแล้ว",
			type: "success",
			buttons: "ตกลง",
		});
		} else {
			swal.fire({
			title: "ยกเลิกการทำรายการ",
			type: "error",
			buttons: [false, "ปิด"],
			dangerMode: true,
		})
		}
		});
}
function clearData(){
			$("#obj_issueId").val("");
			$("#obj_fixProblem").val("");
			$("#obj_createDate").val("");
			$("#obj_assignFrom").val("");
			$("#obj_receiveBy").val("");
			$("#obj_startDate").val("");
			$("#obj_deuDate").val("");
			$("#obj_realStartDate").val("");
			$("#obj_realEndDate").val("");
			$("#obj_status").val("");
			$("#obj_assignTo").val("");
}
function genCode(){
		//var url="genCode.php";
		//var data=queryData(url);
		//return data.code;
}
