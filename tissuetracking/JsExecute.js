var regDec = /^\d+(\.\d{1,2})?$/;
var regEmail=/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/g;
var regTel=/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/g;
var regDate=/(0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])[- \/.](19|20)\d\d/;
function validInput(){
		var flag=true;
		flag=regDate.test($("#obj_operatingDate").val());
		if (flag==false){
				$("#obj_operatingDate").focus();
				return flag;
		}
		flag=regDec.test($("#obj_progress").val());
		if (flag==false){
			$("#obj_progress").focus();
			return flag;
}
		return flag;
}
function displayData(){
		var url="tissuetracking/displayData.php?tableName=t_issuetracking&dbName=dbserviceonline&keyWord="+$("#txtSearch").val();
		$("#tblDisplay").load(url);
}
function createData(){
		var url='tissuetracking/create.php';
		jsonObj={
			issueId:$("#obj_issueId").val(),
			staffCode:$("#obj_staffCode").val(),
			detail:$("#obj_detail").val(),
			status:$("#obj_status").val(),
			operatingDate:$("#obj_operatingDate").val(),
			progress:$("#obj_progress").val()
		}
		var jsonData=JSON.stringify (jsonObj);
		var flag=executeData(url,jsonObj,false);
		return flag;
}
function updateData(){
		var url='tissuetracking/update.php';
		jsonObj={
			issueId:$("#obj_issueId").val(),
			staffCode:$("#obj_staffCode").val(),
			detail:$("#obj_detail").val(),
			status:$("#obj_status").val(),
			operatingDate:$("#obj_operatingDate").val(),
			progress:$("#obj_progress").val(),
			id:$("#obj_id").val()
		}
		var jsonData=JSON.stringify (jsonObj);
		var flag=executeData(url,jsonObj,false);
		return flag;
}
function readOne(id){
		var url='tissuetracking/readOne.php?id='+id;
		data=queryData(url);
		if(data!=""){
			$("#obj_issueId").val(data.issueId);
			$("#obj_staffCode").val(data.staffCode);
			$("#obj_detail").val(data.detail);
			$("#obj_status").val(data.status);
			$("#obj_operatingDate").val(data.operatingDate);
			$("#obj_progress").val(data.progress);
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
			url="tissuetracking/delete.php?id="+id;
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
			$("#obj_staffCode").val("");
			$("#obj_detail").val("");
			$("#obj_status").val("");
			$("#obj_operatingDate").val("");
			$("#obj_progress").val("");
}
function genCode(){
		//var url="genCode.php";
		//var data=queryData(url);
		//return data.code;
}
