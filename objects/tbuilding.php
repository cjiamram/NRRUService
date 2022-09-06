<?php
include_once "keyWord.php";
class  tbuilding{
	private $conn;
	private $table_name="t_building";
	public function __construct($db){
            $this->conn = $db;
        	}
	public $code;
	public $building;
	public function create(){
		$query='INSERT INTO t_building  
        	SET 
			code=:code,
			building=:building
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":code",$this->code);
		$stmt->bindParam(":building",$this->building);
		$flag=$stmt->execute();
		return $flag;
	}
	public function update(){
		$query='UPDATE t_building 
        	SET 
			code=:code,
			building=:building
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":code",$this->code);
		$stmt->bindParam(":building",$this->building);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			code,
			building
		FROM t_building WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}

	public function listBuilding(){
		$query='SELECT  id,
			code,
			building
		FROM t_building ORDER BY code';
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	public function getData($keyWord){
		//$key=KeyWord::getKeyWord($this->conn,$this->table_name);
		//$key=($key!="")?$key:"keyWord";
		$query='SELECT  id,
			code,
			building
		FROM t_building WHERE building LIKE :keyWord';
		$stmt = $this->conn->prepare($query);
		$keyWord="%{$keyWord}%";
		$stmt->bindParam(':keyWord',$keyWord);
		$stmt->execute();
		return $stmt;
	}
	function delete(){
		$query='DELETE FROM t_building WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_building WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>