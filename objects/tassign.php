<?php
include_once "keyWord.php";
include_once "manage.php";
class  tassign{
	private $conn;
	private $table_name="t_assign";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $issueId;
	public $fixProblem;
	public $createDate;
	public $assignFrom;
	public $receiveBy;
	public $startDate;
	public $deuDate;
	public $realStartDate;
	public $realEndDate;
	public $status;
	public $serviceCharge;
	public $materialCharge;



	public function transferTo($issueId,$transferFrom,$transferTo){
		$query="INSERT INTO t_assign(
				issueId,
				createDate,
				fixProblem,
				assignFrom,
				receiveBy,
				startDate,
				deuDate,
				status,
				serviceCharge,
				materialCharge
			) 
		SELECT 
			issueId,
			createDate,
			'' AS fixProblem,
			'".$transferFrom."' AS assignFrom,
			'".$transferTo."' AS receiveBy,
			startDate,
			deuDate,
			'07' AS status,
			serviceCharge,
			materialCharge 
		FROM t_assign WHERE issueId=:issueId
		";


		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":issueId",$issueId);
		$flag=$stmt->execute();
		return $flag;
	}

	public function getId($issueId){
		$query="SELECT 
			id 
		FROM t_assign 
		WHERE issueId=:issueId
		";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":issueId",$issueId);
		$stmt->execute();
		if($stmt->rowCount()>0){
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			extract($row);
			return $id;
		}
		return 0;
	}

	public function updateTransfered($issueId,$assignTo,$msg){
		$query="UPDATE t_assign 
		SET status='06',assignTo=:assignTo,fixProblem=:msg 
		WHERE issueId=:issueId";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":issueId",$issueId);
		$stmt->bindParam(":assignTo",$assignTo);
		$stmt->bindParam(":msg",$msg);
		$flag=$stmt->execute();
		return $flag;
	}


	public function getAssignComplete($issueId){
		$query="SELECT fixProblem,createDate FROM t_assign 
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
	
	public function getAssignJob($userCode){
		$query="SELECT 
			A.id,
			A.issueId,
			A.fixProblem,
			A.createDate,
			A.receiveBy,
			A.assignFrom,
			A.receiveBy,
			A.startDate,
			A.deuDate,
			A.status AS statusCode,
			B.status 
		FROM t_assign  A INNER JOIN 
		t_status B ON A.status=b.code 
		WHERE receiveBy =:userCode
		 ";

		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":userCode",$userCode);
		$stmt->execute();
		return $stmt; 

	}

	public function getAssignId($issueId,$userCode){
		$query="SELECT id FROM t_assign 
		WHERE issueId=:issueId 
		AND receiveBy=:userCode";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":issueId",$issueId);
		$stmt->bindParam(":userCode",$userCode);
		$stmt->execute();
		if($stmt->rowCount()>0){
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			extract($row);
			return $id;
		}
		return 0;
	}




	public function updateTracking(){
		$query="UPDATE t_assign SET 
			fixProblem=:fixProblem,
			realStartDate=:realStartDate,
			realEndDate=:realEndDate,
			status=:status,
			assignTo='',
			serviceCharge=:serviceCharge,
			materialCharge=:materialCharge
		WHERE 
			issueId=:issueId 
		
		";

		

		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":fixProblem",$this->fixProblem);
		$stmt->bindParam(":realStartDate",$this->realStartDate) ;
		$stmt->bindParam(":realEndDate",$this->realEndDate) ;
		$stmt->bindParam(":status",$this->status) ;
		//$stmt->bindParam(":assignTo",$this->assignTo) ;
		$stmt->bindParam(":serviceCharge",$this->serviceCharge) ;
		$stmt->bindParam(":materialCharge",$this->materialCharge) ;

		$stmt->bindParam(":issueId",$this->issueId);
		//$stmt->bindParam(":receiveBy",$this->receiveBy) ;

		//rint_r($query);

		$flag=$stmt->execute();
		return $flag;
	}

	public function updateTransfer($issueId,$userCode,$reason){
		$query="UPDATE t_assign SET 
		status='06',
		fixProblem=:reason 
		WHERE issueId=:issueId 
		AND receiveBy=:userCode";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":reason",$reason);
		$stmt->bindParam(":issueId",$issueId);
		$stmt->bindParam(":userCode",$userCode);
		$flag=$stmt->execute();
		return $flag;
	}

	public function updateTranser($issueId,$userCode,$transferTo){
		$query ="INSERT INTO t_assign(
			issueId,
			createDate,
			assigFrom,
			receiveBy,
			status,
			assignTo	
		) 
		SELECT 
			issueId,
			CURDATE(),
			'".$userCode."',
			'".$transferTo."',
			'07',
			'".$transferTo."'
		FROM t_assign 
		WHERE issueId=:issueId 
		AND receiveBy=:userCode
		";

		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":issueId",$issueId);
		$stmt->bindParam(":userCode",$userCode);
		$flag=$stmt->execute();
		return $flag;


	}


	public function updateComplete(){
		$query="UPDATE t_issue SET 
			fixProblem=:fixProblem,
			realStartDate=:realStartDate,
			realEndDate=:realEndDate
		WHERE 
			id=:id";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":fixProblem",$this->fixProblem);
		$stmt->bindParam(":realStartDate",Format::getSystemDate($this->realStartDate));
		$stmt->bindParam(":realEndDate",Format::getSystemDate($this->realEndDate));
		$flag=$stmt->execute();
		return $flag;
	}

	public function create(){
		$query='INSERT INTO t_assign  
        	SET 
			issueId=:issueId,
			fixProblem=:fixProblem,
			createDate=:createDate,
			assignFrom=:assignFrom,
			receiveBy=:receiveBy,
			startDate=:startDate,
			deuDate=:deuDate,
			status=:status,
			serviceCharge=:serviceCharge,
			materialCharge=:materialCharge
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":issueId",$this->issueId);
		$stmt->bindParam(":fixProblem",$this->fixProblem);
		$stmt->bindParam(":createDate",$this->createDate);
		$stmt->bindParam(":assignFrom",$this->assignFrom);
		$stmt->bindParam(":receiveBy",$this->receiveBy);
		$stmt->bindParam(":startDate",$this->startDate);
		$stmt->bindParam(":deuDate",$this->deuDate);
		$stmt->bindParam(":status",$this->status);
		$stmt->bindParam(":serviceCharge",$this->serviceCharge) ;
		$stmt->bindParam(":materialCharge",$this->materialCharge) ;

		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query="UPDATE t_assign 
        	SET 
			issueId=:issueId,
			fixProblem=:fixProblem,
			createDate=:createDate,
			assignFrom=:assignFrom,
			receiveBy=:receiveBy,
			startDate=:startDate,
			deuDate=:deuDate,
			status=:status,
			serviceCharge=:serviceCharge,
			materialCharge=:materialCharge
		 WHERE id=:id";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":issueId",$this->issueId);
		$stmt->bindParam(":fixProblem",$this->fixProblem);
		$stmt->bindParam(":createDate",$this->createDate);
		$stmt->bindParam(":assignFrom",$this->assignFrom);
		$stmt->bindParam(":receiveBy",$this->receiveBy);
		$stmt->bindParam(":startDate",$this->startDate);
		$stmt->bindParam(":deuDate",$this->deuDate);
		$stmt->bindParam(":status",$this->status);
		$stmt->bindParam(":serviceCharge",$this->serviceCharge) ;
		$stmt->bindParam(":materialCharge",$this->materialCharge) ;

		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	
	public function readOneResponse($issueId){
		$query="SELECT 
				CONCAT(prefixName,' ',staffName,' ',staffSurname) AS Response 
				FROM t_assign A 
				INNER JOIN t_staff B 
				ON A.receiveBy=B.userName COLLATE utf8_unicode_ci
				WHERE A.issueId=:issueId
		 ";
		 $stmt=$this->conn->prepare($query);
		 $stmt->bindParam(":issueId",$issueId);
		 $stmt->execute();
		 if($stmt->rowCount()>0){
			 $row=$stmt->fetch(PDO::FETCH_ASSOC);
			 extract($row);
			 return $Response;
		 }
		 else
		 	return "";
	}


	public function readOne(){
		$query='SELECT  id,
			issueId,
			fixProblem,
			createDate,
			assignFrom,
			receiveBy,
			startDate,
			deuDate,
			realStartDate,
			realEndDate,
			status,
			serviceCharge,
			materialCharge
		FROM t_assign WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}
	public function getData($issueId){
		
		$query='SELECT  id,
			issueId,
			fixProblem,
			createDate,
			assignFrom,
			receiveBy,
			startDate,
			deuDate,
			realStartDate,
			realEndDate,
			status,
			serviceCharge,
			materialCharge
		FROM t_assign WHERE issueId LIKE :issueId';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':issueId',$issueId);
		$stmt->execute();
		return $stmt;
	}
	function delete(){
		$query='DELETE FROM t_assign WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_assign WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>