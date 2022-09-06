<?php
include_once "keyWord.php";
class  ttransfer{
	private $conn;
	private $table_name="t_transfer";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $transferFrom;
	public $issueId;
	public $transferDate;
	public $transferTo;
	public $status;
	public function create(){
		$query='INSERT INTO t_transfer  
        	SET 
			transferFrom=:transferFrom,
			issueId=:issueId,
			transferDate=:transferDate,
			transferTo=:transferTo,
			status=:status
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":transferFrom",$this->transferFrom);
		$stmt->bindParam(":issueId",$this->issueId);
		$stmt->bindParam(":transferDate",$this->transferDate);
		$stmt->bindParam(":transferTo",$this->transferTo);
		$stmt->bindParam(":status",$this->status);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE t_transfer 
        	SET 
			transferFrom=:transferFrom,
			issueId=:issueId,
			transferDate=:transferDate,
			transferTo=:transferTo,
			status=:status
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":transferFrom",$this->transferFrom);
		$stmt->bindParam(":issueId",$this->issueId);
		$stmt->bindParam(":transferDate",$this->transferDate);
		$stmt->bindParam(":transferTo",$this->transferTo);
		$stmt->bindParam(":status",$this->status);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			transferFrom,
			issueId,
			transferDate,
			transferTo,
			status
		FROM t_transfer WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}
	public function getData($keyWord){
		$key=KeyWord::getKeyWord($this->conn,$this->table_name);
		$key=($key!="")?$key:"keyWord";
		$query='SELECT  id,
			transferFrom,
			issueId,
			transferDate,
			transferTo,
			status
		FROM t_transfer WHERE '.$key.' LIKE :keyWord';
		$stmt = $this->conn->prepare($query);
		$keyWord="%{$keyWord}%";
		$stmt->bindParam(':keyWord',$keyWord);
		$stmt->execute();
		return $stmt;
	}
	function delete(){
		$query='DELETE FROM t_transfer WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_transfer WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>