<?php
include_once "keyWord.php";
class  tstaff{
	private $conn;
	private $table_name="t_staff";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $personnelid;
	public $staffid;
	public $prefixname;
	public $staffname;
	public $staffsurname;
	public $prefixnameeng;
	public $staffnameeng;
	public $staffsurnameeng;
	public $workgroupid;
	public $departmentid;
	public $username;
	public function create(){
		$query='INSERT INTO t_staff  
        	SET 
			personnelid=:personnelid,
			staffid=:staffid,
			prefixname=:prefixname,
			staffname=:staffname,
			staffsurname=:staffsurname,
			prefixnameeng=:prefixnameeng,
			staffnameeng=:staffnameeng,
			staffsurnameeng=:staffsurnameeng,
			workgroupid=:workgroupid,
			departmentid=:departmentid,
			username=:username
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":personnelid",$this->personnelid);
		$stmt->bindParam(":staffid",$this->staffid);
		$stmt->bindParam(":prefixname",$this->prefixname);
		$stmt->bindParam(":staffname",$this->staffname);
		$stmt->bindParam(":staffsurname",$this->staffsurname);
		$stmt->bindParam(":prefixnameeng",$this->prefixnameeng);
		$stmt->bindParam(":staffnameeng",$this->staffnameeng);
		$stmt->bindParam(":staffsurnameeng",$this->staffsurnameeng);
		$stmt->bindParam(":workgroupid",$this->workgroupid);
		$stmt->bindParam(":departmentid",$this->departmentid);
		$stmt->bindParam(":username",$this->username);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE t_staff 
        	SET 
			personnelid=:personnelid,
			staffid=:staffid,
			prefixname=:prefixname,
			staffname=:staffname,
			staffsurname=:staffsurname,
			prefixnameeng=:prefixnameeng,
			staffnameeng=:staffnameeng,
			staffsurnameeng=:staffsurnameeng,
			workgroupid=:workgroupid,
			departmentid=:departmentid,
			username=:username
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":personnelid",$this->personnelid);
		$stmt->bindParam(":staffid",$this->staffid);
		$stmt->bindParam(":prefixname",$this->prefixname);
		$stmt->bindParam(":staffname",$this->staffname);
		$stmt->bindParam(":staffsurname",$this->staffsurname);
		$stmt->bindParam(":prefixnameeng",$this->prefixnameeng);
		$stmt->bindParam(":staffnameeng",$this->staffnameeng);
		$stmt->bindParam(":staffsurnameeng",$this->staffsurnameeng);
		$stmt->bindParam(":workgroupid",$this->workgroupid);
		$stmt->bindParam(":departmentid",$this->departmentid);
		$stmt->bindParam(":username",$this->username);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			personnelid,
			staffid,
			prefixname,
			staffname,
			staffsurname,
			prefixnameeng,
			staffnameeng,
			staffsurnameeng,
			workgroupid,
			departmentid,
			username
		FROM t_staff WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}

	public function getToken($userName){
		$query="SELECT token FROM t_staff WHERE userName=:userName";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":userName",$userName);
		$stmt->execute();
		if($stmt->rowCount()>0){
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			extract($row);
			return $token;
		}
	}

	public function getStaffName($userName){
		$query="SELECT 
		CONCAT(prefixname,' ',staffname,' ',staffsurname) AS staffName 
		FROM t_staff WHERE userName=:userName";
		$stmt=$this->conn->prepare($query);
		$stmt->bindParam(":userName",$userName);
		$stmt->execute();
		if($stmt->rowCount()>0){
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			extract($row);
			return $staffName;
		}
	}


	public function getData($keyWord){
		
		$query="SELECT  id,
			personnelid,
			staffid,
			prefixname,
			staffname,
			staffsurname,
			prefixnameeng,
			staffnameeng,
			staffsurnameeng,
			workgroupid,
			departmentid,
			username
		FROM t_staff WHERE  
		CONCAT(staffid,' ',prefixname,' ',staffname,' ',staffsurname)
		LIKE :keyWord";
		$stmt = $this->conn->prepare($query);
		$keyWord="%{$keyWord}%";
		$stmt->bindParam(':keyWord',$keyWord);
		$stmt->execute();
		return $stmt;
	}

	public function listStaff(){
		$query="SELECT  
			id,
			username,
			CONCAT(prefixname,' ',staffname,' ',staffsurname) AS staff
		FROM t_staff WHERE isValid=1 ORDER BY username";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	function delete(){
		$query='DELETE FROM t_staff WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_staff WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>