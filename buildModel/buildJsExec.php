<?php
		include_once '../config/database.php';
		include_once '../config/config.php';
		include_once '../objects/createModel.php';

		$cnf=new Config();

		$tableName=isset($_GET["tableName"])?$_GET["tableName"]:"";
		$dbName=isset($_GET["dbName"])?$_GET["dbName"]:"";
		$tName=str_replace("_", "", $tableName);

		$database = new Database();
		$db = $database->getConnection();
		$conn = new CreateModel($db);

		$conn->table_name=$tableName;
		$conn->db_name=$dbName;
		$stmt= $conn->getSchema();
		$num = $stmt->rowCount();

		$objArr=array();
		if($num>0){
		    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		        extract($row);
		        $objItem=array(
		            "COLUMN_NAME" => $COLUMN_NAME,
		            "DATA_TYPE"=>$DATA_TYPE,
		            "COLUMN_COMMENT"=>$COLUMN_COMMENT,
		            "IS_NULLABLE"=>$IS_NULLABLE
		        );
		        array_push($objArr, $objItem);
		    }
		}
		$strJs="";
		//**************************************
	

		//**************************************
		$strJs.="var regDec = /^\d+(\.\d{1,2})?$/;\n";
		$strJs.="var regEmail=/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/g;\n";
		$strJs.="var regTel=/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/g;\n";
		$strJs.="var regDate=/(0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])[- \/.](19|20)\d\d/;\n";
		//**********************************
		$strJs.="function validInput(){\n";
  		$strJs.="\t\t"."var flag=true;\n";
  			foreach ($objArr as $row) {
			 if($row["DATA_TYPE"]=="decimal"||$row["DATA_TYPE"]=="int"){
				$strJs.= "\t\t".'flag=regDec.test($("#obj_'.$row["COLUMN_NAME"].'").val());'."\n";
				$strJs.= "\t\t".'if (flag==false){'."\n";
				$strJs.= "\t\t\t".'$("#obj_'.$row["COLUMN_NAME"].'").focus();'."\n";
				$strJs.= "\t\t\t".'return flag;'."\n";
				$strJs.= "}\n";
			 }
			 //------------------------------
			if($row["COLUMN_COMMENT"]=="email"){
				$strJs.= "\t\t". 'flag=regEmail.test($("#obj_'.$row["COLUMN_NAME"].'").val());'."\n";
				$strJs.= "\t\t". 'if (flag==false){'."\n";
				$strJs.= "\t\t\t".'$("#obj_'.$row["COLUMN_NAME"].'").focus();'."\n";
				$strJs.= "\t\t\t".'return flag;'."\n";
				$strJs.= "\t\t". "}\n";
			}
			//------------------------------

			if($row["COLUMN_COMMENT"]=="file"){

				//$strJs.= "\t\t<input id>"
			}

			//------------------------------
			/*if($row["IS_NULLABLE"]=="YES"){
				$strJs.= "\t\t". 'flag=regEmail.test($("#obj_'.$row["COLUMN_NAME"].'").val());'."\n";
				$strJs.= "\t\t". "if (flag==false){\n";
				$strJs.= "\t\t\t".'$("#obj_'.$row["COLUMN_NAME"].'").focus();'."\n";
				$strJs.= "\t\t\t".'return flag;'."\n";
				$strJs.= "\t\t". "}\n";
			}*/
			//------------------------------
			if($row["DATA_TYPE"]=="datetime"){
				$strJs.= "\t\t". 'flag=regDate.test($("#obj_'.$row["COLUMN_NAME"].'").val());'."\n";
				$strJs.= "\t\t". 'if (flag==false){'."\n";
				$strJs.= "\t\t". "\t\t".'$("#obj_'.$row["COLUMN_NAME"].'").focus();'."\n";
				$strJs.= "\t\t". "\t\t".'return flag;'."\n";
				$strJs.= "\t\t". "}\n";
			}
  		}
  		$strJs.= "\t\t"."return flag;\n";
  		$strJs.="}\n";

		//**********************************
		$strJs.="function displayData(){\n";
		$strJs.="\t\t".'var url="'.$tName.'/displayData.php?tableName='.$tableName.'&dbName='.$dbName.'&keyWord="+$("#txtSearch").val();'."\n";
		$strJs.="\t\t".'$("#tblDisplay").load(url);'."\n";
		$strJs.="}\n";

  		//**********************************
		
		
		$strJs.="function createData(){\n";
		$strJs.="\t\t".'var url=\''.$tName.'/create.php\';'."\n";
		$strJs.="\t\t"."jsonObj={\n";
		$l=count($objArr);
		$i=0;
		foreach ($objArr as $row) {
			if($i++<$l-1)
				$strJs.="\t\t\t".$row["COLUMN_NAME"].':$("#obj_'.$row["COLUMN_NAME"].'").val(),'."\n";
			else
				$strJs.="\t\t\t".$row["COLUMN_NAME"].':$("#obj_'.$row["COLUMN_NAME"].'").val()'."\n";
		}
		$strJs.="\t\t"."}\n";
		$strJs.="\t\t"."var jsonData=JSON.stringify (jsonObj);"."\n";
		$strJs.="\t\t"."var flag=executeData(url,jsonObj,false);"."\n";
		$strJs.="\t\t"."return flag;"."\n";
		$strJs.="}\n";

		$strJs.="function updateData(){\n";
		$strJs.="\t\t".'var url=\''.$tName.'/update.php\';'."\n";
		$strJs.="\t\t"."jsonObj={\n";
		foreach ($objArr as $row) {
			$strJs.="\t\t\t".$row["COLUMN_NAME"].':$("#obj_'.$row["COLUMN_NAME"].'").val(),'."\n";
		}
		$strJs.="\t\t\t".'id:$("#obj_id").val()'."\n";
		$strJs.="\t\t"."}\n";
		$strJs.="\t\t"."var jsonData=JSON.stringify (jsonObj);"."\n";
		$strJs.="\t\t"."var flag=executeData(url,jsonObj,false);"."\n";
		$strJs.="\t\t"."return flag;"."\n";
		$strJs.="}\n";

		$strJs.="function readOne(id){\n";
		$strJs.="\t\t".'var url=\''.$tName.'/readOne.php?id=\'+id;'."\n";
		$strJs.="\t\t".'data=queryData(url);'."\n";
		$strJs.="\t\t".'if(data!=""){'."\n";
		foreach ($objArr as $row) {
			$strJs.="\t\t\t".'$("#obj_'.$row["COLUMN_NAME"].'").val(data.'.$row["COLUMN_NAME"].');'."\n";
		}
		$strJs.="\t\t\t".'$("#obj_id").val(data.id);'."\n";
		$strJs.="\t\t"."}\n";
		$strJs.="}\n";

		//*********************************
		$strJs.="function saveData(){\n";
		$strJs.="\t\t"."var flag;\n";
		$strJs.="\t\t"."flag=validInput();\n";
		$strJs.="\t\t"."if(flag==true){\n";

		$strJs.="\t\t";

		$strJs.="\t\t\t".'if($("#obj_id").val()!=""){'."\n";
		$strJs.="\t\t\t".'flag=updateData();'."\n";
		$strJs.="\t\t\t".'}else{'."\n";
		$strJs.="\t\t\t"."flag=createData();\n";
		$strJs.="\t\t"."}\n";

		$strJs.="\t\t"."if(flag==true){\n";
		$strJs.="\t\t\t"."swal.fire({\n";
		$strJs.="\t\t\t".'title: "การบันทึกข้อมูลเสร็จสมบูรณ์แล้ว",'."\n";
		$strJs.="\t\t\t".'type: "success",'."\n";
		$strJs.="\t\t\t".'buttons: [false, "ปิด"],'."\n";
		$strJs.="\t\t\t".'dangerMode: true,'."\n";
		$strJs.="\t\t".'});'."\n";
		$strJs.="\t\t".'displayData();'."\n";
		$strJs.="\t\t"."}\n";
		$strJs.="\t\t"."else{\n";
		$strJs.="\t\t\t"."swal.fire({"."\n";
		$strJs.="\t\t\t".'title: "การบันทึกข้อมูลผิดพลาด",'."\n";
		$strJs.="\t\t\t".'type: "error",'."\n";
		$strJs.="\t\t\t".'buttons: [false, "ปิด"],'."\n";
		$strJs.="\t\t\t".'dangerMode: true,'."\n";
		$strJs.="\t\t"."});\n";
		$strJs.="\t\t"."}\n";

		$strJs.="\t\t"."}else{\n";
		$strJs.="\t\t\t"."swal.fire({\n";
		$strJs.="\t\t\t".'title: "รูปแบบการกรอกข้อมูลไม่ถูกต้อง",'."\n";
		$strJs.="\t\t\t".'type: "error",'."\n";
		$strJs.="\t\t\t".'buttons: [false, "ปิด"],'."\n";
		$strJs.="\t\t\t".'dangerMode: true,'."\n";
		$strJs.="\t\t\t"."});\n";
		$strJs.="\t\t\t"."}\n";
		$strJs.="}\n";

		//*********************************
		$strJs.="function confirmDelete(id){\n";
        $strJs.="\t\t"."swal.fire({\n";
        $strJs.="\t\t\t".'title: "คุณต้องการที่จะลบข้อมูลนี้หรือไม่?",'."\n";
        $strJs.="\t\t\t".'text: "***กรุณาตรวจสอบข้อมูลให้ครบถ้วนก่อนกดปุ่มตกลง",'."\n";
        $strJs.="\t\t\t".'type: "warning",'."\n";
        $strJs.="\t\t\t".'confirmButtonText: "ตกลง",'."\n";
        $strJs.="\t\t\t".'cancelButtonText: "ยกเลิก",'."\n";
        $strJs.="\t\t\t".'showCancelButton: true,'."\n";
        $strJs.="\t\t\t".'showConfirmButton: true'."\n";
        $strJs.="\t\t".'}).then((willDelete) => {'."\n";
        $strJs.="\t\t".'if (willDelete.value) {'."\n";
        $strJs.="\t\t\t".'url="'.$tName.'/delete.php?id="+id;'."\n";
        $strJs.="\t\t\t".'executeGet(url,false,"");'."\n";
        $strJs.="\t\t\t".'displayData();'."\n";
             
       	$strJs.="\t\t".'swal.fire({'."\n";
        $strJs.="\t\t\t".'title: "ลบข้อมูลเรียบร้อยแล้ว",'."\n";
        $strJs.="\t\t\t".'type: "success",'."\n";
        $strJs.="\t\t\t".'buttons: "ตกลง",'."\n";
        $strJs.="\t\t"."});\n";

        $strJs.="\t\t"."} else {\n";
        $strJs.="\t\t\t"."swal.fire({\n";
        $strJs.="\t\t\t".'title: "ยกเลิกการทำรายการ",'."\n";
        $strJs.="\t\t\t".'type: "error",'."\n";
        $strJs.="\t\t\t".'buttons: [false, "ปิด"],'."\n";
        $strJs.="\t\t\t".'dangerMode: true,'."\n";
        $strJs.="\t\t"."})\n";
        $strJs.="\t\t"."}\n";
        $strJs.="\t\t"."});\n";
 		$strJs.="}\n";

		//*********************************

		 $strJs.="function clearData(){\n";
			 foreach ($objArr as $row) {
				$strJs.="\t\t\t".'$("#obj_'.$row["COLUMN_NAME"].'").val("");'."\n";
			}
		 $strJs.="}\n";
 		//*********************************
		$strJs.="function genCode(){\n";
		$strJs.="\t\t".'//var url="genCode.php";'."\n";
		$strJs.="\t\t".'//var data=queryData(url);'."\n";
		$strJs.="\t\t".'//return data.code;'."\n";
		$strJs.="}\n";
		//*********************************

		if(isset($tName)){
		$mediaFolder = "../".$tName;
		if(!file_exists($mediaFolder))
			mkdir($mediaFolder);
		}

		 $fp = fopen("../".$tName."/JsExecute.js", 'w');
			fwrite($fp, $strJs);
			fclose($fp);
			echo json_encode(
			        array("message" => true)
		);
?>