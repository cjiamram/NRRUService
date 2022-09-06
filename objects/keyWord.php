<?php
	class  KeyWord{
	  private $conn;
      private $table_name = "t_keyword";
      public $id;
      public $tableName;
      public $fieldName;

   	 
     public function __construct($db){
        	$this->conn = $db;
     }

     public static  function getKeyWord($conn,$tableName){
     	$query="SELECT 
     	fieldName 
     	FROM 
     	t_keyword 
     	WHERE tableName=:tableName
     	";  
           
     	$stmt = $conn->prepare($query);
     	$stmt->bindParam(":tableName",$tableName);
     	$stmt->execute();
     	$num=$stmt->rowCount();
        //print_r($num);
     	$keyWord="CONCAT(";
     	$i=0;
     	if($num>0){

     		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
     			extract($row);
     			$keyWord.=($i++<$num-1)?$fieldName.",":$fieldName;
     		}

     	}

     	$keyWord.=")";
        return $keyWord; 
     }

	}
?>