<?php
include_once "keyWord.php";
class  tassignstaff{
	private $conn;
	private $table_name="t_assignstaff";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $assignId;
	public $userCode;
	public $issueId;
	public $status;
	public $progressStatus;

	public function updateStatusByUser($issueId,$userCode,$progressStatus){
		$query="UPDATE t_assignstaff 
		SET progressStatus=:progressStatus 
		WHERE 
			userCode=:userCode 
		AND
			issueId=:issueId
		";

		//print_r($progressStatus);
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":userCode",$userCode);
		$stmt->bindParam(":progressStatus",$progressStatus);
		$stmt->bindParam(":issueId",$issueId);
		$flag=$stmt->execute();
		return $flag;

	}


	public function create(){
		$query='INSERT INTO t_assignstaff  
        	SET 
			assignId=:assignId,
			userCode=:userCode,
			issueId=:issueId,
			status=:status,
			progressStatus=:progressStatus
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":assignId",$this->assignId);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":issueId",$this->issueId);
		$stmt->bindParam(":status",$this->status);
		$stmt->bindParam(":progressStatus",$this->progressStatus);
		$flag=$stmt->execute();
		return $flag;
	}

	public function updateStatus($userCode,$issueId,$status){
		$query="UPDATE t_assignstaff 
		SET progressStatus=:status 
		WHERE userCode=:userCode 
		AND issueId=:issueId
		";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":userCode",$userCode);
		$stmt->bindParam(":issueId",$issueId);
		$stmt->bindParam(":status",$status);
		$flag=$stmt->execute();
		return $flag;

	}




	public function update(){
		$query='UPDATE t_assignstaff 
        	SET 
			assignId=:assignId,
			userCode=:userCode,
			issueId=:issueId,
			status=:status,
			progressStatus=:progressStatus
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":assignId",$this->assignId);
		$stmt->bindParam(":userCode",$this->userCode);
		$stmt->bindParam(":issueId",$this->issueId);
		$stmt->bindParam(":status",$this->status);
		$stmt->bindParam(":progressStatus",$this->progressStatus);

		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}

	public function deleteByIssueId($issueId){
		$query="DELETE 
		FROM t_assignstaff 
		WHERE issueId=:issueId";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":issueId",$issueId);
		$flag=$stmt->execute();
		return $flag;
	}

	public function readOne(){
		$query='SELECT  id,
			assignId,
			userCode,
			issueId,
			status
		FROM t_assignstaff WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}
	public function getData($assignId){

		$query="SELECT  
			id,
			assignId,
			userCode,
			issueId,
			status
		FROM t_assignstaff 
		WHERE assignId LIKE :assignId";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':assignId',$assignId);
		$stmt->execute();
		return $stmt;
	}


	function delete(){
		$query='DELETE FROM t_assignstaff WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_assignstaff WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>