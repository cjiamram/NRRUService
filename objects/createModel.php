<?php
    class CreateModel{
        private $conn;
        public $table_name;
        public $db_name;


        public function __construct($db){
            $this->conn = $db;
        }


        public function getSchema(){
            
            $query="SELECT 
                COLUMN_NAME,
                DATA_TYPE,
                COLUMN_COMMENT,
                IS_NULLABLE 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_SCHEMA=:dbName 
            AND TABLE_NAME=:tableName AND COLUMN_NAME<>'id'";
            $stmt = $this->conn->prepare( $query );   
            $stmt->bindParam(":dbName",$this->db_name);
            $stmt->bindParam(":tableName",$this->table_name);
            $stmt->execute();
            return $stmt;
        }

        public function getFieldList($dbName,$tbName){
            
            $query="SELECT 
                COLUMN_NAME
            FROM 
                INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_SCHEMA=:dbName 
            AND TABLE_NAME LIKE :tableName AND COLUMN_NAME<>'id'";
            $stmt = $this->conn->prepare( $query ); 
            $tbName="%{$tbName}%";  
            $stmt->bindParam(":dbName",$dbName);
            $stmt->bindParam(":tableName",$tbName);
            $stmt->execute();
            return $stmt;
        }

        public function getDbList(){
            $query="SELECT DISTINCT TABLE_SCHEMA AS dbName FROM INFORMATION_SCHEMA.COLUMNS  
            WHERE TABLE_SCHEMA NOT 
            IN('information_schema','mysql',
            'phpmyadmin','performance_schema')";
            $stmt = $this->conn->prepare( $query ); 
            $stmt->execute();
            return $stmt;  
        }

        public function getTbList($dbName){
            
            $query="SELECT DISTINCT TABLE_NAME 
            FROM INFORMATION_SCHEMA.COLUMNS  
            WHERE TABLE_SCHEMA=:TABLE_SCHEMA 
            ";
            $stmt = $this->conn->prepare( $query );   
            $stmt->bindParam(":TABLE_SCHEMA",$dbName);
            $stmt->execute();
            return $stmt;
        }


        public function getSchemaId(){
            
            $query="SELECT COLUMN_NAME,DATA_TYPE,COLUMN_COMMENT 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_SCHEMA=:dbName 
            AND TABLE_NAME=:tableName ";

            $stmt = $this->conn->prepare( $query );   
            $stmt->bindParam(":dbName",$this->db_name);
            $stmt->bindParam(":tableName",$this->table_name);
            $stmt->execute();
            return $stmt;
        }
    }

?>