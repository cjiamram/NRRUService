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
		return flag;
}
function displayData(){
		var url="tissue/displayData.php?tableName=t_issue&dbName=dbserviceonline&keyWord="+$("#txtSearch").val();
		$("#tblDisplay").load(url);
}
function createData(){
		var url='tissue/create.php';
		jsonObj={
			staffId:$("#obj_staffId").val(),
			roomNo:$("#obj_roomNo").val(),
			floorNo:$("#obj_floorNo").val(),
			building:$("#obj_building").val(),
			telNo:$("#obj_telNo").val(),
			lineNo:$("#obj_lineNo").val(),
			createDate:$("#obj_createDate").val(),
			issueType:$("#obj_issueType").val(),
			issueDetail:$("#obj_issueDetail").val(),
			notifyBy:$("#obj_notifyBy").val(),
			status:$("#obj_status").val()
		}
		var jsonData=JSON.stringify (jsonObj);
		var flag=executeData(url,jsonObj,false);
		return flag;
}
function updateData(){
		var url='tissue/update.php';
		jsonObj={
			staffId:$("#obj_staffId").val(),
			roomNo:$("#obj_roomNo").val(),
			floorNo:$("#obj_floorNo").val(),
			building:$("#obj_building").val(),
			telNo:$("#obj_telNo").val(),
			lineNo:$("#obj_lineNo").val(),
			createDate:$("#obj_createDate").val(),
			issueType:$("#obj_issueType").val(),
			issueDetail:$("#obj_issueDetail").val(),
			notifyBy:$("#obj_notifyBy").val(),
			status:$("#obj_status").val(),
			id:$("#obj_id").val()
		}
		var jsonData=JSON.stringify (jsonObj);
		var flag=executeData(url,jsonObj,false);
		return flag;
}
function readOne(id){
		var url='tissue/readOne.php?id='+id;
		data=queryData(url);
		if(data!=""){
			$("#obj_staffId").val(data.staffId);
			$("#obj_roomNo").val(data.roomNo);
			$("#obj_floorNo").val(data.floorNo);
			$("#obj_building").val(data.building);
			$("#obj_telNo").val(data.telNo);
			$("#obj_lineNo").val(data.lineNo);
			$("#obj_createDate").val(data.createDate);
			$("#obj_issueType").val(data.issueType);
			$("#obj_issueDetail").val(data.issueDetail);
			$("#obj_notifyBy").val(data.notifyBy);
			$("#obj_status").val(data.status);
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
			url="tissue/delete.php?id="+id;
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
			$("#obj_staffId").val("");
			$("#obj_roomNo").val("");
			$("#obj_floorNo").val("");
			$("#obj_building").val("");
			$("#obj_telNo").val("");
			$("#obj_lineNo").val("");
			$("#obj_createDate").val("");
			$("#obj_issueType").val("");
			$("#obj_issueDetail").val("");
			$("#obj_notifyBy").val("");
			$("#obj_status").val("");
}
function genCode(){
		//var url="genCode.php";
		//var data=queryData(url);
		//return data.code;
}
