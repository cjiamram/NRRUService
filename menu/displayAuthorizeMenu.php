<?php
header("content-type:text/html;charset=UTF-8");
include_once "../config/config.php";
include_once "../lib/classAPI.php";
$cnf=new Config();
$rootPath=$cnf->path;
$userName=isset($_GET["userName"])?$_GET["userName"]:"";
$url =$cnf->restURL."menu/listAuthorizeMenu.php?userName=".$userName;

//print_r($url);


$api=new ClassAPI();
$data=$api->getAPI($url);

if(!isset($data["message"])){
	$i=1;
	echo "<tbody>\n";
	foreach ($data as $row) {
		echo "<tr>\n";
		if(intval($row["IsExist"])===1)
			$str="<input type='checkbox' onchange=\"setAuthen('".$row["MenuId"]."','#id-".$i."')\" checked id='id-".$i."'>";
		else
			$str="<input type='checkbox' onchange=\"setAuthen('".$row["MenuId"]."','#id-".$i."')\"  id='id-".$i."'>";
		if(intval($row["LevelNo"])===0){
			echo "<td>".$str."&nbsp;&nbsp;&nbsp;&nbsp;".$row["MenuName"]."<input type='hidden' id='menuId-".$i."' value='".$row["MenuId"]."'></td>\n";
		}else{
			echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$str."&nbsp;&nbsp;&nbsp;&nbsp;".$row["MenuName"]."<input type='hidden' id='menuId-".$i."' value='".$row["MenuId"]."'></td>\n";
		}
		echo "</tr>\n";
		$i++;
	}
	echo "</tbody>\n";

}



?>