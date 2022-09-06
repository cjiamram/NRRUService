 <h3>
        <b>Application Builder</b>
        <small>>>Create</small>
      </h3>
<div class="box"></div>
<div class="col-sm-8">
<div class="box box-primary">
<div class="box-header with-border">
  <h3 class="box-title">Create Controller</h3>
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
		<div class="col-sm-12">
			<div class="col-sm-2">
				<input type="checkbox" checked="true" class="form-check-input" id="chkCreate">
    			<label class="form-check-label" for="chkCreate">Build Create</label>
			</div>
			<div class="col-sm-2">
				<input type="checkbox" checked="true" class="form-check-input" id="chkUpdate">
    			<label class="form-check-label" for="chkUpdate">Build Update</label>
			</div>
			<div class="col-sm-2">
				<input type="checkbox" checked="true" class="form-check-input" id="chkReadone">
    			<label class="form-check-label" for="chkReadone">Build ReadOne</label>
			</div>
			<div class="col-sm-2">
				<input type="checkbox" checked="true" class="form-check-input" id="chkDisplay">
    			<label class="form-check-label" for="chkDisplay">Build Display</label>
			</div>
			
			<div class="col-sm-2">
				<input type="checkbox" checked="true" class="form-check-input" id="chkDelete">
    			<label class="form-check-label" for="chkDelete">Build Delete</label>
			</div>
		</div>
		</div>
		</div>
 	</td>
 	</tr>
 	<tr>
 		<td>
		<div class="form-group">
		<div class="col-sm-12">
			<a id="btnBuild" class="btn btn-primary" id="btnCreateModel" ><i class="fa fa-save" >&nbsp;&nbsp;&nbsp;Build</i></a>
		</div>
		</div>
 		</td>
 	</tr>
 </table>	



</div>
</div>

</div>
<script>
	function getDbList(){
		var url="buildModel/getDbList.php";
		setDDL(url,"#obj_dbName");
	}

	function getTbList(dbName){
		var url="buildModel/getTbList.php?dbName="+dbName;
		setDDL(url,"#obj_tbName");
	}

	function buildController(dbName,tbName,buildType){
		var url="";
		switch(buildType){
			case 1:{
					url="buildModel/buildCreate.php?dbName="+dbName+"&tableName="+tbName;
			}
			break;
			case 2:{
					url="buildModel/buildUpdate.php?dbName="+dbName+"&tableName="+tbName;
			}
			break;
			case 3:{
					
					url="buildModel/buildReadOne.php?dbName="+dbName+"&tableName="+tbName;
			}
			break;
			case 4:{
					url="buildModel/buildGetData.php?dbName="+dbName+"&tableName="+tbName;
			}
			break;
			

			case 5:{
					url="buildModel/buildDelete.php?dbName="+dbName+"&tableName="+tbName;
			}
			break;

		}

		var data=executeGet(url);
		//console.log(data);
		return data.message;
	}


	$( document ).ready(function() {
	    getDbList();
	    getTbList($("#obj_dbName").val());

	    $("#obj_dbName").change(function(){
	    	getTbList($("#obj_dbName").val());
	    });

	    $("#btnBuild").click(function(){
	    	var dbName=$("#obj_dbName").val();
	    	var tbName=$("#obj_tbName").val();
	    	var flag=true;
	    	if(dbName!=""&&tbName!=""){
	    	//*******************	
	    			if($("#chkCreate").is(":checked"))
	    			{
	    				flag&=buildController(dbName,tbName,1);
	    				if(flag==false){
	    					swal.fire({
                            title: "Build Controller",
                            text: "Build Create Fail.",
                            type: "error",
                            button: false,
                        	});
                        	return;
	    				}

	    			}
	    			
	    			if($("#chkUpdate").is(":checked"))
	    			{
	    				flag&=buildController(dbName,tbName,2);
	    				if(flag==false){
	    					swal.fire({
                            title: "Build Controller",
                            text: "Build Update Fail.",
                            type: "error",
                            button: false,
                        	});
                        	return;
	    				}

	    			}
	    			
	    			if($("#chkReadone").is(":checked"))
	    			{
	    				flag&=buildController(dbName,tbName,3);
	    				if(flag==false){
	    					swal.fire({
                            title: "Build Controller",
                            text: "Build ReadOne Fail.",
                            type: "error",
                            button: false,
                        	});
                        	return;
	    				}
	    			}
	    			
	    			if($("#chkDisplay").is(":checked"))
	    			{
	    				flag&=buildController(dbName,tbName,4);
	    				if(flag==false){
	    					swal.fire({
                            title: "Build Controller",
                            text: "Build Display Data Fail.",
                            type: "error",
                            button: false,
                        	});
                        	return;
	    				}
	    			}
	    			

	    			if($("#chkDelete").is(":checked"))
	    			{
	    				flag&=buildController(dbName,tbName,5);
	    				if(flag==false){
	    					swal.fire({
                            title: "Build Controller",
                            text: "Build Delete Fail.",
                            type: "error",
                            button: false,
                        	});
                        	return;
	    				}
	    			}

	    			if(flag==true){
	    				swal.fire({
                            title: "Build Controller",
                            text: "Build Success.",
                            type: "success",
                            button: false,
                        	});
                        	return;
	    			}


	    	//*******************
	    	}
	    });

	});
</script>