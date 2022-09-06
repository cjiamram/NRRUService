<?php
class Data{
		public $code;
		public function __construct($db){
        	$this->conn = $db;
        }


        public function getPivotIssueStatus($sDate,$fDate){
        	$query="SELECT 
	        	CONCAT(YEARNO,'-',MONTHNO) AS yrmn,
	        	issueType,
				IF(DayDiff>60 AND statusCode='01','ไม่มีการดำเนินการ',status) AS status,
				1 AS CNT
			FROM(
				SELECT A.id,A.`staffId`,A.building,YEAR(A.createDate) AS YEARNO,
				LPAD(MONTH(A.`createDate`),2,'0') AS  MONTHNO,
				C.`issueType`,D.code AS statusCode,
				D.`status`,B.`staffCode`,
				DATEDIFF(NOW(), A.createDate) AS DayDiff
				FROM t_issue A LEFT OUTER JOIN t_issuetracking B
				ON A.`id`=B.`issueId` 
				LEFT OUTER JOIN t_issuetype C ON A.`issueType`=C.`code` 
				LEFT OUTER JOIN `t_status` D ON A.`status`=D.`code`
				WHERE createDate BETWEEN :sDate AND :fDate

			) AS V";

			$stmt=$this->conn->prepare($query);
			$stmt->bindParam(":sDate",$sDate);
			$stmt->bindParam(":fDate",$fDate);
			$stmt->execute();
			return $stmt;	
        }

        public function getMonthCountIssue($sDate,$fDate){
        	$query="SELECT CONCAT(YEARNO,'-',MONTHNO) AS yrmn,COUNT(id) AS CNT FROM
        	(
				SELECT A.id,YEAR(A.createDate) AS YEARNO,LPAD(MONTH(A.`createDate`),2,'0') AS  MONTHNO
				FROM t_issue A LEFT OUTER JOIN t_issuetracking B
				ON A.`id`=B.`issueId` 
				LEFT OUTER JOIN t_issuetype C ON A.`issueType`=C.`code` 
				LEFT OUTER JOIN `t_status` D ON A.`status`=D.`code`
				WHERE createDate BETWEEN :sDate AND :fDate

			) AS V 
			GROUP BY  CONCAT(YEARNO,'-',MONTHNO)";
			$stmt=$this->conn->prepare($query);
			$stmt->bindParam(":sDate",$sDate);
			$stmt->bindParam(":fDate",$fDate);
			$stmt->execute();
			return $stmt;
        }
		

		public function getCountStatus($yrmn){
			$query="SELECT IF(DayDiff>60 AND statusCode='01','ไม่มีการดำเนินการ',STATUS) AS STATUS,SUM(CNT) AS CNT
	 		FROM(
			SELECT 
				C.`issueType`,
				YEAR(A.createDate) AS YEARNO,
				LPAD(MONTH(A.`createDate`),2,'0') AS  MONTHNO,
				D.code AS statusCode,
				D.status,
				DATEDIFF(NOW(), A.createDate) AS dayDiff,
				1 CNT
				FROM t_issue A LEFT OUTER JOIN t_issuetracking B
				ON A.`id`=B.`issueId` 
				LEFT OUTER JOIN t_issuetype C ON A.`issueType`=C.`code` 
				LEFT OUTER JOIN `t_status` D ON A.`status`=D.`code`

			) AS V WHERE CONCAT(YEARNO,'-',MONTHNO) LIKE :yrmn
			GROUP BY IF(DayDiff>60 AND statusCode='01','ไม่มีการดำเนินการ',STATUS)";
			$stmt=$this->conn->prepare($query);
			$yrmn="{$yrmn}%";
			$stmt->bindParam(":yrmn",$yrmn);
			$stmt->execute();
			return $stmt;

		}

		public function getCountIssue($yrmn){
			$query="SELECT issueType,SUM(CNT) AS CNT
	 		FROM(
			SELECT 
				C.`issueType`,
				YEAR(A.createDate) AS YEARNO,
				LPAD(MONTH(A.`createDate`),2,'0') AS  MONTHNO,
				D.code AS statusCode,
				D.status,
				DATEDIFF(NOW(), A.createDate) AS dayDiff,
				1 CNT
				FROM t_issue A LEFT OUTER JOIN t_issuetracking B
				ON A.`id`=B.`issueId` 
				LEFT OUTER JOIN t_issuetype C ON A.`issueType`=C.`code` 
				LEFT OUTER JOIN `t_status` D ON A.`status`=D.`code`

			) AS V WHERE CONCAT(YEARNO,'-',MONTHNO) LIKE :yrmn
			GROUP BY issueType";
			$stmt=$this->conn->prepare($query);
			$yrmn="{$yrmn}%";
			$stmt->bindParam(":yrmn",$yrmn);
			$stmt->execute();
			return $stmt;

		}
}

?>