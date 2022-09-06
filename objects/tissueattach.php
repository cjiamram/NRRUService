<?php
include_once "keyWord.php";
class  tissueattach{
	private $conn;
	private $table_name="t_issueattach";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $issueId;
	public $fileAttachment;
	public function create(){
		$query='INSERT INTO t_issueattach  
        	SET 
			issueId=:issueId,
			fileAttachment=:fileAttachment
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":issueId",$this->issueId);
		$stmt->bindParam(":fileAttachment",$this->fileAttachment);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE t_issueattach 
        	SET 
			issueId=:issueId,
			fileAttachment=:fileAttachment
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":issueId",$this->issueId);
		$stmt->bindParam(":fileAttachment",$this->fileAttachment);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			issueId,
			fileAttachment
		FROM t_issueattach WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}
	public function getData($keyWord){
		$key=KeyWord::getKeyWord($this->conn,$this->table_name);
		$key=($key!="")?$key:"keyWord";
		$query='SELECT  id,
			issueId,
			fileAttachment
		FROM t_issueattach WHERE '.$key.' LIKE :keyWord';
		$stmt = $this->conn->prepare($query);
		$keyWord="%{$keyWord}%";
		$stmt->bindParam(':keyWord',$keyWord);
		$stmt->execute();
		return $stmt;
	}
	function delete(){
		$query='DELETE FROM t_issueattach WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_issueattach WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>