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
	$strCreate.='$database = new Database();'."\n";
	$strCreate.='$db = $database->getConnection();'."\n";
	$strCreate.='$obj = new '.$tName.'($db);'."\n";
	$strCreate.='$data = json_decode(file_get_contents("php://input"));'."\n";

	if($num>0){
			$connArr=array();
		    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		        extract($row);
		        $connItem=array(
		            "COLUMN_NAME" => $COLUMN_NAME,
		            "DATA_TYPE"=>$DATA_TYPE
		        );
		        array_push($connArr, $connItem);
		    }

		    foreach ($connArr as $row) {
		    	$strCreate.='$obj->'.$row["COLUMN_NAME"].' = $data->'.$row["COLUMN_NAME"].';'."\n";
		    }
		    $strCreate.='$obj->id = $data->id;'."\n";
	}

	$strCreate.='if($obj->update()){'."\n";
	$strCreate.="\t\techo json_encode(array('message'=>true));"."\n";
	$strCreate.="}\n";
	$strCreate.="else{\n";
	$strCreate.="\t\techo json_encode(array('message'=>false));"."\n";
	$strCreate.="}\n";
	$strCreate.="?>";




	if(isset($tName)){
		$mediaFolder = "../".$tName;
		if(!file_exists($mediaFolder))
			mkdir($mediaFolder);
	}

	 $fp = fopen("../".$tName."/update.php", 'w');
		fwrite($fp, $strCreate);
		fclose($fp);
		echo json_encode(
		        array("message" => true)
	);


?>