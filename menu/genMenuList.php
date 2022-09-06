<?php

 
include_once 'config/database.php';
include_once 'objects/menu.php';

$database = new Database();
$db = $database->getConnection();
$Menu = new Menu($db);

$user =isset($_SESSION["UserName"])?$_SESSION["UserName"]:"Admin";
$stmt=$Menu->listMenu($user);


//      row+="<li><a href=\"?page="+value.PrettyLink+"\"><i class=\"fa fa-circle-o\"></i>"+value.MenuName+"</a></li>\n";

function getChildMenu($Menu,$user,$parentMenu){

	$stmt=$Menu->getChildMenu($user,$parentMenu);
	$num=$stmt->rowCount();
	$strRow="";
	if($num>0){
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    		extract($row);
    		$strRow.="<li><a href=\"?page=".$PrettyLink."\"><i class=\"fa fa-circle-o\"></i>".$MenuName."</a></li>\n";

    	}

	}
	return $strRow;
}
/*

      row+="<li class=\"active treeview\">\n";
     row+="<a href=\"#\">\n"
     row+="<i class=\"fa fa-dashboard\"></i><span>"+value.MenuName+"</span>";
     row+="<span class=\"pull-right-container\">\n";
     row+="<i class=\"fa fa-angle-left pull-right\"></i>\n";
     row+="</span></a>\n";
     row+=getChildMenu(value.MenuId);
     row+="</li>\n";
*/

$num=$stmt->rowCount();
$strRow="";
if($num>0){
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    	extract($row);
    	$strRow.="<li class=\"active treeview\">";
    	$strRow.="<a href=\"#\">";
     	$strRow.="<i class=\"fa fa-dashboard\"></i><span>".$MenuName."</span>";
     	$strRow.="<span class=\"pull-right-container\">";
    	$strRow.="<i class=\"fa fa-angle-left pull-right\"></i>";
     	$strRow.="</span></a>";
     	$strRow.=getChildMenu($Menu,$user,$MenuId);
     	$strRow.="</li>";
    }

    echo($strRow);

}


?>