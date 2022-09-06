<?php
	include_once '../config/database.php';
	include_once '../objects/createModel.php';

	$tableName=isset($_GET["tableName"])?$_GET["tableName"]:"";
	$dbName=isset($_GET["dbName"])?$_GET["dbName"]:"";
	$tName=str_replace("_", "", $tableName);

	$database = new Database();
	$db = $database->getConnection();
	$conn = new CreateModel($db);

	/*$conn->table_name=$tableName;
	$conn->db_name=$dbName;
	$stmt= $conn->getSchema();
	$num = $stmt->rowCount();*/

	


	$strCreate="<?php\n";
	$strCreate.='header("Access-Control-Allow-Origin: *");'."\n";
	$strCreate.='header("Content-Type: application/json; charset=UTF-8");'."\n";
	$strCreate.='header("Access-Control-Allow-Methods: POST");'."\n";
	$strCreate.='header("Access-Control-Max-Age: 3600");'."\n";
	$strCreate.='header("Access-Control-Allow-Headers: Content-Type,
	Access-Control-Allow-Headers, Authorization, X-Requested-With");'."\n";

	$strCreate.='include_once "../config/database.php";'."\n";
	$strCreate.='include_once "../objects/'. $tName.'.php' .';"'."\n";
	$strCreate.='$database = new Database();'."\n";
	$strCreate.='$db = $database->getConnection();'."\n";
	$strCreate.='$obj = new '.$tName.'($db);'."\n";
	$strCreate.='$data = json_decode(file_get_contents("php://input"));'."\n";
	$strCreate.='$code=$obj->genCode();'."\n";
	$strCreate.='echo json_encode(
		        array("code" => $code)
	);'."\n";
	
	$strCreate.="?>";

	if(isset($tName)){
		$mediaFolder = "../".$tName;
		if(!file_exists($mediaFolder))
			mkdir($mediaFolder);
	}

	 $fp = fopen("../".$tName."/genCode.php", 'w');
		fwrite($fp, $strCreate);
		fclose($fp);
		echo json_encode(
		        array("message" => true)
	);
?>