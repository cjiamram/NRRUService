<?php
class User{
	   private $conn;
   	 private $table_name = "t_user";

   	 public $id;
   	 public $UserName;
   	 public $Password;
   	 public $Picture;

   	 
   	 public function __construct($db){
        	$this->conn = $db;
     }

     public function getUserName(){
     	$query="SELECT id,UserName,FullName,Picture,UserCode
     	FROM t_user WHERE UserName=:UserName AND Password=:Password 
     	";

      $this->Password=md5($this->Password);

     	$stmt = $this->conn->prepare($query);
   		$stmt->bindParam(":UserName",$this->UserName);
   		$stmt->bindParam(":Password",$this->Password);
   		$stmt->execute();
   		return $stmt;
     }
}

?>