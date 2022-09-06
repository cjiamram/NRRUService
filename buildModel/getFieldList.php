<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/createModel.php';
 
$database = new Database();
$db = $database->getConnection();
 
$con = new CreateModel($db);
 

$dbName=isset($_GET["dbName"])?$_GET["dbName"]:"";
$tbName=isset($_GET["tbName"])?$_GET["tbName"]:"";

$stmt = $con->getFieldList($dbName,$tbName);
$num = $stmt->rowCount();


if($num>0){
        $conArr=array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $conItem=array(
        	"ID"=>$COLUMN_NAME,
        	"Field_ID"=>$COLUMN_NAME,
            "Field_Name"=>$COLUMN_NAME
        );
        array_push($conArr, $conItem);
    }
    echo json_encode($conArr);
}
?>