<?php
class ClassLabel{
        private $conn;
        public $table_name;
        public $db_name;
        
        public function __construct($db){
            $this->conn = $db;
        }

        public function getLabel($table,$fieldName,$lang){
            $query="SELECT 
                thLabel,
                enLabel 
                FROM t_label 
                WHERE 
                tableName=:tableName
                AND
                fieldName=:fieldName 
            ";
            $stmt = $this->conn->prepare( $query );
            $stmt->bindParam(":tableName",$table);   
            $stmt->bindParam(":fieldName",$fieldName);
            $stmt->execute();

            $num=$stmt->rowCount();
            if($num>0){
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    extract($row);
                    switch($lang){
                        case "TH":
                            return $thLabel;
                            break;
                        case "th":
                            return $thLabel;
                            break;
                        case "EN":
                            return $enLabel;
                            break;
                        case "en":
                            return $enLabel;
                            break;
                    }
            }
            else
            {
                return $fieldName;
            }
        }

}
?>