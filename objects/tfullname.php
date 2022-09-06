<?php
include_once "keyWord.php";
class  tfullname{
	private $conn;
	private $table_name="t_fullname";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $userCode;
	public $fullName;
	public $departmentCode;
	//public $staffType;
	public function create(){
		$query='INSERT INTO t_fullname  
        	SET 
			userCode=:userCode,
			fullName=:fullName,
			departmentCode=:departmentCode
			
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":fullName",$this->fullName);
		$stmt->bindParam(":departmentCode",$this->departmentCode);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE t_fullname 
        	SET 
			userCode=:userCode,
			fullName=:fullName,
			departmentCode=:departmentCode
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":fullName",$this->fullName);
		$stmt->bindParam(":departmentCode",$this->departmentCode);

		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}

	public function isExist($userCode){
		$query="SELECT userCode FROM t_fullname 
		WHERE userCode=:userCode" ;
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":userCode",$userCode);
		$stmt->execute();
		if($stmt->rowCount()>0)
			return true;
		else 
			return false;
	}

	public function readOne(){
		$query='SELECT  id,
			userCode,
			fullName,
			departmentCode
		FROM t_fullname WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}
	public function getData($keyWord){
	
		$query="SELECT  id,
			userCode,
			fullName,
			departmentCode
		FROM t_fullname 
		WHERE concat(userCode,' ',fullName) 
		LIKE :keyWord 
		";
		$stmt = $this->conn->prepare($query);
		$keyWord="%{$keyWord}%";
		$stmt->bindParam(":keyWord",$keyWord);
		$stmt->execute();
		return $stmt;
	}
	function delete(){
		$query='DELETE FROM t_fullname WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function genCode(){
		$curYear = date("Y")-2000+543;
		$curYear = substr($curYear,1,2);
		$curYear = sprintf("%02d", $curYear);
		$curMonth=date("n");
		$curMonth = sprintf("%02d",$curMonth);
		$prefix= $curYear .$curMonth;
		$query ="SELECT MAX(CODE) AS MXCode FROM t_fullname WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>