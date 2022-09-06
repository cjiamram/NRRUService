<?php
class tlabel{
	private $conn;
	private $table_name;
	public function __construct($db){
            $this->conn = $db;
        	}
	public $tableName;
	public $fieldName;
	public $thLabel;
	public $enLabel;
	public $flag;
	

	public function create(){
		$query='INSERT INTO t_label  
        	SET 
			tableName=:tableName,
			fieldName=:fieldName,
			thLabel=:thLabel,
			enLabel=:enLabel,
			flag=:flag
	';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":tableName",$this->tableName);
		$stmt->bindParam(":fieldName",$this->fieldName);
		$stmt->bindParam(":thLabel",$this->thLabel);
		$stmt->bindParam(":enLabel",$this->enLabel);
		$stmt->bindParam(":flag",$this->flag);
		$flag=$stmt->execute();
		//print_r($stmt->errorInfo());
		return $flag;
	}

	public function updateLabel($id,$thLabel){
		$query="UPDATE t_label 
		SET 	
			thLabel=:thLabel 
		WHERE  
			id=:id
		";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":thLabel",$thLabel);
		$stmt->bindParam(":id",$id);
		$flag=$stmt->execute();
		return $flag;
	} 



	public function listLabel($tableName){
		$query="SELECT id,thLabel,moduleTh,tableName
		FROM t_label WHERE tableName LIKE :tableName";
		$stmt=$this->conn->prepare($query);
		$tableName="%{$tableName}%";
		$stmt->bindParam(":tableName",$tableName);
		$stmt->execute();
		return $stmt;
	}
	public function update(){
		$query='UPDATE t_label 
        	SET 
			tableName=:tableName,
			fieldName=:fieldName,
			thLabel=:thLabel,
			enLabel=:enLabel,
			flag=:flag
		 WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(":tableName",$this->tableName);
		$stmt->bindParam(":fieldName",$this->fieldName);
		$stmt->bindParam(":thLabel",$this->thLabel);
		$stmt->bindParam(":enLabel",$this->enLabel);
		$stmt->bindParam(":flag",$this->flag);
		$stmt->bindParam(":id",$this->id);
		$flag=$stmt->execute();
		return $flag;
	}
	public function readOne(){
		$query='SELECT  id,
			tableName,
			fieldName,
			thLabel,
			enLabel,
			flag
		FROM t_label WHERE id=:id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id',$this->id);
		$stmt->execute();
		return $stmt;
	}

	public function listModuleTh(){
		$query="SELECT 
		DISTINCT tableName,moduleTh 
		FROM t_label WHERE moduleTh IS NOT NULL  ORDER BY moduleTh";
		$stmt=$this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	public function getId(){
		$query="SELECT  
		id
		FROM t_label 
		WHERE tableName=:tableName 
		AND fieldName=:fieldName";

	
		$stmt = $this->conn->prepare($query);
		$this->tableName=trim($this->tableName);
		$this->fieldName=trim($this->fieldName);
		$stmt->bindParam(":tableName",$this->tableName);
		$stmt->bindParam(":fieldName",$this->fieldName);
		$stmt->execute();
		
		return $stmt;

	}


	public function getData($tableName){
		$query='SELECT  id,
			tableName,
			fieldName,
			thLabel,
			enLabel
		FROM t_label WHERE tableName LIKE :tableName';
		$stmt = $this->conn->prepare($query);
		$tableName="%{$tableName}%";
		$stmt->bindParam(':tableName',$tableName);
		$stmt->execute();
		return $stmt;
	}
	function delete(){
		$query='DELETE FROM t_label WHERE id=:id';
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
		$query ="SELECT MAX(CODE) AS MXCode FROM t_label WHERE CODE LIKE ?";
		$stmt = $this->conn->prepare($query);
		$prefix="{$prefix}%";
		$stmt->bindParam(1, $prefix);
		$stmt->execute();
		return $stmt;
	}
}

?>