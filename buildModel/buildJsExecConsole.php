<h3>
	<b>Application Builder</b>
	<small>>>Create</small>
</h3>
<div class="box"></div>
<div class="col-sm-8">
<div class="box box-primary">
<div class="box-header with-border">
  <h3 class="box-title">Create JS Execute
  </h3>
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

	function buildModel(dbName,tbName){
		var url="buildModel/buildJsExec.php?dbName="+dbName+"&tableName="+tbName;
		var data=executeGet(url);

		if(data.message==true){
			
			
				swal.fire({
                    title: "Build JS",
                    text: "Create JS Execute Complete",
                    type: "success",
                    button: false
                });
			
		}else{
			swal.fire({
                    title: "Build JS",
                    text: "Create JS Execute Fail",
                    type: "error",
                    button: false
                });
		}
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
	    	if(dbName!=""&&tbName!=""){
	    		buildModel(dbName,tbName);
	    	}
	    });

	});
</script>