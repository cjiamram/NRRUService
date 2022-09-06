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
	$strCreate.='header("Access-Control-Allow-Headers: Content-Type,
	Access-Control-Allow-Headers, Authorization, X-Requested-With");'."\n";

	$strCreate.='include_once "../config/database.php";'."\n";
	$strCreate.='include_once "../objects/'. $tName.'.php' .'";'."\n";
	$strCreate.='$database = new Database();'."\n";
	$strCreate.='$db = $database->getConnection();'."\n";
	$strCreate.='$obj = new '.$tName.'($db);'."\n";
	$strCreate.='$keyWord = isset($_GET[\'keyWord\']) ? $_GET[\'keyWord\'] : ""'."\n";
	$strCreate.='$obj->displayData($keyWord);'."\n";
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

			$l=count($connArr);
			$i=1;
			$strCreate.='$arr=array();'."\n";
			$strCreate.='while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){'."\n";
			$strCreate.="\t\t".'extract($row);'."\n";
			$strCreate.="\t\t".'$item = array('."\n";
			$strCreate.="\t\t\t".'"id"=>$obj->id,'."\n";
		    foreach ($connArr as $row) {
		    		if(($i++)<$l)
		    			$strCreate.="\t\t\t".'"'.$row["COLUMN_NAME"].'" =>  $obj->'.$row["COLUMN_NAME"].','."\n";
		    		else
		    			$strCreate.="\t\t\t".'"'.$row["COLUMN_NAME"].'" =>  $obj->'.$row["COLUMN_NAME"]."\n";
		    }
		    $strCreate.=');'."\n";
			$strCreate.='array_push($arr, $item);'."\n";
			$strCreate.="}\n";
			
	}
	$strCreate.='echo(json_encode($arr));'."\n";
	$strCreate.="?>";

	if(isset($tName)){
		$mediaFolder = "../".$tName;
		if(!file_exists($mediaFolder))
			mkdir($mediaFolder);
	}

	 $fp = fopen("../".$tName."/queryData.php", 'w');
		fwrite($fp, $strCreate);
		fclose($fp);
		echo json_encode(
		        array("message" => true)
	);


?>