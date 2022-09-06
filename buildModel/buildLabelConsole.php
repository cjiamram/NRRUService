 <h3>
        <b>Application Builder</b>
        <small>>>Input Label</small>
      </h3>
<input type="hidden" id="obj_id" value="">
<div class="box"></div>
<div class="col-sm-8">
<div class="box box-primary">
<div class="box-header with-border">
  <h3 class="box-title">Input Label</h3>
</div>
 <div class="box-body">
 <table class="table table-bordered table-hover">
 	<tr>
 	<td>
		<div class="form-group">
		<label class="col-sm-12">Database Name:</label>
		<div class="col-sm-12">
			<select class="form-control" id="obj_dbName"></select>
		</div>
		</div>
		<div class="form-group">
		<label class="col-sm-12">Table Name:</label>
		<div class="col-sm-12">
			<select class="form-control" id="obj_tbName"></select>
		</div>
		</div>
		<div class="form-group">
		<label class="col-sm-12">Field Name:</label>
		<div class="col-sm-12">
			<table width="100%">
				<tr>
					<td>
						<input type="hidden" id="obj_checkVal" value="1" >
						<input type="checkbox" checked="true" id="chkOption">
						Use DB Field: 
					</td>
				</tr>
				<tr>
					<td>
						<div id="dvField" >
						<select class="form-control" id="obj_fieldName"></select>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div id="dvLabelField" >
						<input type="text" id="obj_Label" class="form-control">
						<div>
					</td>
				</tr>

			</table>
		</div>
		</div>
 	</td>
 	</tr>

 	<tr>
 		<td>
 			<div class="col-sm-2">
 				<label class="col-sm-12">Label TH</label>
 			</div>
 			<div class="col-sm-4">
 				<input class="form-control" id="obj_LabelTH">
 			</div>
 			<div class="col-sm-2">
 				<label class="col-sm-12">Label EN</label>
 			</div>
 			<div class="col-sm-4">
 				<input class="form-control" id="obj_LabelEN">
 			</div>

 		</td>
 	</tr>
 	<tr>
 		<td>
		<div class="form-group">
		<div class="col-sm-12">
			<a id="btnBuild" class="btn btn-primary" id="btnCreateModel" ><i class="fa fa-save" >&nbsp;&nbsp;&nbsp;Save</i></a>
		</div>
		</div>
 		</td>
 	</tr>
 	<tr>
 	<td>
 	<div id="dvLabel" class="col-sm-12" style="width:10;height:350px;overflow:scroll">
 	</div>
 	</td>
 	</tr>
 </table>	



</div>
</div>

</div>
<?php
	include_once "../config/config.php";
	$cnf=new Config();
	$path=$cnf->path;
?>
<script>
	var path='<?php echo $path ?>';
	function getDbList(){
		var url="buildModel/getDbList.php";
		setDDL(url,"#obj_dbName");
	}

	function getTbList(dbName){
		var url="buildModel/getTbList.php?dbName="+dbName;
		console.log(url);
		setDDL(url,"#obj_tbName");
	}

	function getFiledList(dbName){
		var url="buildModel/getFieldList.php?dbName="+dbName+"&tbName="+$("#obj_tbName").val();
		console.log(url);
		setDDL(url,"#obj_fieldName");
	}


	function getId(){
		var url=path+"/tlabel/getId.php?tableName="+$("#obj_tbName").val()+"&fieldName="+$("#obj_fieldName").val();
		console.log(url);
		data=executeGet(url);
		return data.id;
	}

	function clearLabel(){
		$("#obj_LabelTH").val("");
		$("#obj_LabelEN").val("");
		$("#obj_id").val("");
	}

	function displayData(){
		var url=path+"/tlabel/getData?";
	}

	function readOne(id){
		var url=path +"/tlabel/readOne.php?id="+id;
		var data=queryData(url);
		if(data!=""){
			$("#obj_id").val(data.id);
			$("#obj_LabelTH").val(data.thLabel);
			$("#obj_LabelEN").val(data.enLabel);
			
			$("#obj_fieldName").val(data.fieldName);
			$("#obj_Label").val(data.fieldName);

			if(data.flag==1){
				$("#obj_checkVal").val("1");
				$('#dvField').show();
			    $('#dvLabelField').hide();
			    $('#chkOption').prop('checked', true);
			    
			}
			else
			{
				$("#obj_checkVal").val("0");
				$('#dvField').hide();
			    $('#dvLabelField').show();
			    $('#chkOption').prop('checked', false);
			    
			}

		}

	}



	function createLabel(){
		var url =path+"/tlabel/create.php";

		var fieldName=$("#obj_fieldName").val();
		var flag;
		if($("#obj_checkVal").val()=="1"){
			fieldName=$("#obj_fieldName").val();
			flag=1;
		}
		else{
			fieldName=$("#obj_Label").val();
			flag=0;
		}

		jsonObj={
			tableName:$("#obj_tbName").val(),
			fieldName:fieldName,
			thLabel:$("#obj_LabelTH").val(),
			enLabel:$("#obj_LabelEN").val(),
			flag:flag
		}

		console.log(url);

		var jsonData=JSON.stringify (jsonObj);
		console.log(jsonData);
		var flag=executeData(url,jsonObj,false);
		return flag;
	}

	function updateLabel(id){
		var url =path+"/tlabel/update.php";
		var fieldName=$("#obj_fieldName").val();
		var flag;
		if($("#obj_checkVal").val()=="1"){
			fieldName=$("#obj_fieldName").val();
			flag=1;
		}
		else{
			fieldName=$("#obj_Label").val();
			flag=0;
		}

		jsonObj={
			tableName:$("#obj_tbName").val(),
			fieldName:fieldName,
			thLabel:$("#obj_LabelTH").val(),
			enLabel:$("#obj_LabelEN").val(),
			flag:flag,
			id:id
		}

		var jsonData=JSON.stringify (jsonObj);
		var flag=executeData(url,jsonObj,false);
		return flag;
	}


	function displayLabel(){
		var url=path+"/tlabel/displayData.php?tableName="+$("#obj_tbName").val() ;
		$("#dvLabel").load(url);
	}

	function saveLabel(){
		var id=getId();
		//console.log(id);
		var flag;
		if(id!=""){
			flag=updateLabel(id);
		}else
		{
			flag=createLabel();
		}
		if(flag==true){
			 clearLabel();
			 swal.fire({
                    title: "Create View",
                    text: "Save Label Complete",
                    type: "success",
                    button: false
                });
		}
		else
		{
			 swal.fire({
                    title: "Create View",
                    text: "Save Label Error",
                    type: "error",
                    button: false
                });
		}
		displayLabel();
	}

	function buildModel(dbName,tbName){
		var url="buildModel/buildInput.php?dbName="+dbName+"&tableName="+tbName;
		var data=executeGet(url);
		if(data.message==true){
			 swal.fire({
                    title: "Build View",
                    text: "Create Input Complete",
                    type: "success",
                    button: false
                });
		}else{
			swal.fire({
                    title: "Build View",
                    text: "Create Input Fail",
                    type: "error",
                    button: false
                });

		}
	}


	$( document ).ready(function() {
	    getDbList();
	    getTbList($("#obj_dbName").val());
	   	getFiledList($("#obj_dbName").val());

	   	$('#dvField').show();
	    $('#dvLabelField').hide();

	   

		$('#chkOption').on('click',function(){
			   if(this.checked){
			     $('#dvField').show();
			     $('#dvLabelField').hide();
			     $("#obj_checkVal").val("1");
			   }else
			   {
			   	 $('#dvField').hide();
			     $('#dvLabelField').show();
			     $("#obj_checkVal").val("0");
			   }
		});

	    $("#obj_dbName").change(function(){
	    	getTbList($("#obj_dbName").val());
	    	getFiledList($("#obj_dbName").val());
	    });

	   

	    $("#obj_tbName").change(function(){
	    	getFiledList($("#obj_dbName").val());
	    	displayLabel();
	    });



	    $("#btnBuild").click(function(){
	    	var dbName=$("#obj_dbName").val();
	    	var tbName=$("#obj_tbName").val();
	    	if(dbName!=""&&tbName!="")
	    		{saveLabel();}
	    });

	});
</script>