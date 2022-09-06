<?php
include_once "keyWord.php";
class  tmenu{
	private $conn;
	private $table_name="t_menu";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $MenuId;
	public $MenuName;
	public $Link;
	public $Parent;
	public $OrderNo;
	public $LevelNo;
	public $Topic;
	public $enableDefault;
	public function create(){
		$query='INSERT INTO t_menu  
        	SET 
			MenuId=:MenuId,
			MenuName=:MenuName,
			Link=:Link,
			Parent=:Parent,
			OrderNo=:OrderNo,
			LevelNo=:LevelNo,
			Topic=:Topic,
			enableDefault=:enableDefault
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":MenuId",$this->MenuId);
		$stmt->bindParam(":MenuName",$this->MenuName);
		$stmt->bindParam(":Link",$this->Link);
		$stmt->bindParam(":Parent",$this->Parent);
		$stmt->bindParam(":OrderNo",$this->OrderNo);
		$stmt->bindParam(":LevelNo",$this->LevelNo);
		$stmt->bindParam(":Topic",$this->Topic);
		$stmt->bindParam(":enableDefault",$this->enableDefault);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE t_menu 
        	SET 
			MenuId=:MenuId,
			MenuName=:MenuName,
			Link=:Link,
			Parent=:Parent,
			OrderNo=:OrderNo,
			LevelNo=:LevelNo,
			Topic=:Topic,
			enableDefault=:enableDefault
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":MenuId",$this->MenuId);
		$stmt->bindParam(":MenuName",$this->MenuName);
		$stmt->bindParam(":Link",$this->Link);
		$stmt->bindParam(":Parent",$this->Parent);
		$stmt->bindParam(":OrderNo",$this->OrderNo);
		$stmt->bindParam(":LevelNo",$this->LevelNo);
		$stmt->bindParam(":Topic",$this->Topic);
		$stmt->bindParam(":enableDefault",$this->enableDefault);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			MenuId,
			MenuName,
			Link,
			Parent,
			OrderNo,
			LevelNo,
			Topic,
			enableDefault
		FROM t_menu WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}

	public function listHeader(){
		$query='SELECT  id,
			MenuId,
			MenuName,
			icon
		FROM t_menu WHERE LevelNo = 0
		';
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;

	}

	public function listChild($parent){
		$query='SELECT  
			id,
			MenuId,
			MenuName
		FROM t_menu 
		WHERE LevelNo = 1
		AND Parent=:parent 
		';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":parent",$parent);
		$stmt->execute();
		return $stmt;

	}

	public function getData($keyWord){
		$query='SELECT  id,
			MenuId,
			MenuName,
			Link,
			Parent,
			OrderNo,
			LevelNo,
			Topic,
			enableDefault
		FROM t_menu WHERE MenuName LIKE :keyWord
		ORDER BY LevelNo,OrderNo,MenuId
		';
		$stmt = $this->conn->prepare($query);
		$keyWord="%{$keyWord}%";
		$stmt->bindParam(':keyWord',$keyWord);
		$stmt->execute();
		return $stmt;
	}

	
	function delete(){
		$query='DELETE FROM t_menu WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$flag=$stmt->execute();
		return $flag;
	}

	public function isUserExist($userCode){
		$query="SELECT UserId 
		FROM t_privillage 
		WHERE UserId=:userCode";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":userCode",$userCode);
		$stmt->execute();
		if($stmt->rowCount()>0){
			return true;	
		}
		return false;


	}

	public function setDefaultMenu($userCode){
		
		if($this->isUserExist($userCode)==false){

			$query="INSERT 
			INTO t_privillage(UserId,MenuId)
			SELECT '".$userCode."',MenuId 
			FROM t_menu WHERE enableDefault=1
			";
			$stmt=$this->conn->prepare($query);
			$flag=$stmt->execute();
			return $flag;
		}else
		return true;

	}


	public function genCode(){
		$curYear = date("Y")-2000+543;
		$curYear = substr($curYear,1,2);
		$curYear = sprintf("%02d", $curYear);
		$curMonth=date("n");
		$curMonth = sprintf("%02d",$curMonth);
		$prefix= $curYear .$curMonth;
		$query ="SELECT MAX(CODE) AS MXCode FROM t_menu WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>