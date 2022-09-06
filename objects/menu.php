<?php
class Menu{
    private $conn;
       private $table_name = "t_menu";

       public $id;
       public $MenuId;
       public $MenuName;
       public $Parent;

       
       public function __construct($db){
         $this->conn = $db;
     }

   
      private function hadPrivillage($UserId){
         $query="SELECT UserId FROM t_privillage 
         WHERE UserId=:UserId";
         $stmt = $this->conn->prepare($query);
         $stmt->bindParam(":UserId",$UserId);
         $stmt->execute();
         return $stmt->rowCount();
      }


      public function setPrivillageDefault($UserId){
         if($this->hadPrivillage($UserId)<=0){
               $query="INSERT INTO t_privillage(UserId,MenuId)
               SELECT '".$UserId."' AS UserId,MenuId FROM t_menu
               WHERE enableDefault=1
               ";
               $stmt = $this->conn->prepare($query);
               $flag=$stmt->execute();
               return $flag;
         }
         return false;
      }

      public function setAuthen($userId,$menuId,$isCheck){
           
            if(intval($isCheck)===1){
               $query="INSERT INTO 
               t_privillage(UserId,MenuId)  
               VALUES(:UserId,:MenuId) 
               ";
            }else
            {
               $query="DELETE FROM t_privillage WHERE UserId=:UserId AND MenuId=:MenuId";
            }
            $stmt=$this->conn->prepare($query);
            $stmt->bindParam(":UserId",$userId);
            $stmt->bindParam(":MenuId",$menuId);
            $flag=$stmt->execute();
            return $flag;

      }

      public function getHeadMenu($UserId){
         $query="SELECT
            A.id,
            B.Topic, 
            B.MenuId,
            B.MenuName,
            B.Link,
            B.OrderNo,
            B.LevelNo,
            B.icon 
         FROM t_privillage A INNER JOIN t_menu B ON 
         A.MenuId=B.MenuId WHERE A.UserId=? AND B.LevelNo=0
         ORDER BY B.OrderNo ASC
            ";
         $stmt = $this->conn->prepare($query);
         $stmt->bindParam(1,$UserId);
         $stmt->execute();
         return $stmt;
      }



      public function getChildMenu($UserId,$Parent){
          $query="SELECT
               A.id,
               B.Topic, 
               B.MenuId,
               B.MenuName,
               B.Link,
               B.OrderNo,
               B.LevelNo
            FROM t_privillage A INNER JOIN t_menu B ON 
            A.MenuId=B.MenuId WHERE A.UserId=? AND B.Parent=?
            ORDER BY B.OrderNo ASC 
            ";
         $stmt = $this->conn->prepare($query);
         $stmt->bindParam(1,$UserId);
         $stmt->bindParam(2,$Parent);
         $stmt->execute();
         return $stmt;
      }


      public function listHeadMenu(){
         $query="SELECT MenuId,MenuName,LevelNo FROM t_menu 
         WHERE LevelNo=0  ORDER BY OrderNo";
         $stmt=$this->conn->prepare($query);
         $stmt->execute();
         return $stmt;
      }

      public function listChildMenu($parent){
         $query="SELECT MenuId,MenuName,LevelNo FROM t_menu 
         WHERE LevelNo=1 AND  Parent=:parent ORDER BY OrderNo";
         $stmt=$this->conn->prepare($query);
         $stmt->bindParam(":parent",$parent);
         $stmt->execute();
         return $stmt;
      }

      public function isMenuExist($menuId,$userId){
         $query="SELECT COUNT(id) AS CNT 
         FROM t_privillage  
         WHERE 
         menuId=:menuId AND userId=:userId";
         $stmt=$this->conn->prepare($query);
         $stmt->bindParam(":menuId",$menuId);
         $stmt->bindParam(":userId",$userId);
         $stmt->execute();
         $row=$stmt->fetch(PDO::FETCH_ASSOC);
         extract($row);
         $flag=($CNT>0)?true:false;
         return  $CNT; 
      }





      public function listMenu($UserId){
         $query="SELECT
            A.id,
            B.Topic, 
            B.MenuId,
            B.MenuName,
            B.Link,
            B.OrderNo,
            B.LevelNo,
            B.PrettyLink 
         FROM t_privillage A INNER JOIN 
         t_menu B ON 
         A.MenuId=B.MenuId 
         WHERE A.UserId=? AND B.LevelNo=0
         ORDER BY B.OrderNo ASC
         ";
         $stmt = $this->conn->prepare($query);
         $stmt->bindParam(1,$UserId);
         $stmt->execute();
         return $stmt;
       }
}

?>