var regDec = /^\d+(\.\d{1,2})?$/;
var regEmail=/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/g;
var regTel=/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/g;
var regDate=/(0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])[- \/.](19|20)\d\d/;
function validInput(){
		var flag=true;
		flag=regDec.test($("#obj_OrderNo").val());
		if (flag==false){
			$("#obj_OrderNo").focus();
			return flag;
}
		flag=regDec.test($("#obj_LevelNo").val());
		if (flag==false){
			$("#obj_LevelNo").focus();
			return flag;
}
		return flag;
}
function displayData(){
		var url="tmenu/displayData.php?tableName=t_menu&dbName=dbserviceonline&keyWord="+$("#txtSearch").val();
		$("#tblDisplay").load(url);
}
function createData(){
		var url='tmenu/create.php';
		jsonObj={
			MenuId:$("#obj_MenuId").val(),
			MenuName:$("#obj_MenuName").val(),
			Link:$("#obj_Link").val(),
			Parent:$("#obj_Parent").val(),
			OrderNo:$("#obj_OrderNo").val(),
			LevelNo:$("#obj_LevelNo").val(),
			Topic:$("#obj_Topic").val(),
			enableDefault:$("#obj_enableDefault").val()
		}
		var jsonData=JSON.stringify (jsonObj);
		var flag=executeData(url,jsonObj,false);
		return flag;
}
function updateData(){
		var url='tmenu/update.php';
		jsonObj={
			MenuId:$("#obj_MenuId").val(),
			MenuName:$("#obj_MenuName").val(),
			Link:$("#obj_Link").val(),
			Parent:$("#obj_Parent").val(),
			OrderNo:$("#obj_OrderNo").val(),
			LevelNo:$("#obj_LevelNo").val(),
			Topic:$("#obj_Topic").val(),
			enableDefault:$("#obj_enableDefault").val(),
			id:$("#obj_id").val()
		}
		var jsonData=JSON.stringify (jsonObj);
		var flag=executeData(url,jsonObj,false);
		return flag;
}
function readOne(id){
		var url='tmenu/readOne.php?id='+id;
		data=queryData(url);
		if(data!=""){
			$("#obj_MenuId").val(data.MenuId);
			$("#obj_MenuName").val(data.MenuName);
			$("#obj_Link").val(data.Link);
			$("#obj_Parent").val(data.Parent);
			$("#obj_OrderNo").val(data.OrderNo);
			$("#obj_LevelNo").val(data.LevelNo);
			$("#obj_Topic").val(data.Topic);
			$("#obj_enableDefault").val(data.enableDefault);
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
			url="tmenu/delete.php?id="+id;
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
			$("#obj_MenuId").val("");
			$("#obj_MenuName").val("");
			$("#obj_Link").val("");
			$("#obj_Parent").val("");
			$("#obj_OrderNo").val("");
			$("#obj_LevelNo").val("");
			$("#obj_Topic").val("");
			$("#obj_enableDefault").val("");
}
function genCode(){
		//var url="genCode.php";
		//var data=queryData(url);
		//return data.code;
}
