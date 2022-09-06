<?php
	include_once '../config/database.php';
	include_once '../objects/createModel.php';

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


	$strCreate="<?php\n";
	$strCreate.='header("Access-Control-Allow-Origin: *");'."\n";
	$strCreate.='header("Content-Type: application/json; charset=UTF-8");'."\n";
	$strCreate.='header("Access-Control-Allow-Methods: POST");'."\n";
	$strCreate.='header("Access-Control-Max-Age: 3600");'."\n";
	$strCreate.='header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");'."\n";
	$strCreate.='include_once "../config/database.php";'."\n";
	$strCreate.='include_once "../objects/'. $tName.'.php' .'";'."\n";
	$strCreate.='include_once "../objects/classLabel.php' .'";'."\n";
	$strCreate.='$database = new Database();'."\n";
	$strCreate.='$db = $database->getConnection();'."\n";
	$strCreate.='$objLbl = new ClassLabel($db);'."\n";
	$strCreate.='?>'."\n";
	$connArr=array();
	if($num>0){
			
		    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		        extract($row);
		        $connItem=array(
		            "COLUMN_NAME" => $COLUMN_NAME,
		            "DATA_TYPE"=>$DATA_TYPE,
		            "COLUMN_COMMENT"=>$COLUMN_COMMENT
		        );
		        array_push($connArr, $connItem);
		    }
	}
	$strCreate.='<form role=\'form\'>'."\n";
	$strCreate.= '<div class="box-body">'."\n";
	foreach ($connArr as $row) {
			$comment=$row["COLUMN_COMMENT"];
			$strCreate.= "\t\t".'<div class=\'form-group\'>'."\n";
			$strCreate.= "\t\t\t".'<label class="col-sm-12"><?php echo $objLbl->getLabel("'.$tableName.'","'.$row["COLUMN_NAME"].'","th").":" ?></label>'."\n";
			$strCreate.= "\t\t\t"."<div class=\"col-sm-12\">\n";
			switch ($comment){
				case "droptdown":{
						$strCreate.= "\t\t\t\t".'<select class="form-control" id=\'obj_'.$row["COLUMN_NAME"].'\'></select>'."\n";
				}
				break;
				case "time":{
						$strCreate.="\t\t\t\t".'<input  
						class="form-control" type="time" id="obj_'.$row["COLUMN_NAME"].'" 
						placeholder="00:00">'."\n";
				}
				break;
				case "number":{
						$strCreate.="\t\t\t\t".'<input  
						class="form-control" type="number" id="obj_'.$row["COLUMN_NAME"].'" 
						placeholder="00:00">'."\n";
				}
				break;
				case "email":{
						$strCreate.="\t\t\t\t".'<input  
						class="form-control" type="email" id="obj_'.$row["COLUMN_NAME"].'" 
						placeholder="sample@mail.com">'."\n";
				}
				break;
				case "tel":{
						$strCreate.="\t\t\t\t".'<input  
						class="form-control" type="tel" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" id="obj_'.$row["COLUMN_NAME"].'" 
						>'."\n";
				}
				break;
				case "file":{
						$strCreate.="\t\t\t\t".'<input  
						class="form-control" type="file" class="form-control-file"  id="obj_'.$row["COLUMN_NAME"].'" 
						>'."\n";
				}
				break;
				case "checkBox":{
						$strCreate.="\t\t\t\t".'<input  
						class="form-control" type="checkbox" checked="1" class="form-control-file"  id="obj_'.$row["COLUMN_NAME"].'" 
						>'."\n";
				}
				break;
				case "color":{
						$strCreate.="\t\t\t\t".'<input  
						class="form-control" type="color"   id="obj_'.$row["COLUMN_NAME"].'" 
						>'."\n";
				}
				break;
				case "password":{
						$strCreate.="\t\t\t\t".'<input  
						class="form-control" type="password" placeholder="Password" id="obj_'.$row["COLUMN_NAME"].'" 
						>'."\n";
				}
				break;
				case "datelocal":{
						$strCreate.="\t\t\t\t".'<div class="input-group date">'."\n";
                      	$strCreate.="\t\t\t\t".'<div class="input-group-addon">'."\n";
                        $strCreate.="\t\t\t\t".'<i class="fa fa-calendar"></i>'."\n";
                      	$strCreate.="\t\t\t\t".'</div>'."\n";
                        $strCreate.="\t\t\t\t".'<input type="datetime-local" class="form-control" id="obj_'.$row["COLUMN_NAME"].'">'."\n";
                      	$strCreate.="\t\t\t\t".'</div>'."\n"; 
				}
				break;
				default:{
					$dType=$row["DATA_TYPE"];
					switch ($dType) {
					case 'varchar':{
							$strCreate.= "\t\t\t\t".'<input type="text" 
							class="form-control" id=\'obj_'.$row["COLUMN_NAME"].'\' 
							placeholder=\''.$row["COLUMN_NAME"].'\'>'."\n";
						}
					break;
					case 'datetime':{
							$strCreate.="\t\t\t\t".'<div class="input-group date">'."\n";
                      		$strCreate.="\t\t\t\t".'<div class="input-group-addon">'."\n";
                        	$strCreate.="\t\t\t\t".'<i class="fa fa-calendar"></i>'."\n";
                      		$strCreate.="\t\t\t\t".'</div>'."\n";
                        	$strCreate.="\t\t\t\t".'<input type="date" class="form-control" id="obj_'.$row["COLUMN_NAME"].'">'."\n";
                      		$strCreate.="\t\t\t\t".'</div>'."\n";  
						}
					break;
					default:{
							$strCreate.= "\t\t\t\t".'<input type="text" 
							class="form-control" id=\'obj_'.$row["COLUMN_NAME"].'\' 
							placeholder=\''.$row["COLUMN_NAME"].'\'>'."\n";
						}
					break;
					}
				}
				break;
			}
			$strCreate.="\t\t\t"."</div>\n";		
			$strCreate.= "\t\t".'</div>'."\n";
		}
	$strCreate.= '</div>'."\n";
	$strCreate.='</form>'."\n";

	
	

	if(isset($tName)){
		$mediaFolder = "../".$tName;
		if(!file_exists($mediaFolder))
			mkdir($mediaFolder);
	}

	 $fp = fopen("../".$tName."/input.php", 'w');
		fwrite($fp, $strCreate);
		fclose($fp);
		echo json_encode(
		        array("message" => true)
	);

?>