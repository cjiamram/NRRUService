<?php
include_once "keyWord.php";
class  tissuetracking{
	private $conn;
	private $table_name="t_issuetracking";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $issueId;
	public $staffCode;
	public $detail;
	public $status;
	public $operatingDate;
	public $progress;
	

	public function getTrackingComplete($issueId){
		$query="SELECT detail AS fixProblem, operatingDate AS createDate 
		FROM t_issuetracking 
		WHERE issueId=:issueId AND status='04' ";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":issueId",$issueId);
		$stmt->execute();
		if($stmt->rowCount()>0){
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			extract($row);
			return array("fixProblem"=>$fixProblem,"createDate"=>$createDate); 		
		}
		else
			return array("fixProblem"=>"","createDate"=>"","message"=>"");
	}

	public function create(){
		$query='INSERT INTO t_issuetracking  
        	SET 
			issueId=:issueId,
			staffCode=:staffCode,
			detail=:detail,
			status=:status,
			operatingDate=:operatingDate,
			progress=:progress
	';

		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":issueId",$this->issueId);
		$stmt->bindParam(":staffCode",$this->staffCode);
		$stmt->bindParam(":detail",$this->detail);
		$stmt->bindParam(":status",$this->status);
		$stmt->bindParam(":operatingDate",$this->operatingDate);
		$stmt->bindParam(":progress",$this->progress);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE t_issuetracking 
        	SET 
			issueId=:issueId,
			staffCode=:staffCode,
			detail=:detail,
			status=:status,
			operatingDate=:operatingDate,
			progress=:progress
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":issueId",$this->issueId);
		$stmt->bindParam(":staffCode",$this->staffCode);
		$stmt->bindParam(":detail",$this->detail);
		$stmt->bindParam(":status",$this->status);
		$stmt->bindParam(":operatingDate",$this->operatingDate);
		$stmt->bindParam(":progress",$this->progress);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			issueId,
			staffCode,
			detail,
			status,
			operatingDate,
			progress
		FROM t_issuetracking WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}
	public function getData($issueId){
		$query='SELECT  A.id,
			A.issueId,
			A.staffCode,
			A.detail,
			A.status AS statusCode,
			A.operatingDate,
			A.progress,
			B.status
		FROM t_issuetracking A 
		INNER JOIN t_status B 
		ON A.status=B.Code
		WHERE A.issueId = :issueId';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':issueId',$issueId);
		$stmt->execute();
		return $stmt;
	}
	function delete(){
		$query='DELETE FROM t_issuetracking WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_issuetracking WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>