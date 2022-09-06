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
	$connArr=array();
	if($num>0){
			
		    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		        extract($row);
		        $connItem=array(
		            "COLUMN_NAME" => $COLUMN_NAME,
		            "DATA_TYPE"=>$DATA_TYPE
		        );
		        array_push($connArr, $connItem);
		    }
	}

	$strCreate="<?php\n";
	$strCreate.='include_once "../config/config.php";'."\n";
	$strCreate.='include_once "../lib/classAPI.php";'."\n";
	$strCreate.='include_once "../config/database.php";'."\n";
	$strCreate.='include_once "../objects/classLabel.php";'."\n";
	$strCreate.='header("Access-Control-Allow-Origin: *");'."\n";
	$strCreate.='header("Content-Type: application/json; charset=UTF-8");'."\n";
	$strCreate.='header("Access-Control-Allow-Methods: POST");'."\n";
	$strCreate.='header("Access-Control-Max-Age: 3600");'."\n";
	$strCreate.='header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");'."\n";
	$strCreate.='$database = new Database();'."\n";
	$strCreate.='$db = $database->getConnection();'."\n";
	$strCreate.='$objLbl = new ClassLabel($db);'."\n";
	$strCreate.='$cnf=new Config();'."\n";
	$strCreate.='$keyword=isset($_GET["keyWord"])?$_GET["keyWord"]:"";'."\n";
 	$strCreate.='$path="'.$tName.'/getData.php?keyWord=".$keyword;'."\n";
 	$strCreate.='$url=$cnf->restURL.$path;'."\n";
 	$strCreate.='$api=new ClassAPI();'."\n";
 	$strCreate.='$data=$api->getAPI($url);'."\n";

 	$strCreate.='echo "<thead>";'."\n";
 	$strCreate.="\t\t".'echo "<tr>";'."\n";
 	$strCreate.="\t\t\t".'echo "<th>No.</th>";'."\n";

 	if($num>0){
 		foreach ($connArr as $row) {
 			$s='$objLbl->getLabel("'.$tableName.'","'.$row["COLUMN_NAME"].'","TH")';
 			$strCreate.="\t\t\t".'echo "<th>".'.$s.'."</th>";'."\n";
 		}
 		
 	}
 	$strCreate.="\t\t\t".'echo "<th>จัดการ</th>";'."\n";
 	$strCreate.="\t\t".'echo "</tr>";'."\n";
 	$strCreate.='echo "</thead>";'."\n";
 	$strCreate.='if($data!=""){'."\n";
 	$strCreate.='echo "<tbody>";'."\n";
 	$strCreate.='$i=1;'."\n";
 	$strCreate.='foreach ($data as $row) {'."\n";
 	$strCreate.="\t\t".'echo "<tr>";'."\n";
 	$strCreate.="\t\t\t".'echo \'<td>\'.$i++.\'</td>\';'."\n";
 	if($num>0){
 		foreach ($connArr as $row) {
 			$strCreate.="\t\t\t".'echo \'<td>\'.$row["'.$row["COLUMN_NAME"].'"].\'</td>\';'."\n";
 		}
 		
 	}
 


 	$strBtn ="\n\t\t\t".'<button type=\'button\' class=\'btn btn-info\''."\n"; 
 	$strBtn.="\t\t\t\t".'data-toggle=\'modal\' data-target=\'#modal-input\''."\n";
 	$strBtn.="\t\t\t\t".'onclick=\'readOne(".$row[\'id\'].")\'>'."\n";
 	$strBtn.="\t\t\t\t".'<span class=\'fa fa-edit\'></span>'."\n";
 	$strBtn.="\t\t\t".'</button>'."\n";
 	$strBtn.="\t\t\t".'<button type=\'button\''."\n";
 	$strBtn.="\t\t\t\t".'class=\'btn btn-danger\''."\n";
 	$strBtn.="\t\t\t\t".'onclick=\'confirmDelete(".$row[\'id\'].")\'>'."\n";
 	$strBtn.="\t\t\t\t".'<span class=\'fa fa-trash\'></span>'."\n";
 	$strBtn.="\t\t\t".'</button>';
 	
 	$strCreate.="\t\t\t".'echo "<td>'.$strBtn.'</td>";'."\n";
 	$strCreate.="\t\t\t".'echo "</tr>";'."\n";
 	$strCreate.='}'."\n";
 	$strCreate.='echo "</tbody>";'."\n";	
 	$strCreate.='}'."\n";
	$strCreate.="?>\n";

	if(isset($tName)){
		$mediaFolder = "../".$tName;
		if(!file_exists($mediaFolder))
			mkdir($mediaFolder);
	}

	 	$fp = fopen("../".$tName."/displayData.php", 'w');
		fwrite($fp, $strCreate);
		fclose($fp);
		echo json_encode(
		        array("message" => true)
	);


?>