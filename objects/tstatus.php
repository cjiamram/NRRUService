<?php
include_once "keyWord.php";
class  tstatus{
	private $conn;
	private $table_name="t_status";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $code;
	public $status;
	public function create(){
		$query='INSERT INTO t_status  
        	SET 
			code=:code,
			status=:status
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":code",$this->code);
		$stmt->bindParam(":status",$this->status);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE t_status 
        	SET 
			code=:code,
			status=:status
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":code",$this->code);
		$stmt->bindParam(":status",$this->status);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			code,
			status
		FROM t_status WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}
	public function getData(){

		$query='SELECT  id,
			code,
			status
		FROM t_status ORDER BY code';
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}


	public function listNextStatus(){

		$query="SELECT  
			id,
			code,
			status
		FROM t_status 
		WHERE code NOT IN  ('01','','07')  ORDER BY code";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	public function listProgressStatus(){
		$query="SELECT  
			id,
			code,
			status
		FROM t_status 
		WHERE code IN ('03','04','06','08')  ORDER BY code";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}


	public function listThirdStatus(){

		$query="SELECT  
			id,
			code,
			status
		FROM t_status 
		WHERE code NOT IN  ('01','02','07')  ORDER BY code";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function delete(){
		$query='DELETE FROM t_status WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_status WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>