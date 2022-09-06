<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../config/database.php";
include_once "../objects/tmenu.php";
include_once "../objects/classLabel.php";
$database = new Database();
$db = $database->getConnection();
$objLbl = new ClassLabel($db);
?>
<form role='form'>
<div class="box-body">
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_menu","MenuId","th").":" ?></label>
			<div class="col-sm-12">
				<input type="text" 
							class="form-control" id='obj_MenuId' 
							placeholder='MenuId'>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_menu","MenuName","th").":" ?></label>
			<div class="col-sm-12">
				<input type="text" 
							class="form-control" id='obj_MenuName' 
							placeholder='MenuName'>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_menu","Link","th").":" ?></label>
			<div class="col-sm-12">
				<input type="text" 
							class="form-control" id='obj_Link' 
							placeholder='Link'>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_menu","Topic","th").":" ?></label>
			<div class="col-sm-12">
				<input type="text" 
							class="form-control" id='obj_Topic' 
							placeholder='Topic'>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_menu","Parent","th").":" ?></label>
			<div class="col-sm-12">
				<!--<input type="text" 
							class="form-control" id='obj_Parent' 
							placeholder='Parent'>-->
				<select class="form-control" id="obj_Parent">
				</select>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_menu","LevelNo","th").":" ?>/<?php echo $objLbl->getLabel("t_menu","OrderNo","th").":" ?></label>
			<div class="col-sm-12">
			<table width="50%">
			<tr>
				<td width="49%">
					<input type="text" 
							class="form-control" id='obj_LevelNo' 
							placeholder='LevelNo'>
				</td>
				<td>-
				</td>
				<td width="49%">
					<input type="text" 
							class="form-control" id='obj_OrderNo' 
							placeholder='OrderNo'>
				</td>
			</tr>
			</table>
			</div>
		</div>
		<div class='form-group'>
			<label class="col-sm-12"></label>
			<div class="col-sm-12">
				
			</div>
		</div>
		
		
		<div class='form-group'>
			<label class="col-sm-12"><?php echo $objLbl->getLabel("t_menu","enableDefault","th").":" ?></label>
			<div class="col-sm-12">
				<table width="25%">
				<tr>
					<td>
						<input type="text" 
							class="form-control" id='obj_enableDefault' 
							placeholder='enableDefault'>
					</td>
				</tr>
				</table>
				
			</div>
		</div>
</div>
</form>
<script>
function listHeadMenu(){
    var url="/NRRUServiceOnline/tmenu/listHeader.php";
    setDDLPrefix(url,"#obj_Parent","***Parent Menu***");
 }

 $(document).ready(function(){
 	listHeadMenu();
 })

</script>
