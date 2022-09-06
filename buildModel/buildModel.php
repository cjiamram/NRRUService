<?php
// required headers
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: GET");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	 
	// get database connection
	include_once '../config/database.php';
	include_once '../objects/createModel.php';


	 
	$database = new Database();
	$db = $database->getConnection();
	 
	$conn = new CreateModel($db);
	//print_r($conn);
	$tableName=isset($_GET["tableName"])?$_GET["tableName"]:"";
	$dbName=isset($_GET["dbName"])?$_GET["dbName"]:"";
	$conn->table_name=$tableName;
	$conn->db_name=$dbName;
	$stmt= $conn->getSchema();
	$num = $stmt->rowCount();
		
		if($num>0){
		 	$modelStr="<?php\n";
		    $connArr=array();
		    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		        extract($row);
		 
		        $connItem=array(
		            "COLUMN_NAME" => $COLUMN_NAME,
		            "DATA_TYPE"=>$DATA_TYPE
		        );
		        array_push($connArr, $connItem);
		    }

		    $tName=str_replace("_", "", $tableName);
		    //print_r($tName);
		    $modelStr.='include_once "keyWord.php";'."\n";
		    $modelStr.='class  '.$tName.'{'."\n";
		    $modelStr.="\t".'private $conn;'."\n";
        	$modelStr.="\t".'private $table_name="'.$tableName.'";'."\n";
        	$modelStr.="\t".'public function __construct($db){
            $this->conn = $db;
        	}'."\n";


        	foreach ($connArr as $row) {
        		$modelStr.="\t".'public $'.$row["COLUMN_NAME"].';'."\n";
        	}
        	//***********CREATE***************
        	$modelStr.="\t".'public function create(){'."\n";
        	$modelStr.="\t\t".'$query=\'INSERT INTO '.$tableName.'  
        	SET '."\n";
        	$l=count($connArr);
        	$i=1;
        	foreach ($connArr as $row) {
        		if(($i++)<$l)
        			$modelStr.="\t\t\t".$row["COLUMN_NAME"].'=:'.$row["COLUMN_NAME"].','."\n";
        		else
        			$modelStr.="\t\t\t".$row["COLUMN_NAME"].'=:'.$row["COLUMN_NAME"]."\n";
        	}
        	

        	$modelStr.="\t".'\';'."\n";
        	$modelStr.="\t\t".'$stmt = $this->conn->prepare($query);'."\n";
        	foreach ($connArr as $row) {
        		$modelStr.="\t\t".'$stmt->bindParam(":'.$row["COLUMN_NAME"].'",$this->'.$row["COLUMN_NAME"].');'."\n";
        	}
        	$modelStr.="\t\t".'$flag=$stmt->execute();'."\n";
        	$modelStr.="\t\t".'return $flag;'."\n";
        	$modelStr.="\t".'}'."\n";	
		    
		    //***********END CREATE***************

		    //***********UPDATE*******************
        	$modelStr.="\t".'public function update(){'."\n";
        	$modelStr.="\t\t".'$query=\'UPDATE '.$tableName.' 
        	SET '."\n";
        	$i=1;
        	foreach ($connArr as $row) {
        		if(($i++)<$l)
        			$modelStr.="\t\t\t".$row["COLUMN_NAME"].'=:'.$row["COLUMN_NAME"].','."\n";
        		else
        			$modelStr.="\t\t\t".$row["COLUMN_NAME"].'=:'.$row["COLUMN_NAME"]."\n";
        	}		
        	$modelStr.="\t\t".' WHERE id=:id\';'."\n";
        	$modelStr.="\t\t".'$stmt = $this->conn->prepare($query);'."\n";
        	foreach ($connArr as $row) {
        		$modelStr.="\t\t".'$stmt->bindParam(":'.$row["COLUMN_NAME"].'",$this->'.$row["COLUMN_NAME"].');'."\n";
        	}
        	$modelStr.="\t\t".'$stmt->bindParam(":id",$this->id);'."\n";
        	$modelStr.="\t\t".'$flag=$stmt->execute();'."\n";
        	$modelStr.="\t\t".'return $flag;'."\n";
        	$modelStr.="\t".'}'."\n";	
		    
		    //***********END UPDATE******************

		    //***********READ ONE********************
		    $modelStr.="\t".'public function readOne(){'."\n";
		    $modelStr.="\t\t".'$query=\'SELECT  id,'."\n";
		    $i=1;
		    foreach ($connArr as $row) {
		    	if(($i++)<$l)
		    		$modelStr.="\t\t\t".$row["COLUMN_NAME"].','."\n";
		    	else
		    		$modelStr.="\t\t\t".$row["COLUMN_NAME"]."\n";
		    }
		    $modelStr.="\t\t".'FROM '.$tableName.' WHERE id=:id\';'."\n";
		    $modelStr.="\t\t".'$stmt = $this->conn->prepare($query);'."\n";
		    $modelStr.="\t\t".'$stmt->bindParam(\':id\',$this->id);'."\n";
        	$modelStr.="\t\t".'$stmt->execute();'."\n";
        	$modelStr.="\t\t".'return $stmt;'."\n";
		    $modelStr.="\t".'}';
		    $modelStr.="\n";

		    //***********END READ ONE****************

		    //***********DISPLAY DATA ONE************
		    $modelStr.="\t".'public function getData($keyWord){'."\n";
		    $modelStr.="\t\t".'$key=KeyWord::getKeyWord($this->conn,$this->table_name);'."\n";
		    $modelStr.="\t\t".'$key=($key!="")?$key:"keyWord";'."\n";

		    $modelStr.="\t\t".'$query=\'SELECT  id,'."\n";
		    $i=1;
		    foreach ($connArr as $row) {
		    	if(($i++)<$l)
		    		$modelStr.="\t\t\t".$row["COLUMN_NAME"].','."\n";
		    	else
		    		$modelStr.="\t\t\t".$row["COLUMN_NAME"]."\n";
		    }
		    $modelStr.="\t\t".'FROM '.$tableName.' WHERE \'.$key.\' LIKE :keyWord\';'."\n";
		    $modelStr.="\t\t".'$stmt = $this->conn->prepare($query);'."\n";
		    $modelStr.="\t\t".'$keyWord="%{$keyWord}%";'."\n";
		    $modelStr.="\t\t".'$stmt->bindParam(\':keyWord\',$keyWord);'."\n";
        	$modelStr.="\t\t".'$stmt->execute();'."\n";
        	$modelStr.="\t\t".'return $stmt;'."\n";
		    $modelStr.="\t".'}';
		    //***********END DISPLAY DATA ONE********

		    //**************DELETE ******************
		    $modelStr.="\n\t".'function delete(){'."\n";
		    $modelStr.="\t\t".'$query=\'DELETE FROM '.$tableName.' WHERE id=:id\';'."\n";
		    $modelStr.="\t\t".'$stmt = $this->conn->prepare($query);'."\n";
		    $modelStr.="\t\t".'$stmt->bindParam(\':id\',$this->id);'."\n";
		    $modelStr.="\t\t".'$flag=$stmt->execute();'."\n";
		    $modelStr.="\t\t".'return $flag;'."\n";
		    $modelStr.="\t".'}'."\n";
		    //***********END DELETE *****************


		    //***********GEN CODE *******************
		    $modelStr.="\t".'public function genCode(){'."\n";
		    $modelStr.="\t\t".'$curYear = date("Y")-2000+543;'."\n";
		    $modelStr.="\t\t".'$curYear = substr($curYear,1,2);'."\n"; 
		    $modelStr.="\t\t".'$curYear = sprintf("%02d", $curYear);'."\n"; 
		    $modelStr.="\t\t".'$curMonth=date("n");'."\n";
		    $modelStr.="\t\t".'$curMonth = sprintf("%02d",$curMonth);'."\n";
		    $modelStr.="\t\t".'$prefix= $curYear .$curMonth;'."\n";
		    $modelStr.="\t\t".'$query ="SELECT MAX(CODE) AS MXCode FROM '.$tableName.' WHERE CODE LIKE ?";'."\n";
		    $modelStr.="\t\t".'$stmt = $this->conn->prepare($query);'."\n";
		    $modelStr.="\t\t".'$prefix="{$prefix}%";'."\n";
		    $modelStr.="\t\t".'$stmt->bindParam(1, $prefix);'."\n";
		    $modelStr.="\t\t".'$stmt->execute();'."\n";
		    $modelStr.="\t\t".'return $stmt;'."\n";
		    $modelStr.="\t"."}\n";

		    //***********End GEN CODE****************
		    $modelStr.="}\n";
		    $modelStr.="\n?>";
		    
			$fp = fopen("../objects/".$tName.".php", 'w');
			fwrite($fp, $modelStr);
			fclose($fp);
			 echo json_encode(
		        array("message" => true)
		    );

		}
		 
		else{
		    echo json_encode(
		        array("message" => false)
		    );
		}

?>