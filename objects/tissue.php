<?php
include_once "keyWord.php";
include_once "manage.php";
class  tissue{
	private $conn;
	private $table_name="t_issue";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $staffId;
	public $roomNo;
	public $floorNo;
	public $building;
	public $telNo;
	public $lineNo;
	public $createDate;
	public $issueType;
	public $issueDetail;
	public $notifyBy;
	public $status;
	
	public function getEvaluation(){
		$query="SELECT AVG(evaluateLevel) AS  avgEva,B.issueType  FROM t_issue A INNER JOIN t_issuetype B 
		ON A.`issueType`=B.`code` GROUP BY B.issueType";
		$stmt=$this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}	


	public function getProgressWork($userCode){
		$query="SELECT COUNT(id) AS CNT 
		FROM t_issue 
		WHERE staffId=:userCode AND status='03'";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":userCode",$userCode);
		$stmt->execute();
		if($stmt->rowCount()>0){
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			extract($row);
			return $CNT;
		}
		return 0;
	}

	public function getQueue($id,$issueType){
		$query="SELECT COUNT(id) AS CNT 
		FROM t_issue WHERE STATUS IN ('01','02','03') 
		AND issueType=:issueType
		AND id<:id
		ORDER BY createDate ";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":id",$id);
		$stmt->bindParam(":issueType",$issueType);
		$stmt->execute();
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
		extract($row);
		return $CNT+1;
	}


	public function getNewWorkAll(){
		$query="SELECT COUNT(id) AS CNT 
		FROM t_issue WHERE status IN ('01','02')";
		$stmt=$this->conn->prepare($query);
		//$stmt->bindParam(":userCode",$userCode);
		$stmt->execute();
		if($stmt->rowCount()>0){
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			extract($row);
			return $CNT;
		}
		return 0;
	}

	public function getProgressWorkAll(){
		$query="SELECT COUNT(id) AS CNT 
		FROM t_issue WHERE status='03'";
		$stmt=$this->conn->prepare($query);
		//$stmt->bindParam(":userCode",$userCode);
		$stmt->execute();
		if($stmt->rowCount()>0){
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			extract($row);
			return $CNT;
		}
		return 0;
	}

	public function getCompleteWorkAll(){
		$query="SELECT COUNT(id) AS CNT 
		FROM t_issue WHERE status='04'";
		$stmt=$this->conn->prepare($query);
		$stmt->execute();
		if($stmt->rowCount()>0){
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			extract($row);
			return $CNT;
		}
		return 0;
	}

	public function updateEvaluate($id,$evaluateLevel,$evaluateMessage){
		$query="UPDATE t_issue SET 
			evaluateLevel=:evaluateLevel,
			evaluateMessage=:evaluateMessage,
			isEvaluate=1
		WHERE id=:id";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":evaluateLevel",$evaluateLevel);
		$stmt->bindParam(":evaluateMessage",$evaluateMessage);
		$stmt->bindParam(":id",$id);
		$flag=$stmt->execute();
		return $flag;
	}

	public function getCountCompleteByUser($userCode){
		$query="SELECT  
			id
		FROM t_issue 
		WHERE status ='04' 
		AND staffId=:userCode
		AND  isEvaluate<>1";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":userCode",$userCode);
		$stmt->execute();
		$flag=$stmt->rowCount()>0?true:false;
		return $flag;

	}

	public function getCompleteWorkByUser($userCode){
		$query="SELECT  
			A.id,
			A.staffId,
			CONCAT('อาคาร:',B.building,' ชั้น:',A.floorNo,' ห้อง:',A.roomNo) AS Location,
			A.telNo,
			A.lineNo,
			A.createDate,
			C.issueType,
			A.issueDetail,
			A.notifyBy,
			D.status
		FROM t_issue A 
		LEFT OUTER JOIN t_building B
		ON A.building=B.code
		LEFT OUTER JOIN t_issuetype C
		ON A.issueType=C.code
		LEFT OUTER JOIN t_status D ON 
		A.status=D.code
		WHERE A.status ='04' 
		AND A.staffId=:userCode
		AND A.isEvaluate<>1
		ORDER BY A.id DESC";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":userCode",$userCode);
		$stmt->execute();
		return $stmt;
	
	}


	public function getFailWorkAll(){
		$query="SELECT COUNT(id) AS CNT 
		FROM t_issue WHERE status='08'";
		$stmt=$this->conn->prepare($query);
		//$stmt->bindParam(":userCode",$userCode);
		$stmt->execute();
		if($stmt->rowCount()>0){
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			extract($row);
			return $CNT;
		}
		return 0;
	}


	public function getSumaryByIssueType(){
		$query="SELECT 
			COUNT(A.id) AS CNT,B.issueType 
		FROM t_issue A 
		INNER JOIN 
		t_issuetype B 
		ON A.issuetype=B.code
		GROUP BY  B.issueType";

		$stmt=$this->conn->prepare($query);
		$stmt->execute();
		return $stmt;

	}

	public function randColor() {
    	return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
	}


	public function getSumaryAssignment(){
		$query="SELECT COUNT(A.id) AS CNT,F.workGroup 
		FROM t_issue A INNER  JOIN t_assign B 
		ON A.id =B.issueId INNER JOIN t_staff C
		ON B.receiveBy COLLATE utf8_general_ci = C.username COLLATE utf8_general_ci
		INNER JOIN t_workgroup F ON C.workgroupid=F.code
		GROUP BY F.workGroup";

		$stmt=$this->conn->prepare($query);
		$stmt->execute();
		return $stmt;

	}


	public function getLastId(){
		$query="SELECT MAX(id) AS id FROM t_issue ";
		$stmt=$this->conn->prepare($query);
		$stmt->execute();
		if($stmt->rowCount()>0){
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			extract($row);
			return $id;
		}
		else
			return 0;
	}
	
	public function getIssueDetail($id){
		$query="SELECT issueDetail FROM t_issue WHERE id=:id";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":id",$id);
		$stmt->execute();
		if($stmt->rowCount()>0){
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			extract($row);
			return $issueDetail;
		}else
		return "";
	}


	public function create(){
		$query='INSERT INTO t_issue  
        	SET 
			staffId=:staffId,
			roomNo=:roomNo,
			floorNo=:floorNo,
			building=:building,
			telNo=:telNo,
			lineNo=:lineNo,
			createDate=:createDate,
			issueType=:issueType,
			issueDetail=:issueDetail,
			notifyBy=:notifyBy,
			status=:status,
			isEvaluate=0
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":staffId",$this->staffId);
		$stmt->bindParam(":roomNo",$this->roomNo);
		$stmt->bindParam(":floorNo",$this->floorNo);
		$stmt->bindParam(":building",$this->building);
		$stmt->bindParam(":telNo",$this->telNo);
		$stmt->bindParam(":lineNo",$this->lineNo);
		$stmt->bindParam(":createDate",$this->createDate);
		$stmt->bindParam(":issueType",$this->issueType);
		$stmt->bindParam(":issueDetail",$this->issueDetail);
		$stmt->bindParam(":notifyBy",$this->notifyBy);
		$stmt->bindParam(":status",$this->status);
		$flag=$stmt->execute();
		return $flag;
	}

	public function updateStatus($id,$status){
		$query="UPDATE t_issue 
		SET status=:status 
		WHERE id=:id";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":id",$id);
		$stmt->bindParam(":status",$status);
		$flag=$stmt->execute();
		return $flag;
	}


	public function getAssignStatus($issueId){
		$query="SELECT progressStatus 
		FROM t_assignstaff 
		WHERE issueId=:issueId";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":issueId",$issueId);
		$stmt->execute();
		if($stmt->rowCount()>0){
			if($stmt->rowCount()==1){
				$row=$stmt->fetch(PDO::FETCH_ASSOC);
				extract($row);
				return array("flag"=>true,"status"=>$progressStatus);

			}else{
				return array("flag"=>false);
			}
		}
		return array("flag"=>false);
	}

	public function updateStatusByAssign($issueId){
		$data=$this->getAssignStatus($issueId);
		if($data["flag"]==true){
			$flag=$this->updateStatus($issueId,$data["status"]);
			return $flag;
		}
		return false;
	}

	

	public function update(){
		$query='UPDATE t_issue 
        	SET 
			staffId=:staffId,
			roomNo=:roomNo,
			floorNo=:floorNo,
			building=:building,
			telNo=:telNo,
			lineNo=:lineNo,
			createDate=:createDate,
			issueType=:issueType,
			issueDetail=:issueDetail,
			notifyBy=:notifyBy,
			isEvaluate=0
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":staffId",$this->staffId);
		$stmt->bindParam(":roomNo",$this->roomNo);
		$stmt->bindParam(":floorNo",$this->floorNo);
		$stmt->bindParam(":building",$this->building);
		$stmt->bindParam(":telNo",$this->telNo);
		$stmt->bindParam(":lineNo",$this->lineNo);
		$stmt->bindParam(":createDate",$this->createDate);
		$stmt->bindParam(":issueType",$this->issueType);
		$stmt->bindParam(":issueDetail",$this->issueDetail);
		$stmt->bindParam(":notifyBy",$this->notifyBy);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			staffId,
			roomNo,
			floorNo,
			building,
			telNo,
			lineNo,
			createDate,
			issueType,
			issueDetail,
			notifyBy,
			status
		FROM t_issue WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}


	public function readOneNotify(){
		$query='SELECT  A.id,
			A.staffId,
			A.roomNo,
			A.floorNo,
			A.building,
			A.telNo,
			A.lineNo,
			A.createDate,
			C.issueType,
			A.issueDetail,
			A.notifyBy,
			B.status
		FROM t_issue A 
		LEFT OUTER JOIN t_status B 
		ON A.status=B.code 
		LEFT OUTER JOIN t_issuetype C 
		ON A.issueType=C.code 

		WHERE A.id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}



	public function getRequestByStatus($status){
		$query="SELECT  
			A.id,
			A.staffId,
			CONCAT('อาคาร:',B.building,' ชั้น:',A.floorNo,' ห้อง:',A.roomNo) AS Location,
			A.telNo,
			A.lineNo,
			A.createDate,
			C.issueType,
			A.issueDetail,
			A.notifyBy,
			D.status
		FROM t_issue A 
		INNER JOIN t_building B
		ON A.building=B.code
		INNER JOIN t_issuetype C
		ON A.issueType=C.code
		INNER JOIN t_status D ON 
		A.status=D.code
		WHERE A.status =:status
		AND A.isEvaluate=0
		ORDER BY A.id DESC "; 
		//print_r($status);
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":status",$status);
		$stmt->execute();
		
		return $stmt;
	}



	public function getRequestByAdvanceStatus($status,$keyWord,$issueType,$requestDate){
		$query="SELECT  
			A.id,
			A.staffId,
			CONCAT('อาคาร:',B.building,' ชั้น:',A.floorNo,' ห้อง:',A.roomNo) AS Location,
			A.telNo,
			A.lineNo,
			A.createDate,
			C.issueType,
			A.issueDetail,
			A.notifyBy,
			D.status
		FROM t_issue A 
		INNER JOIN t_building B
			ON A.building=B.code
		INNER JOIN t_issuetype C
			ON A.issueType=C.code
		INNER JOIN t_status D 
			ON A.status=D.code
		WHERE 
			A.status =:status
		AND 
			CONCAT(A.issueDetail,' ',A.notifyBy) LIKE :keyWord 
		AND 
			A.issueType LIKE :issueType 
		AND
			A.createDate LIKE :requestDate
		AND A.isEvaluate=0
		
		ORDER BY A.id DESC "; 
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":status",$status);
		$keyWord="%{$keyWord}%";
		$stmt->bindParam(":keyWord",$keyWord);
		$issueType="{$issueType}%";
		$stmt->bindParam(":issueType",$issueType);
		if($requestDate!=="")
			$requestDate=Format::getSystemDate($requestDate);
		else
			$requestDate="%";
		$stmt->bindParam(":requestDate",$requestDate);
		$stmt->execute();
		return $stmt;
	}


	public function getDataAll(){
		$query='SELECT  id,
			staffId,
			roomNo,
			floorNo,
			building,
			telNo,
			lineNo,
			createDate,
			issueType,
			issueDetail,
			notifyBy,
			status
		FROM t_issue WHERE status NOT IN (4,6)
		AND A.isEvaluate=0
		ORDER BY createDate DESC ';//Sucess Or Fail 
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	public function getDataByStaff($staffId){
		$query="SELECT  
			A.id,			
			A.createDate,
			A.issueType AS issueTypeCode,
			B.issueType AS issueType,
			A.issueDetail,
			A.notifyBy,
			A.status AS statusCode,
			C.status
		FROM t_issue A LEFT OUTER JOIN
		t_issuetype B 
		ON A.issueType=B.code 
		LEFT OUTER JOIN
		t_status C ON A.status=C.code  
		WHERE 
		A.status  <> '04' 
		AND A.staffId=:staffId
		AND A.isEvaluate=0
		ORDER BY A.id DESC
		
		";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':staffId',$staffId);
		$stmt->execute();
		return $stmt;
	}

	public function getAdvanceByStaff($staffId,$keyWord,$issueType,$requestDate){
		$query="SELECT  
			A.id,			
			A.createDate,
			A.issueType AS issueTypeCode,
			B.issueType AS issueType,
			A.issueDetail,
			A.notifyBy,
			A.status AS statusCode,
			C.status
		FROM t_issue A INNER JOIN
		t_issuetype B 
		ON A.issueType=B.code 
		INNER JOIN
		t_status C ON A.status=C.code  
		WHERE 
		A.status NOT IN ('04') 
		AND A.staffId=:staffId
		AND (
				CONCAT(A.issueDetail,A.notifyBy) LIKE :keyWord 
			OR 
				A.createDate=:requestDate
			OR
				A.issueType=:issueType

			)
		ORDER BY A.id DESC
		";
		//print_r($staffId);
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':staffId',$staffId);
		$keyWord="%{$keyWord}%";
		$stmt->bindParam(':keyWord',$keyWord);
		$stmt->bindParam(':issueType',$issueType);
		$requestDate=Format::getSystemDate($requestDate);
		$stmt->bindParam(':requestDate',$requestDate);

		$stmt->execute();
		return $stmt;
	}

	public function getDataByResponsder($userCode,$status){
		$status="{$status}%";
		$query="SELECT  
			A.id,			
			A.createDate,
			A.issueType AS issueTypeCode,
			B.issueType AS issueType,
			A.issueDetail,
			A.notifyBy,
			A.status AS statusCode,
			C.status
		FROM t_issue A 
			LEFT OUTER JOIN
			t_issuetype B 
				ON A.issueType=B.code 
			LEFT OUTER JOIN
			t_status C 
				ON A.status=C.code  
		WHERE
		A.status=:status 
		
		ORDER BY A.id DESC";

		$stmt=$this->conn->prepare($query);

		if($userCode==="Admin"){
			$userCode="%";
		}

		$stmt->bindParam(":userCode",$userCode);
		$stmt->bindParam(":status",$status);
		$stmt->execute();
		return $stmt;	
	}

	public function getWorkInprogress($issueId){
		$query="SELECT detail,
		operatingDate,
		progress 
		FROM t_issuetracking 
		WHERE issueId=:issueId";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":issueId",$issueId);
		$stmt->execute();
		return $stmt;
	}

	public function getBySupporter($userCode,$status){
		$status="%{$status}%";

		

		$query="SELECT 
			DISTINCT 	
				A.id,			
				A.createDate,
				A.issueType AS issueTypeCode,
				C.issueType AS issueType,
				A.issueDetail,
				A.notifyBy,
				A.issueDetail,
				B.progressStatus AS statusCode,
				D.status AS progressStatus,
				A.status

			FROM t_issue A INNER JOIN 
			t_assignstaff B 
			ON A.id =B.issueid
			INNER JOIN t_issuetype C 
			ON A.issueType=C.code
			INNER JOIN t_status D 
			ON B.progressStatus=D.code
			WHERE B.userCode=:userCode
			AND D.code LIKE :status
		";



		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":userCode",$userCode);
		$stmt->bindParam(":status",$status);
		$stmt->execute();
		return $stmt;	
	} 

	public function getDataBySupport($userCode,$status){
		$status="%{$status}%";
		

		$query="SELECT  
			A.id,			
			A.createDate,
			A.issueType AS issueTypeCode,
			B.issueType AS issueType,
			A.issueDetail,
			A.notifyBy,
			A.status AS statusCode,
			C.status
		FROM t_issue A 
			LEFT OUTER JOIN
			t_issuetype B 
				ON A.issueType=B.code 
			LEFT OUTER JOIN
			t_status C 
				ON A.status=C.code  
		WHERE 
			(
				A.id IN (SELECT issueId FROM t_assign
				WHERE receiveBy LIKE :userCode 
				) 
				OR 
				A.id IN 
				(SELECT issueId FROM 
				t_assignStaff WHERE UserCode=:userCode)
			
			)
		AND A.status LIKE :status
		ORDER BY A.id DESC";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":userCode",$userCode);
		$stmt->bindParam(":status",$status);
		$stmt->execute();
		return $stmt;	

	}

	public function getDataByDate($sDate,$fDate){
		$query='SELECT  id,
			staffId,
			roomNo,
			floorNo,
			building,
			telNo,
			lineNo,
			createDate,
			issueType,
			issueDetail,
			notifyBy,
			status
		FROM t_issue WHERE '.$key.' 
		LIKE :keyWord';
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	public function getIssueReport($userCode,$sDate,$fDate){
		$query="SELECT
			A.id, 
			A.issueDetail,
			A.notifyBy,
			A.telNo,
			B.issueType,
			A.createDate
		FROM t_issue A 
		INNER JOIN 
		t_issuetype B 
		ON A.issueType=B.code
		WHERE A.id 
		IN
		(	
			SELECT issueId 
			FROM t_assign 
			WHERE receiveBy=:userCode AND status IN('04','06') 
		) AND  A.createDate BETWEEN :sDate AND :fDate	
		";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":userCode",$userCode);
		$stmt->bindParam(":sDate",$sDate);
		$stmt->bindParam(":fDate",$fDate);
		$stmt->execute();
		return $stmt;
	}

	public function getIssueTracking($issueId){
		$query="SELECT 
		A.detail,
		A.operatingDate,
		A.progress,
		B.status 
		FROM t_issuetracking A 
		INNER JOIN 
		t_status B 
		ON A.issueId=B.code
		WHERE A.issueId=:issueId
		";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":issueId",$issueId);
		$stmt->execute();
		return $stmt;
	}
	


	function delete(){
		$query='DELETE FROM t_issue WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_issue WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>